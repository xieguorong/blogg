<?php
/*****************************************************************************************************************
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/9/1
 * Time: 16:33
 *****************************************************************************************************************/

namespace App\Services;

use App\Dao\AccountDao;
use App\Dao\MemberGrantDao;
use App\Dao\ResellerCertificationDao;
use App\Dao\ResellerCustomerDao;

class ResellerCustomerService {

	function __construct()
	{
		 
	}

	public function queryResellerCustomer($arrData){
        $AccountDao = new AccountDao();
		return $AccountDao->queryResellerCustomer($arrData);
	}
    public function customerQuery($arrData){

        $ResellerCustomerDao = new ResellerCustomerDao();
        return $ResellerCustomerDao->customerQuery($arrData);
    }

    public function queryResellerCertification($arrData){

        $ResellerCertificationDao = new ResellerCertificationDao();
        return $ResellerCertificationDao->queryResellerCertification($arrData);
    }

	/**根据ID获取帐号信息
	 * @param 帐号$id
	 * @return array
	 */
	public function getResellerCustomerById($id){
		$ResellerCustomerDao = new ResellerCustomerDao();
		return $ResellerCustomerDao->getResellerCustomerById($id);
	}

    /**
     * @param $arrData
     * @return bool
     */
	public function updateResellerCustomer($arrData){
		$ResellerCustomerDao = new ResellerCustomerDao();
		return $ResellerCustomerDao->updateResellerCustomer($arrData);
	}

	/**新增
	 * @param
	 * @return array
	 */
	public function insertResellerCustomer($arrData){
		$ResellerCustomerDao = new ResellerCustomerDao();
		return $ResellerCustomerDao->insertResellerCustomer($arrData);
	}

	/**删除帐号
	 * @param
	 * @return array
	 */
	public function deleteResellerCustomerById($customer_id){
		$ResellerCustomerDao = new ResellerCustomerDao();
		$ResellerCustomerDao->deleteResellerCustomerById($customer_id);
		//删除与账号有关的表数据

		return true;
	}

}
