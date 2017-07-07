<?php

/*****************************************************************************************************************
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/9/1
 * Time: 16:33
 *****************************************************************************************************************/

namespace App\Services;
use App\Dao\SysModDao;
use App\Dao\SysModFuncDao;

class SysModService {

    function __construct()
    {

    }

    /**查询功能模块
     * @param
     * @return
     */
    public function querySysMod(){

        $SysModDao = new SysModDao();

        return $SysModDao->querySysMod();
    }

    /**根据ＩＤ获取
     * @param
     * @return
     */
    public function getSysModById($sys_mod_id){

        $SysModDao = new SysModDao();

        return $SysModDao->getSysModById($sys_mod_id);

    }

    /**新增
     * @param
     * @return
     */
    public function insertSysMod($arrData){

        $SysModDao = new SysModDao();
        return $SysModDao->insertSysMod($arrData);
    }


    /**删除
     * @param
     * @return
     */
    public function deleteSysModById($sys_mod_id){


        $SysModDao = new SysModDao();
        $SysModDao->deleteSysModById($sys_mod_id);

        $SysModFuncDao = new SysModFuncDao();
        $SysModFuncDao->clearSysModFuncByMod($sys_mod_id);
    }

    /**更新模块
     * @param
     * @return
     */
    public function updateSysMod($arrData, $sys_mod_id){

        $SysModDao = new SysModDao();

        return $SysModDao->updateSysMod($arrData, $sys_mod_id);
    }

    /**更新模块菜单
     * @param
     * @return
     */
    public function updateSysModMenu($sys_mod_id,$menu_id){

        $SysModDao = new SysModDao();

        return $SysModDao->updateSysModMenu($sys_mod_id,$menu_id);
    }

    /**清除模块菜单
     * @param
     * @return
     */
    public function clearSysModMenu($menu_id){

        $SysModDao = new SysModDao();

        return $SysModDao->clearSysModMenu($menu_id);

    }

}
