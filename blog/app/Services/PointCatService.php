<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/6 0006
 * Time: 下午 1:52
 */
namespace App\Services;



use App\Dao\PointCatDao;

class PointCatService{
    public function queryPointCat($arrData){
        $PointsDao = new PointCatDao();
        return $PointsDao->queryPointCat($arrData);
    }

    /**根据ID获取帐号信息
     * @param 帐号$id
     * @return array
     */
    public function getPointCatById($id){
        $PointsDao = new PointCatDao();
        return $PointsDao->getPointCatById($id);
    }
    public function getPointByAccountId($account_id){
        $PointsDao = new PointCatDao();
        return $PointsDao->getPointByAccountId($account_id);
    }

}