<?php
/*****************************************************************************************************************
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/9/1
 * Time: 16:33
 *****************************************************************************************************************/

namespace App\Services;

use App\Dao\ProductCatDao;
use App\Http\SDP_DEFINE;
use App\Http\Utils;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProductCatService {

    function __construct()
    {

    }

    /**根据ID获取帐号信息
     * @param 帐号$id
     * @return array
     */
    public function getProductCatById($id){
        $ProductCatDao = new ProductCatDao();
        return $ProductCatDao->getProductCatById($id);
    }

    /**
     * @param $arrData
     * @return bool
     */
    public function updateProductCat($arrData){
        $ProductCatDao = new ProductCatDao();
        return $ProductCatDao->updateProductCat($arrData);
    }

    /**新增
     * @param
     * @return array
     */
    public function insertProductCat($arrData){
        $ProductCatDao = new ProductCatDao();
        return $ProductCatDao->insertProductCat($arrData);
    }

    /**删除帐号
     * @param
     * @return array
     */
    public function deleteProductCatById($product_cat_id){
        $ProductCatDao = new ProductCatDao();
        $ProductCatDao->deleteProductCatById($product_cat_id);
        //删除与账号有关的表数据

        return true;
    }


}
