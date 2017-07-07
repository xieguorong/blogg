<?php

/*****************************************************************************************************************
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/9/1
 * Time: 16:33
 *****************************************************************************************************************/

namespace App\Services;
use App\Dao\RoleRightDao;
use Illuminate\Support\Facades\DB;

class RoleRightService {

	function __construct()
	{

	}

    /**查询角色功能权限
     * @param
     * @return
     */
	public function queryRoleRight($s_role_id){

        $RoleRightDao = new RoleRightDao();
        return $RoleRightDao->queryRoleRight($s_role_id);
	}

    /**获取角色功能权限
     * @param
     * @return
     */
    public function getRoleRightById($s_role_id){

        $RoleRightDao = new RoleRightDao();
        return $RoleRightDao->getRoleRightById($s_role_id);
    }

    /**新增角色功能权限
     * @param
     * @return
     */
	public function insertRoleRight($s_role_id, $sys_mod_id, $sys_mod_func_id){

        $RoleRightDao = new RoleRightDao();
        return $RoleRightDao->insertRoleRight($s_role_id, $sys_mod_id, $sys_mod_func_id);
	}

    /**将模块所有功能授权给角色
     * @param
     * @return
     */
    public function insertRoleRightByMod($s_role_id, $sys_mod_id){

        $RoleRightDao = new RoleRightDao();
        return $RoleRightDao->insertRoleRightByMod($s_role_id, $sys_mod_id);
    }

    /**删除 角色功能权限
     * @param
     * @return
     */
    public function deleteRoleRightById($s_role_id, $sys_mod_id, $sys_mod_func_id){

        $RoleRightDao = new RoleRightDao();
        return $RoleRightDao->deleteRoleRightById($s_role_id, $sys_mod_id, $sys_mod_func_id);

	}

    /**删除角色权限中目标模块的所有功能的权限
     * @param
     * @return
     */
    public function deleteRoleRightByMod($s_role_id, $sys_mod_id){

        $RoleRightDao = new RoleRightDao();
        return $RoleRightDao->deleteRoleRightByMod($s_role_id, $sys_mod_id);
    }

    public function deleteRoleRightByRoleId($s_role_id){

        $RoleRightDao = new RoleRightDao();
        return $RoleRightDao->deleteRoleRightByRoleId($s_role_id);
    }

    public function saveFuncSetting($arrData){

        $s_role_id = $arrData['s_role_id'];
        $RoleRightDao = new RoleRightDao();
        $RoleRightDao->deleteRoleRightByRoleId($s_role_id);

        $mod_str  = $arrData['sys_mod_id'];
        $func_str = $arrData['sys_mod_func_id'];

        $arrMod  = explode(',',$mod_str);
        $arrFunc = explode(',',$func_str);

        for($i=0;$i<count($arrMod);$i++) {
            $sys_mod_id      = $arrMod[$i];
            $sys_mod_func_id = $arrFunc[$i];
            $RoleRightDao->insertRoleRight($s_role_id, $sys_mod_id, $sys_mod_func_id);
        }

        return true;
    }


}
