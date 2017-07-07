<?php

/*****************************************************************************************************************
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/9/1
 * Time: 16:33
 *****************************************************************************************************************/

namespace App\Services;

use App\Dao\RoleDao;

class RoleService {


    /**查询角色
     * @param
     * @return
     */
	public function queryRole($arrData){

        $RoleDao = new RoleDao();
        return $RoleDao->queryRole($arrData);
	}

    /**根据ID获取
     * @param
     * @return
     */
	public function getRoleById($s_role_id){

        $RoleDao = new RoleDao();
        return $RoleDao->getRoleById($s_role_id);
	}

    /**新增
     * @param
     * @return
     */
	public function insertRole($arrData){

        $RoleDao = new RoleDao();
        return $RoleDao->insertRole($arrData);
	}


    /**删除
     * @param
     * @return
     */
	public function deleteRoleById($s_role_id){

        $RoleDao = new RoleDao();
        return $RoleDao->deleteRoleById($s_role_id);
	}

    /**更新
     * @param
     * @return
     */
    public function updateRole($arrData){

        $RoleDao = new RoleDao();
        return $RoleDao->updateRole($arrData);
    }

    public function getAllRoles(){

        $RoleDao = new RoleDao();
        return $RoleDao->getAllRoles();
    }

}
