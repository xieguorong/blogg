<?php

/*****************************************************************************************************************
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/9/1
 * Time: 16:33
 *****************************************************************************************************************/


namespace App\Services;
use App\Dao\RoleMenuDao;

class RoleMenuService {

	function __construct()
	{

	}

    /**查询角色的菜单授权
     * @param
     * @return
     */
	public function queryRoleMenu($s_role_id){

        $RoleMenuDao = new RoleMenuDao();
        return $RoleMenuDao->queryRoleMenu($s_role_id);

	}

    /**根据ＩＤ获取菜单授权
     * @param
     * @return
     */
    public function getRoleMenuById($s_role_id, $menu_id){

        $RoleMenuDao = new RoleMenuDao();
        return $RoleMenuDao->getRoleMenuById($s_role_id, $menu_id);
    }

    /**树形转化
     * @param
     * @return
     */
    function generateTree($items){
        $tree = array();
        foreach($items as $item){
            if(isset($items[$item['menu_parent']])){
                $items[$item['menu_parent']]['child'][] = &$items[$item['menu_id']];
            }else{
                $tree[] = &$items[$item['menu_id']];
            }
        }
        return $tree;
    }


    public function updateRoleMenu($arrData){

        $s_role_id = $arrData['s_role_id'];
        $RoleMenuDao = new RoleMenuDao();
        $RoleMenuDao->deleteRoleMenuByRole($s_role_id);

        $menu_str = $arrData['menu_id'];

        $arrMenu = explode(',',$menu_str);
        foreach ($arrMenu as $menu_id) {
            $RoleMenuDao->insertRoleMenu($s_role_id, $menu_id);
        }
        return true;
    }

    /**新增
     * @param
     * @return
     */
	public function insertRoleMenu($s_role_id, $menu_id){

        $RoleMenuDao = new RoleMenuDao();
        return  $RoleMenuDao->insertRoleMenu($s_role_id, $menu_id);

	}

    /**删除
     * @param
     * @return
     */
    public function deleteRoleMenuById($s_role_id, $menu_id){

        $RoleMenuDao = new RoleMenuDao();
        return  $RoleMenuDao->deleteRoleMenuById($s_role_id, $menu_id);
	}

    /**清除角色的菜单权限
     * @param
     * @return
     */
    public function deleteRoleMenuByRole($s_role_id){

        $RoleMenuDao = new RoleMenuDao();
        return  $RoleMenuDao->deleteRoleMenuByRole($s_role_id);
    }

    /**清除所有角色的目标菜单权限
     * @param
     * @return
     */
    public function deleteRoleMenuByMenuId($menu_id){

        $RoleMenuDao = new RoleMenuDao();
        return  $RoleMenuDao->deleteRoleMenuByMenuId($menu_id);
    }

}
