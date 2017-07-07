<?php
namespace App\Services;

use RuntimeException;
use League\OAuth2\Server\CryptKey;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\RefreshTokenEntityInterface;
use League\OAuth2\Server\Entities\ScopeEntityInterface;
use League\OAuth2\Server\Exception\OAuthServerException;
use League\OAuth2\Server\Exception\UniqueTokenIdentifierConstraintViolationException;
use League\OAuth2\Server\Repositories\AccessTokenRepositoryInterface;
use League\OAuth2\Server\Repositories\ClientRepositoryInterface;
use League\OAuth2\Server\Repositories\RefreshTokenRepositoryInterface;
use Laravel\Passport\Bridge;
use Laravel\Passport\Passport;


class AuthPasswordService {

    const MAX_RANDOM_TOKEN_GENERATION_ATTEMPTS = 10;
    /**
     * @var RefreshTokenRepositoryInterface
     */
    protected $refreshTokenRepository;

    /**
     * @var \DateInterval
     */
    protected $refreshTokenTTL;

    /**
     * @var CryptKey
     */
    protected $privateKey;


    public static  $instance = null;

    /**
     * AuthPasswordService constructor.
     * @param ClientRepositoryInterface $clientRepository
     * @param AccessTokenRepositoryInterface $accessTokenRepository
     * @param RefreshTokenRepositoryInterface $refreshTokenRepository
     * @param $privateKey
     */
    public function __construct(
        ClientRepositoryInterface $clientRepository,
        AccessTokenRepositoryInterface $accessTokenRepository,
        RefreshTokenRepositoryInterface $refreshTokenRepository,
        $privateKey
    ) {
        $this->clientRepository = $clientRepository;
        $this->accessTokenRepository = $accessTokenRepository;

        if ($privateKey instanceof CryptKey === false) {
            $privateKey = new CryptKey($privateKey);
        }
        $this->privateKey = $privateKey;
        $this->refreshTokenRepository = $refreshTokenRepository;
    }

    public static function getInstance()
    {
        if(!(self::$instance instanceof self)){
            $clientRepository = app()->make(Bridge\ClientRepository::class);
            $accessTokenRepository = app()->make(Bridge\AccessTokenRepository::class);
            $refreshTokenRepository = app()->make(Bridge\RefreshTokenRepository::class);
            $privateKey = 'file://'.Passport::keyPath('oauth-private.key');
            self::$instance = new self(
                $clientRepository, $accessTokenRepository, $refreshTokenRepository, $privateKey
            );
        }
        return self::$instance;
    }

    /**
     * {@inheritdoc}
     */
    public function respondAccessToken($sys_account_id)
    {
        if (is_null($grantType = config('auth.client.grant_type'))) {
            throw OAuthServerException::invalidRequest('grantType');
        }

        if (is_null($clientId = config('auth.client.client_id'))) {
            throw OAuthServerException::invalidRequest('clientId');
        }

        if (is_null($clientSecret = config('auth.client.client_secret'))) {
            throw OAuthServerException::invalidRequest('clientSecret');
        }

        if (is_null($sys_account_id)) {
            throw OAuthServerException::invalidRequest('sys_account_id');
        }

        $client = $this->clientRepository->getClientEntity(
            $clientId,
            $grantType,
            $clientSecret,
            true
        );

        $scopes = [];

        $user = $this->validateUser($sys_account_id);

        $accessTokenTTL = new \DateInterval('P1Y');

        // Issue and persist new tokens
        $accessToken = $this->issueAccessToken($accessTokenTTL, $client, $user->getIdentifier(), $scopes);
        $refreshToken = $this->issueRefreshToken($accessToken);

        $expireDateTime = $accessToken->getExpiryDateTime()->getTimestamp();

        $jwtAccessToken = $accessToken->convertToJWT($this->privateKey);

        $responseParams = [
            'token_type'   => 'Bearer',
            'expires_in'   => $expireDateTime - (new \DateTime())->getTimestamp(),
            'access_token' => (string) $jwtAccessToken,
        ];

        if ($refreshToken instanceof RefreshTokenEntityInterface) {
            $refreshToken = $this->encrypt(
                json_encode(
                    [
                        'client_id'        => $accessToken->getClient()->getIdentifier(),
                        'refresh_token_id' => $refreshToken->getIdentifier(),
                        'access_token_id'  => $accessToken->getIdentifier(),
                        'scopes'           => $accessToken->getScopes(),
                        'user_id'          => $accessToken->getUserIdentifier(),
                        'expire_time'      => $refreshToken->getExpiryDateTime()->getTimestamp(),
                    ]
                )
            );

            $responseParams['refresh_token'] = $refreshToken;
        }
        return $responseParams;
    }

    /**
     * Encrypt data with a private key.
     *
     * @param string $unencryptedData
     *
     * @throws \LogicException
     *
     * @return string
     */
    protected function encrypt($unencryptedData)
    {
        $privateKey = openssl_pkey_get_private($this->privateKey->getKeyPath(), $this->privateKey->getPassPhrase());
        $privateKeyDetails = @openssl_pkey_get_details($privateKey);
        if ($privateKeyDetails === null) {
            throw new \LogicException(
                sprintf('Could not get details of private key: %s', $this->privateKey->getKeyPath())
            );
        }

        $chunkSize = ceil($privateKeyDetails['bits'] / 8) - 11;
        $output = '';

        while ($unencryptedData) {
            $chunk = substr($unencryptedData, 0, $chunkSize);
            $unencryptedData = substr($unencryptedData, $chunkSize);
            if (openssl_private_encrypt($chunk, $encrypted, $privateKey) === false) {
                // @codeCoverageIgnoreStart
                throw new \LogicException('Failed to encrypt data');
                // @codeCoverageIgnoreEnd
            }
            $output .= $encrypted;
        }
        openssl_pkey_free($privateKey);

        return base64_encode($output);
    }

    protected function validateUser($sys_account_id)
    {
        if (is_null($sys_account_id)) {
            throw OAuthServerException::invalidRequest('sys_account_id');
        }

        if (is_null($model = config('auth.providers.users.model'))) {
            throw new RuntimeException('Unable to determine user model from configuration.');
        }

        $user = (new $model)->where('sys_account_id', $sys_account_id)->first();

        if (! $user ) {
            return;
        }
        return new Bridge\User($user->getAuthIdentifier());
    }

    /**
     * Issue an access token.
     *
     * @param \DateInterval          $accessTokenTTL
     * @param ClientEntityInterface  $client
     * @param string                 $userIdentifier
     * @param ScopeEntityInterface[] $scopes
     *
     * @throws OAuthServerException
     * @throws UniqueTokenIdentifierConstraintViolationException
     *
     * @return AccessTokenEntityInterface
     */
    protected function issueAccessToken(
        \DateInterval $accessTokenTTL,
        ClientEntityInterface $client,
        $userIdentifier,
        array $scopes = []
    ) {
        $maxGenerationAttempts = self::MAX_RANDOM_TOKEN_GENERATION_ATTEMPTS;

        $accessToken = $this->accessTokenRepository->getNewToken($client, $scopes, $userIdentifier);
        $accessToken->setClient($client);
        $accessToken->setUserIdentifier($userIdentifier);
        $accessToken->setExpiryDateTime((new \DateTime())->add($accessTokenTTL));

        foreach ($scopes as $scope) {
            $accessToken->addScope($scope);
        }

        while ($maxGenerationAttempts-- > 0) {
            $accessToken->setIdentifier($this->generateUniqueIdentifier());
            try {
                $this->accessTokenRepository->persistNewAccessToken($accessToken);

                return $accessToken;
            } catch (UniqueTokenIdentifierConstraintViolationException $e) {
                if ($maxGenerationAttempts === 0) {
                    throw $e;
                }
            }
        }
    }


    /**
     * Generate a new unique identifier.
     *
     * @param int $length
     *
     * @throws OAuthServerException
     *
     * @return string
     */
    protected function generateUniqueIdentifier($length = 40)
    {
        try {
            return bin2hex(random_bytes($length));
            // @codeCoverageIgnoreStart
        } catch (\TypeError $e) {
            throw OAuthServerException::serverError('An unexpected error has occurred');
        } catch (\Error $e) {
            throw OAuthServerException::serverError('An unexpected error has occurred');
        } catch (\Exception $e) {
            // If you get this message, the CSPRNG failed hard.
            throw OAuthServerException::serverError('Could not generate a random string');
        }
        // @codeCoverageIgnoreEnd
    }

    /**
     * @param AccessTokenEntityInterface $accessToken
     *
     * @throws OAuthServerException
     * @throws UniqueTokenIdentifierConstraintViolationException
     *
     * @return RefreshTokenEntityInterface
     */
    protected function issueRefreshToken(AccessTokenEntityInterface $accessToken)
    {
        $maxGenerationAttempts = self::MAX_RANDOM_TOKEN_GENERATION_ATTEMPTS;
        $refreshTokenTTL = new \DateInterval('P1Y');

        $refreshToken = $this->refreshTokenRepository->getNewRefreshToken();
        $refreshToken->setExpiryDateTime((new \DateTime())->add($refreshTokenTTL));
        $refreshToken->setAccessToken($accessToken);

        while ($maxGenerationAttempts-- > 0) {
            $refreshToken->setIdentifier($this->generateUniqueIdentifier());
            try {
                $this->refreshTokenRepository->persistNewRefreshToken($refreshToken);

                return $refreshToken;
            } catch (UniqueTokenIdentifierConstraintViolationException $e) {
                if ($maxGenerationAttempts === 0) {
                    throw $e;
                }
            }
        }
    }
}
