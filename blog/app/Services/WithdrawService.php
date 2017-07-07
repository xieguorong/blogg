<?php
namespace App\Services;
use App\Dao\WithdrawDao;
class WithdrawService{
    public function queryWithdraw($arrData){
        $WithdrawDao = new WithdrawDao();
        return $WithdrawDao->queryWithdraw($arrData);
    }

    /**根据ID获取帐号信息
     * @param 帐号$id
     * @return array
     */
    public function getWithdrawById($id){
        $WithdrawDao = new WithdrawDao();
        return $WithdrawDao->getWithdrawById($id);
    }
}