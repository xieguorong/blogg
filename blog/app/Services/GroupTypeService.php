<?php

/*****************************************************************************************************************
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/9/1
 * Time: 16:33
 *****************************************************************************************************************/

namespace App\Services;

use App\Dao\GroupTypeDao;

class GroupTypeService {

    /**构造函数
     * @param
     * @return
     */
    function __construct()
    {

    }

    /**查询
     * @param
     * @return
     */
    public function queryGroupType($arrData){

        $GroupTypeDao = new GroupTypeDao();

        return $GroupTypeDao->queryGroupType($arrData);
    }

    /**根据ＩＤ获取
     * @param
     * @return
     */
    public function getGroupTypeById($s_group_type_id){

        $GroupTypeDao = new GroupTypeDao();

        return $GroupTypeDao->getGroupTypeById($s_group_type_id);
    }

    /**新增
     * @param
     * @return
     */
    public function insertGroupType($arrData){

        $GroupTypeDao = new GroupTypeDao();

        return $GroupTypeDao->insertGroupType($arrData);
    }

    /**删除
     * @param
     * @return
     */
    public function deleteGroupTypeById($s_group_type_id){

        $GroupTypeDao = new GroupTypeDao();

        return $GroupTypeDao->deleteGroupTypeById($s_group_type_id);
    }

    /**更新
     * @param
     * @return
     */
    public function updateGroupType($arrData, $s_group_type_id){

        $GroupTypeDao = new GroupTypeDao();

        return $GroupTypeDao->updateGroupType($arrData, $s_group_type_id);
    }

}
