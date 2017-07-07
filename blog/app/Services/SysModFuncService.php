<?php

/*****************************************************************************************************************
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/9/1
 * Time: 16:33
 *****************************************************************************************************************/

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Dao\SysModFuncDao;


class SysModFuncService {

	function __construct()
	{

	}

    public function getRoleFuncSetting($s_role_id){

        $SysModFuncDao = new SysModFuncDao();
        return $SysModFuncDao->getRoleFuncSetting($s_role_id);

    }
    /**查询模块功能
     * @param
     * @return
     */
	public function querySysModFunc(){

        $SysModFuncDao = new SysModFuncDao();

        return $SysModFuncDao->querySysModFunc();

	}
    /**根据ID获取模块功能
     * @param
     * @return
     */
    public function getSysModFuncById($sys_mod_id, $sys_mod_func_id){

        $SysModFuncDao = new SysModFuncDao();

        return $SysModFuncDao->getSysModFuncById($sys_mod_id, $sys_mod_func_id);
    }

    /**新增模块功能
     * @param
     * @return
     */
	public function insertSysModFunc($arrData){

        $SysModFuncDao = new SysModFuncDao();

        return $SysModFuncDao->insertSysModFunc($arrData);
	}


    /**更新模块功能
     * @param
     * @return
     */
    public function updateSysModFunc($arrData, $sys_mod_id, $sys_mod_func_id){

        $SysModFuncDao = new SysModFuncDao();

        return $SysModFuncDao->updateSysModFunc($arrData, $sys_mod_id, $sys_mod_func_id);

    }

    /**删除模块功能
     * @param
     * @return
     */
    public function deleteSysModFuncById($sys_mod_id, $sys_mod_func_id){

        $SysModFuncDao = new SysModFuncDao();

        return $SysModFuncDao->deleteSysModFuncById($sys_mod_id, $sys_mod_func_id);
	}

    /**清除目标模块的所有功能
     * @param
     * @return
     */
    public function clearSysModFuncByMod($sys_mod_id){

        $SysModFuncDao = new SysModFuncDao();

        return $SysModFuncDao->clearSysModFuncByMod($sys_mod_id);

    }
}
