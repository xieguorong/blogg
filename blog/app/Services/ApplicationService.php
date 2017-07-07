<?php
/*****************************************************************************************************************
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/9/1
 * Time: 16:33
 *****************************************************************************************************************/

namespace App\Services;

use App\Dao\ApplicationDao;
use App\Http\SDP_DEFINE;
use App\Models\Account;
use App\Http\Utils;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ApplicationService {

    function __construct()
    {

    }

    public function queryApplication($arrData){

        $ApplicationDao = new ApplicationDao();
        return $ApplicationDao->queryApplication($arrData);
    }

    /**根据ID获取帐号信息
     * @param 帐号$id
     * @return array
     */
    public function getApplicationById($id){
        $ApplicationDao = new ApplicationDao();
        return $ApplicationDao->getApplicationById($id);
    }

    /**
     * @param $arrData
     * @return bool
     */
    public function updateApplication($arrData)
    {
        $ApplicationDao = new ApplicationDao();
        return $ApplicationDao->updateApplication($arrData);
    }


}
