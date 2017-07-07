<?php
/*****************************************************************************************************************
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/9/1
 * Time: 16:33
 *****************************************************************************************************************/

namespace App\Services;

use App\Dao\PointDao;
use App\Dao\GroupDao;
use App\Dao\GroupMemberDao;
use App\Dao\MemberGrantDao;
use App\Http\SDP_DEFINE;
use App\Models\Account;
use App\Http\Utils;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PointService {

    function __construct()
    {

    }

    public function queryPoint($arrData){

        $PointDao = new PointDao();
        return $PointDao->queryPoint($arrData);
    }

    /**根据ID获取帐号信息
     * @param 帐号$id
     * @return array
     */
    public function getPointById($id){
        $PointDao = new PointDao();
        return $PointDao->getPointById($id);
    }

    /**
     * @param $arrData
     * @return bool
     */
    public function updateAccount($arrData){
        $AccountDao = new AccountDao();
        return $AccountDao->updateAccount($arrData);
    }

    /**新增
     * @param
     * @return array
     */
    public function insertAccount($arrData){
        $AccountDao = new AccountDao();
        return $AccountDao->insertAccount($arrData);
    }

    /**
     * 创建管理员账号
     * @param
     * @return array
     */
    public function createAccountE($arrData){
        DB::transaction(function() use ($arrData) {
            $arrAccount = array();
            $arrAccount['sys_account_name'] 	= $arrData['sys_account_tel'];
            $arrAccount['sys_account_pic']      = "";
            $arrAccount['sys_account_email']    = "";
            $arrAccount['password'] 			= $arrData['password'];
            $arrAccount['s_role_id'] 	        = SDP_DEFINE::ROLE_EMPLOYEE; //管理员角色
            $arrAccount['sys_account_tel'] 		= $arrData['sys_account_tel'];
            $arrAccount['sys_account_status'] 	= 1; //活动状态
            $sys_account_id = null;

            $AccountDao = new AccountDao();
            $AccountDao->insertAccount($arrData, $sys_account_id);

            $s_role_id = $arrData['s_role_id'];

            $GroupMemberDao = new GroupMemberDao();
            $arrGroupMember = array();

            $arrGroupMember['sys_account_id']  = $sys_account_id;
            $arrGroupMember['s_role_id']       = $s_role_id;
            $arrGroupMember['s_group_id']      = SDP_DEFINE::GROUP_DEFAULT_EMPLOYEE; //公司内部团队群组 系统管理员帐号
            $arrGroupMember['s_group_member_remark'] = '';

            $GroupMemberDao->insertGroupMember($arrGroupMember);
        });

        return true;
    }

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

    /**更新密码
     * @param
     * @return array
     */
    public function updatePasswordByTel($arrData,$tel){
        $AccountDao = new AccountDao();
        $AccountDao->updatePasswordByTel($arrData,$tel);

        return true;
    }

    /**更新用户名
     * @param
     * @return array
     */
    public function updateAccountName($arrData,$id){
        $AccountDao = new AccountDao();
        $AccountDao->updateAccountName($arrData,$id);

        return true;
    }

    /**更新用户头像
     * @param
     * @return array
     */
    public function updateAccountPhoto($arrData,$id){
        $AccountDao = new AccountDao();
        $AccountDao->updateAccountPic($arrData,$id);

        return true;
    }

    /**查询电话是否存在
     * @param $roleId
     * @return array
     */
    public function getAccountByTel($tel){
        $AccountDao = new AccountDao();
        $row = $AccountDao->getAccountByTel($tel);
        return $row ;
    }

    /**
     * 查询用户名是否存在
     * @param $tel
     * @return array
     */
    public function getAccountByName($account_name){
        $AccountDao = new AccountDao();
        $row = $AccountDao->getAccountByName($account_name);
        return $row ;
    }

    /**
     * 校验密码当前密码是否正确
     * @param $account_id
     * @param $password
     * @return bool
     */
    public function passwordVerify($account_id, $password)
    {
        $AccountDao = new AccountDao();
        $item = $AccountDao->getAcccountById($account_id);
        if(!$item) return false;
        return password_verify($password, $item->password);
    }
}
