<?php
/*****************************************************************************************************************
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/9/1
 * Time: 16:33
 *****************************************************************************************************************/

namespace App\Services;

use App\Dao\RequestDao;
use App\Http\SDP_DEFINE;
use App\Models\Account;
use App\Http\Utils;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RequestService {

	function __construct()
	{
		 
	}

	public function queryRequest($arrData){

        $RequestDao = new RequestDao();
		return $RequestDao->queryRequest($arrData);
	}

	/**根据ID获取帐号信息
	 * @param 帐号$id
	 * @return array
	 */
	public function getRequestById($id){
		$RequestDao = new RequestDao();
		return $RequestDao->getRequestById($id);
	}

    /**
     * @param $arrData
     * @return bool
     */
    public function updateRequest($arrData)
    {
        $RequestDao = new RequestDao();
        return $RequestDao->updateRequest($arrData);
    }


}
