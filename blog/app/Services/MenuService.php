<?php

/*****************************************************************************************************************
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/9/1
 * Time: 16:33
 *****************************************************************************************************************/

namespace App\Services;
use App\Dao\MenuDao;
use App\Dao\PositionMenuDao;
use App\Dao\RoleMenuDao;
use App\Dao\SysModDao;
use Illuminate\Support\Facades\DB;

class MenuService {

    /**构造
     * @param
     * @return
     */
	function __construct(){

	}

    public function GetMenuTree($parent_id,$s_role_id)
    {
        $CategoryDao = new MenuDao();
        return $CategoryDao->GetMenuTree($parent_id,$s_role_id);
    }

    /**查询菜单
     * @param
     * @return
     */
	public function queryMenu($arrData){
        $MenuDao = new MenuDao();
        return $MenuDao->queryMenu($arrData);
	}


    /**根据ID获取菜单
     * @param
     * @return
     */
	public function getMenuById($id){
        $MenuDao = new MenuDao();
        return $MenuDao->getMenuById($id);
	}

    /**获取缺省菜单
     * @param
     * @return
     */
	 public function getFirstMenu(){
         $MenuDao = new MenuDao();
         return $MenuDao->getFirstMenu();
    }

    /**新增菜单
     * @param
     * @return
     */
	public function insertMenu($arrData){

        $MenuDao = new MenuDao();
        $MenuDao->insertMenu($arrData);

        $menu_id = $arrData['menu_parent'];
        $MenuDao->updateMenuLeaf($menu_id,0);

        return true;
	}


    /**更新菜单
     * @param
     * @return
     */
    public function updateMenu($arrData){
        $MenuDao = new MenuDao();
        return $MenuDao->updateMenu($arrData);
    }

    /**删除菜单
     * @param
     * @return
     */
	public function deleteMenu($id){
        DB::transaction(function() use ($id){

            //删除菜单
            $MenuDao = new MenuDao();
            $MenuDao->deleteMenuById($id);

            //删除角色菜单权限授权
            $RoleMenuDao = new RoleMenuDao();
            $RoleMenuDao->deleteRoleMenuByMenuId($id);

            //清除功能模块的绑定菜单
            $SysModDao = new SysModDao();
            $SysModDao->clearSysModMenu($id);

            //清除职位授权的菜单
            $PositionMenuDao = new PositionMenuDao();
            $PositionMenuDao->clearPositionMenuByMenuId($id);

        });
	}

}
