<?php
namespace App\Services;
use App\Dao\ConsumeCatDao;
class ConsumeCatService{
    public function queryConsumeCat($arrData){
        $PointsDao = new ConsumeCatDao();
        return $PointsDao->queryConsumeCat($arrData);
    }

    /**根据ID获取帐号信息
     * @param 帐号$id
     * @return array
     */
    public function getConsumeCatById($id){
        $PointsDao = new ConsumeCatDao();
        return $PointsDao->getConsumeCatById($id);
    }
}