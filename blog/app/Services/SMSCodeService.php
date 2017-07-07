<?php

/*****************************************************************************************************************
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/9/1
 * Time: 16:33
 *****************************************************************************************************************/

namespace App\Services;

use App\Models\SMSCode;
use Carbon\Carbon;
use Sms\Request\V20160927 as Sms;

class SMSCodeService {

    /**
     * @param string $tel
     * @return string
     */
	public function make($tel) {
        $code = rand(100000,999999);
        $SMSCode = SMSCode::find($tel);
        if($SMSCode){
            $SMSCode->code = $code;
            $SMSCode->setCreatedAt(new Carbon());
            $SMSCode->save();
        }else{
            $SMSCode = new SMSCode();
            $SMSCode->sys_account_tel = $tel;
            $SMSCode->code = $code;
            $SMSCode->save();
        }
        return $code;
    }

    /**
     * @param string $tel
     * @param string $code
     * @return bool
     */
    public function sendSMSCode($tel, $code)
    {

        include_once PROJECT_ROOT.'/libs/taobao/TopSdk.php';

        $c = new \TopClient();
        $c ->appkey = "23553146" ;
        $c ->secretKey = "d8b8983d08c52c1e544edcc811ce3d99" ;
        $req = new \AlibabaAliqinFcSmsNumSendRequest();
        $req ->setExtend( "" );
        $req ->setSmsType( "normal" );
        $req ->setSmsFreeSignName( "嘟嘟订货" );
        $req ->setSmsParam( "{no:'$code'}" );
        $req ->setRecNum( $tel );
        $req ->setSmsTemplateCode( "SMS_32590180" );
        $c ->execute( $req );

        try {
            $c ->execute( $req );
        }
        catch (\ClientException  $e) {
            print_r($e->getErrorCode());
            print_r($e->getErrorMessage());
            return false;
        }
        catch (\ServerException $e) {
            print_r($e->getErrorCode());
            print_r($e->getErrorMessage());
            return false;
        }
        return true;
    }


//    public function sendSMSCode($tel, $code)
//    {
//
//        include_once PROJECT_ROOT.'/libs/aliyun-php-sdk-sms/aliyun-php-sdk-core/Config.php';
//
//        $iClientProfile = \DefaultProfile::getProfile("cn-hangzhou", "LTAICU0yBpuM2fLV", "kPSU419HuRjCOXTSx5EdZmS3nEKzGM");
//        $client = new \DefaultAcsClient($iClientProfile);
//        $request = new Sms\SingleSendSmsRequest();
//        $request->setSignName("嘟嘟订货");/*签名名称*/
//        $request->setTemplateCode("SMS_32520093");/*模板code*/
//        $request->setRecNum($tel);/*目标手机号*/
//        $request->setParamString("{\"no\":\"$code\"}");/*模板变量，数字一定要转换为字符串*/
//        try {
//            $response = $client->getAcsResponse($request);
//            print_r($response);
//        }
//        catch (\ClientException  $e) {
//            print_r($e->getErrorCode());
//            print_r($e->getErrorMessage());
//            return false;
//        }
//        catch (\ServerException $e) {
//            print_r($e->getErrorCode());
//            print_r($e->getErrorMessage());
//            return false;
//        }
//
//        return true;
//    }

    /**
     * @param $tel
     * @return SMSCode
     */
	public function getSMSCode($tel){
		return SMSCode::where('sys_account_tel',  $tel)
			->whereRaw('UNIX_TIMESTAMP(now())<=UNIX_TIMESTAMP( DATE_ADD(created_at,INTERVAL 300 SECOND))')
			->first();
	}
}
