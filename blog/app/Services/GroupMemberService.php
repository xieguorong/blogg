<?php

/*****************************************************************************************************************
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/9/1
 * Time: 16:33
 *****************************************************************************************************************/

namespace App\Services;

use App\Dao\GroupMemberDao;

class GroupMemberService {

	function __construct()
	{
	}

    public function getMyGrantedMembers($arrData,$sys_account_id,$group_type)
    {
        $GroupMemberDao = new GroupMemberDao();

        return $GroupMemberDao->getMyGrantedMembers($arrData, $sys_account_id,$group_type);
    }

    public function getMyGrantedSubGroupMembers($arrData,$s_group_id,$group_type)
    {
        $GroupMemberDao = new GroupMemberDao();

        return $GroupMemberDao->getMyGrantedSubGroupMembers($arrData,$s_group_id,$group_type);
    }


    /**根据ID查询群组成员
     * @param
     * @return
     */
	public function queryGroupMember($arrData){

        $GroupMemberDao = new GroupMemberDao();
        return $GroupMemberDao->queryGroupMember($arrData);
	}

    /**根据ID获取群组成员信息
     * @param
     * @return
     */
    public function getGroupMemberById($s_group_id, $sys_account_id){

        $GroupMemberDao = new GroupMemberDao();

        return $GroupMemberDao->getGroupMemberById($s_group_id, $sys_account_id);
    }

    /**新增群组成员
     * @param
     * @return
     */
	public function insertGroupMember($arrData){

        $GroupMemberDao = new GroupMemberDao();

        return $GroupMemberDao->insertGroupMember($arrData);
	}

    /**更新群组成员
     * @param
     * @return
     */
    public function updateGroupMember($arrData, $s_group_id,$sys_account_id){

        $GroupMemberDao = new GroupMemberDao();

        return $GroupMemberDao->updateGroupMember($arrData, $s_group_id,$sys_account_id);
    }


    /**根据ID删除群组成员
     * @param
     * @return
     */
    public function deleteGroupMemberById($s_group_id,$sys_account_id){

        $GroupMemberDao = new GroupMemberDao();

        return $GroupMemberDao->deleteGroupMemberById($s_group_id,$sys_account_id);

	}


    /**从所有群组中清除帐号
     * @param
     * @return
     */
    public function ClearGroupMemberByAccountId($sys_account_id){

        $GroupMemberDao = new GroupMemberDao();

        return $GroupMemberDao->ClearGroupMemberByAccountId($sys_account_id);

    }


    /**将目标群组的商家子帐号全部转移到目标群组；
     * @param
     * @return
     */
	public function TransferSubAccountToTGroup($s_group_id_from, $s_group_id_target){
        DB::transaction(function() use ($s_group_id_from, $s_group_id_target) {

            $GroupMemberDao = new GroupMemberDao();

            $rsMember = $GroupMemberDao->getGroupMemberByGroupId($s_group_id_from);
            if ($rsMember){
                foreach($rsMember as $groupMember){
                    $arrGroupMember = array();
                    $arrGroupMember['s_group_id']             = $s_group_id_target;
                    $arrGroupMember['s_role_id']              = 4; //商家子帐号角色
                    $arrGroupMember['sys_account_id']         = $groupMember->sys_account_id;
                    $arrGroupMember['s_group_member_remark']  = '';
                    $GroupMemberDao->insertGroupMember($arrGroupMember);
                    unset($arrGroupMember);
                }
            }

            $GroupMemberDao->deleteGroupMemberByGroupId($s_group_id_from);
        });

        return true;
    }

    /**根据ＩＤ批量删除群组成员
     * @param
     * @return
     */
    public function batchDelGroupMember($s_group_id, $arrIds){

        if (!empty($ids)){

            $GroupMemberDao = new GroupMemberDao();

            $GroupMemberDao->batchDelGroupMember($s_group_id, $arrIds);
        }

        return true;
    }

    /**根据帐号ＩＤ批量获取帐号所有的群组角色
     * @param
     * @return
     */
    public function getRoles($account_id){

        $GroupMemberDao = new GroupMemberDao();

        return $GroupMemberDao->getRoles($account_id);
    }

    /**
     * 获取用户指定角色的所属群组信息
     * @param $account_id
     * @param $role_id
     * @return mixed
     */
    public function getUserOwnerGroupByRoleId($account_id, $role_id)
    {
        $GroupMemberDao = new GroupMemberDao();
        return $GroupMemberDao->getUserOwnerGroupByRoleId($account_id, $role_id);
    }

    /**
     * 检查账号是否在指定群组中, 注意多角色的问题
     * @param $account_id
     * @param $group_id
     * @return mixed
     */
    public function hasInGroup($account_id, $group_id)
    {
        $GroupMemberDao = new GroupMemberDao();
        return $GroupMemberDao->hasInGroup($account_id, $group_id);
    }
}
