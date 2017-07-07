<?php
/*****************************************************************************************************************
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/9/1
 * Time: 16:33
 *****************************************************************************************************************/

namespace App\Services;

use App\Dao\MemberGrantDao;
use App\Dao\ResellerApplyDao;
use App\Models\ResellerApply;

class ResellerApplyService {

	function __construct()
	{
		 
	}

	public function queryResellerApply($arrData){

        $ResellerApplyDao = new ResellerApplyDao();
		return $ResellerApplyDao->queryResellerApply($arrData);
	}

	/**根据ID获取帐号信息
	 * @param 帐号$id
	 * @return array
	 */
	public function getResellerApplyById($id){
		$ResellerApplyDao = new ResellerApplyDao();
		return $ResellerApplyDao->getResellerApplyById($id);
	}

    /**
     * @param $arrData
     * @return bool
     */
	public function updateResellerApply($arrData){
		$ResellerApplyDao = new ResellerApplyDao();
		return $ResellerApplyDao->updateResellerApply($arrData);
	}

	/**新增
	 * @param
	 * @return array
	 */
	public function insertResellerApply($arrData){
		$ResellerApplyDao = new ResellerApplyDao();
		return $ResellerApplyDao->insertResellerApply($arrData);
	}


	/**删除帐号
	 * @param
	 * @return array
	 */
	public function deleteResellerApplyById($reseller_request_id){
		$ResellerApplyDao = new ResellerApplyDao();
		$ResellerApplyDao->deleteResellerApplyById($reseller_request_id);
		//删除与账号有关的表数据

		return true;
	}

}
