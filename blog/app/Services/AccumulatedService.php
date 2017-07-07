<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/6 0006
 * Time: 下午 1:52
 */
namespace App\Services;



use App\Dao\AccumulatedDao;

class AccumulatedService{
    public function queryAccumulated($arrData){
        $AccumulatedDao = new AccumulatedDao();
        return $AccumulatedDao->queryAccumulated($arrData);
    }

    /**根据ID获取帐号信息
     * @param 帐号$id
     * @return array
     */
    public function getAccumulatedById($id){
        $AccumulatedDao = new AccumulatedDao();
        return $AccumulatedDao->getAccumulatedById($id);
    }
    public function getAccumulatedByAccountId($account_id){
        $AccumulatedDao = new AccumulatedDao();
        return $AccumulatedDao->getAccumulatedByAccountId($account_id);
    }

}