<?php
/**
 * Created by PhpStorm.
 * User: shaoyun
 * Date: 2017/3/28
 * Time: 下午3:47
 */

namespace App\Services;


use App\Models\Account;

class WeChatAccountService
{

    private static $instance;

    /**
     * WeChatAccountService constructor.
     */
    public function __construct()
    {

    }

    public static function getInstance() {
        if(self::$instance instanceof WeChatAccountService) {
            return self::$instance;
        }
        self::$instance = new WeChatAccountService();
        return self::$instance;
    }
    /**
     * @param $openId
     * @return bool
     */
    public function createRelativeAccount($infoObj) {
        $openId = $infoObj['openid'];
        if(Account::where("open_id", "=", $openId)->exists()) {
            return true;
        }
        $arrAccount = array();
        $arrAccount['sys_account_name'] 	= $infoObj['nickname'];
        $arrAccount['sys_account_pic'] 	= $infoObj['headimgurl'];
        $arrAccount['sys_account_addr'] 	= $infoObj['country'] . " " . $infoObj['province'] . " " . $infoObj['city'];
        $arrAccount['password'] 	    = bcrypt($openId."123!@#");
        $arrAccount['open_id'] = $openId;

        $sys_account_id = null;
        $AccountService = new AccountService();
        $AccountService->createAccountW($arrAccount);
        return true;
    }

    public function updateRelativeAccount($infoObj) {
        $openId = $infoObj['openid'];
        $account=Account::where("open_id", "=", $openId)->first();
        if($account->sys_account_name == $infoObj['nickname']&&
            $account->sys_account_pic == $infoObj['headimgurl']&&
            $account->sys_account_addr == $infoObj['country'] . " " . $infoObj['province'] . " " . $infoObj['city'])
        {
        }else{
            $arrAccount = array();
            $arrAccount['sys_account_id'] 	= $account->sys_account_id;
            $arrAccount['sys_account_name'] 	= $infoObj['nickname'];
            $arrAccount['sys_account_tel'] 	= $infoObj['nickname'];
            $arrAccount['sys_account_pic'] 	= $infoObj['headimgurl'];
            $arrAccount['sys_account_addr'] 	= $infoObj['country'] . " " . $infoObj['province'] . " " . $infoObj['city'];
            $arrAccount['password'] 	    = bcrypt($openId."123!@#");
            $arrAccount['open_id'] = $openId;

            $AccountService = new AccountService();
            $AccountService->updateAccount($arrAccount);
        }
        return true;
    }
}