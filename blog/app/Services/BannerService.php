<?php
/*****************************************************************************************************************
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/9/1
 * Time: 16:33
 *****************************************************************************************************************/

namespace App\Services;


use App\Dao\BannerDao;
use App\Http\SDP_DEFINE;
use App\Models\Account;
use App\Http\Utils;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class BannerService {

	function __construct()
	{
		 
	}

	public function queryBanner($arrData){

        $BannerDao = new BannerDao();
		return $BannerDao->queryBanner($arrData);
	}

	/**根据ID获取帐号信息
	 * @param 帐号$id
	 * @return array
	 */
	public function getBannerById($id){
		$BannerDao = new BannerDao();
		return $BannerDao->getBannerById($id);
	}

    public function insertBanner($arrData)
    {
        $BannerDao = new BannerDao();
        return $BannerDao->insertBanner($arrData);
    }

    public function deleteBanner($id){

        $BannerDao = new BannerDao();
        $BannerDao->deleteBannerById($id);
        return true;
    }
    /**
     * @param $arrData
     * @return bool
     */
    public function updateBanner($arrData)
    {

        $BannerDao = new BannerDao();
        return $BannerDao->updateBanner($arrData);
    }

}


