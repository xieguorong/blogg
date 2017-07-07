<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/6 0006
 * Time: 下午 1:52
 */
namespace App\Services;



use App\Dao\BalanceDao;

class BalanceService{
    public function queryBalance($arrData){
        $BalanceDao = new BalanceDao();
        return $BalanceDao->queryBalance($arrData);
    }

    /**根据ID获取帐号信息
     * @param 帐号$id
     * @return array
     */
    public function getBalanceById($id){
        $BalanceDao = new BalanceDao();
        return $BalanceDao->getBalanceById($id);
    }
    public function getBalanceByAccountId($account_id){
        $BalanceDao = new BalanceDao();
        return $BalanceDao->getBalanceByAccountId($account_id);
    }

}