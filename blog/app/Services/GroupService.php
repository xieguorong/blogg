<?php

/*****************************************************************************************************************
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/9/1
 * Time: 16:33
 *****************************************************************************************************************/

namespace App\Services;

use App\Dao\MemberGrantDao;
use App\Dao\GroupDao;

class GroupService {

	function __construct()
	{

	}

    public function getGroupByParentId($s_group_parent){
        $GroupDao = new GroupDao();
        return $GroupDao->getGroupByParentId($s_group_parent);
    }

    public function getAllGroup($s_group_id){

        $GroupDao = new GroupDao();
        return $GroupDao->GetGroupList($s_group_id);
    }

    public function getMyGrantedGroups($sys_account_id, $group_type_id){

        $MemberGrantDao = new MemberGrantDao();
        return $MemberGrantDao->getMyGrantedGroupsL0L1($sys_account_id, $group_type_id);
    }


    /**查询群组信息
     * @param
     * @return
     */
	public function queryGroup($arrData){

        $GroupDao = new GroupDao();

        return $GroupDao->queryGroup($arrData);
	}

    /**根据ＩＤ获取群组信息
     * @param
     * @return
     */
    public function getGroupById($s_group_id){
        $GroupDao = new GroupDao();

        return $GroupDao->getGroupById($s_group_id);
	}

    /**新增群组
     * @param
     * @return
     */
    public function insertGroup($arrData,&$returnData){

        $GroupDao = new GroupDao();

        return $GroupDao->insertGroup($arrData,$returnData);
 	}

    public function saveGroup($s_group_id,$arrData,&$returnData=array()){

        $GroupDao = new GroupDao();
        return $GroupDao->saveGroup($s_group_id,$arrData,$returnData);
    }

    /**新增授权群组
     * @param
     * @return
     */
    public function AddNewGrantedGroup($s_group_name, $s_group_type_id, $s_group_parent, $sys_account_id){
        $GroupDao = new GroupDao();

        return $GroupDao->AddNewGrantedGroup($s_group_name, $s_group_type_id, $s_group_parent, $sys_account_id);
    }

    /**根据ＩＤ删除群组
     * @param
     * @return
     */
    public function deleteGroupById($s_group_id){
        $GroupDao = new GroupDao();
        return $GroupDao->deleteGroupById($s_group_id);
    }

    public function deleteGroup($s_group_id){
        $GroupDao = new GroupDao();
        return $GroupDao->deleteGroup($s_group_id);
    }

    /**更新群组信息
     * @param
     * @return
     */
    public function updateGroup($arrData){
        $GroupDao = new GroupDao();
        return $GroupDao->updateGroup($arrData);
    }
}
