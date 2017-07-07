<?php
/*****************************************************************************************************************
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/9/1
 * Time: 16:33
 *****************************************************************************************************************/

namespace App\Services;

use App\Dao\GroupMemberDao;
use App\Dao\RoleMenuDao;
use App\Dao\PositionMenuDao;
use App\Http\SDP_DEFINE;

class LoginService {

	function __construct()
	{
		 
	}

    /**
     ** @param $sys_account_id
     * * @return mixed
     **
     */
    function GetRolesOfMember($sys_account_id){
        $GroupMemberDao = new GroupMemberDao();
        return $GroupMemberDao->getRoles($sys_account_id);
    }

    /**
     * 获取角色的所有菜单权限
     * @param $s_role_id
     * @param $sys_account_id
     * @return array
     */
    public function getMenusOfRole($s_role_id, $sys_account_id){

        //商家子帐号按照职位获取菜单权限
        if ($s_role_id == SDP_DEFINE::ROLE_MERCHANT_CHILD){
            $PositionMenuDao = new PositionMenuDao();
            return $PositionMenuDao->getMenusOfPositionByAccount($sys_account_id);
        }

        $RoleMenuDao    = new RoleMenuDao();
        $roleMenus      = $RoleMenuDao->GetMenuTreeOfRole(0,$s_role_id);

        return $roleMenus ;
    }
}
