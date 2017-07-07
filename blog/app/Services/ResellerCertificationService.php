<?php
/*****************************************************************************************************************
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/9/1
 * Time: 16:33
 *****************************************************************************************************************/

namespace App\Services;

use App\Dao\MemberGrantDao;
use App\Dao\ResellerCertificationDao;
use App\Models\ResellerCertification;

class ResellerCertificationService {

	function __construct()
	{
		 
	}

	public function queryResellerCertification($arrData){

        $ResellerCertificationDao = new ResellerCertificationDao();
		return $ResellerCertificationDao->queryResellerCertification($arrData);
	}

	/**根据ID获取帐号信息
	 * @param 帐号$id
	 * @return array
	 */
	public function getResellerCertificationById($id){
		$ResellerCertificationDao = new ResellerCertificationDao();
		return $ResellerCertificationDao->getResellerCertificationById($id);
	}

    /**
     * @param $arrData
     * @return bool
     */
	public function updateResellerCertification($arrData){
		$ResellerCertificationDao = new ResellerCertificationDao();
		return $ResellerCertificationDao->updateResellerCertification($arrData);
	}

	/**新增
	 * @param
	 * @return array
	 */
	public function insertResellerCertification($arrData){
		$ResellerCertificationDao = new ResellerCertificationDao();
		return $ResellerCertificationDao->insertResellerCertification($arrData);
	}

	/**删除帐号
	 * @param
	 * @return array
	 */
	public function deleteResellerCertificationById($reseller_level_id){
        $ResellerCertificationDao = new ResellerCertificationDao();
        $ResellerCertificationDao->deleteAcccountById($reseller_level_id);
		//删除与账号有关的表数据

		return true;
	}

}
