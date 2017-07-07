<?php
/*****************************************************************************************************************
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/9/1
 * Time: 16:33
 *****************************************************************************************************************/

namespace App\Services;

use App\Dao\RecordDao;
use App\Dao\GroupDao;
use App\Dao\GroupMemberDao;
use App\Dao\MemberGrantDao;
use App\Http\SDP_DEFINE;
use App\Models\Account;
use App\Http\Utils;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RecordService {

    function __construct()
    {

    }

    public function queryRecord($arrData){

        $RecordDao = new RecordDao();
        return $RecordDao->queryRecord($arrData);
    }

    /**根据ID获取帐号信息
     * @param 帐号$id
     * @return array
     */
    public function getRecordById($id){
        $RecordDao = new RecordDao();
        return $RecordDao->getRecordById($id);
    }

    /**
     * @param $arrData
     * @return bool
     */
    public function updateRecord($arrData){
        $RecordDao = new RecordDao();
        return $RecordDao->updateRecord($arrData);
    }

    /**
     * 创建管理员账号
     * @param
     * @return array
     */


    /**
     * 创建商家账号
     * @param
     * @return array
     */
    public function createAccountM($arrData){
        DB::transaction(function() use ($arrData) {
            $arrAccount = array();
            $arrAccount['sys_account_name'] 	= $arrData['sys_account_tel'];
            $arrAccount['sys_account_pic']      = "/assets/admin/layout/img/avatar3.jpg";
            $arrAccount['sys_account_email']    = "";
            $arrAccount['password'] 			= $arrData['password'];
            $arrAccount['sys_account_tel'] 		= $arrData['sys_account_tel'];
            $arrAccount['sys_account_status'] 	= 1; //活动状态

            $AccountDao = new AccountDao();
            $sys_account_id   = null;
            $AccountDao->insertAccount($arrAccount, $sys_account_id);

        });

        return true;
    }

    /**
     * 创建客户账号
     * @param
     * @return array
     */
    public function createAccountR($arrData){
        DB::transaction(function() use ($arrData) {
            $arrAccount = array();
            $arrAccount['sys_account_name'] 	= $arrData['sys_account_tel'];
            $arrAccount['sys_account_pic']      = "/assets/admin/layout/img/avatar3.jpg";
            $arrAccount['sys_account_email']    = "";
            $arrAccount['password'] 			= $arrData['password'];
            $arrAccount['sys_account_tel'] 		= $arrData['sys_account_tel'];
            $arrAccount['sys_account_status'] 	= 1; //活动状态
            if(isset($arrData['open_id'])) {
                $arrAccount['open_id'] = $arrData['open_id'];
            }

            //创建分销商账号
            $sys_account_id = null;
            $AccountDao = new AccountDao();
            $AccountDao->insertAccount($arrAccount, $sys_account_id);
        });

        return true;
    }


    /**删除帐号
     * @param
     * @return array
     */
    public function deleteAcccountById($account_id){
        $AccountDao = new AccountDao();
        $AccountDao->deleteAcccountById($account_id);
        //删除与账号有关的表数据

        return true;
    }

    /**更新密码
     * @param
     * @return array
     */
    public function updateAccountPwd($arrData,$id){
        $AccountDao = new AccountDao();
        $AccountDao->updateAccountPwd($arrData,$id);

        return true;
    }






}
