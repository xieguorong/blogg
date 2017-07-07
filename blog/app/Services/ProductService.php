<?php

/*****************************************************************************************************************
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/9/1
 * Time: 16:33
 *****************************************************************************************************************/


namespace App\Services;

use App\Dao\ProductDao;
use App\Dao\ProductImageDao;
use Illuminate\Support\Facades\DB;

class ProductService {

    /**构造
     * @param
     * @return
     */
	function __construct(){

	}

    /**查询
     * @param
     * @return
     */
	public function queryProduct($arrData){
		$ProductDao = new ProductDao();

		return $ProductDao->queryProduct($arrData);
	}

	/**根据ID获取
	 * @param
	 * @return
	 */
	public function getProductById($product_id){
		$ProductDao = new ProductDao();
        $ItemData = $ProductDao->getProductByDe($product_id);
        $data= array();
        $data['item']  = $ItemData;
        $ProductImageDao = new ProductImageDao();
        $ImageData = $ProductImageDao->getImageByProductId($product_id);
        $data['images']  = $ImageData->all();
        return $data;
	}

	/**更新手机端产品
	 * @param
	 * @return
	 */
	public function editProduct($arrData, $product_id){
        DB::transaction(function() use ($arrData, $product_id) {

            $product_image  = $arrData['product_image'];
            $arrData['product_image']  = $product_image[0]['pic_url'];

            $ProductDao = new ProductDao();
            $ProductDao->updateProductWithAccId($arrData,$product_id);

            $productImageDao = new ProductImageDao();
            $productImageDao->deleteProductImage($product_id);

            $loop = 1;
            foreach ($product_image as $item) {
                $item['product_id'] = $product_id;
                if($loop == 1){
                    $item['product_image_major_if'] = 1;
                }else{
                    $item['product_image_major_if'] = 0;
                }
                $productImageDao->insertProductImage($item);
                $loop ++;
            }
        });

		return true;
	}

    public function updateProduct($arrData, $product_id){
        DB::transaction(function() use ($arrData, $product_id) {

            $image_url     = $arrData['image_url'];
            $image_name    = $arrData['image_name'];
            $arrData['product_image']  = $image_url[0];

            $ProductDao = new ProductDao();
            $ProductDao->updateProduct($arrData,$product_id);

            $productImageDao = new ProductImageDao();
            $productImageDao->deleteProductImage($product_id);

            $loop = 1;
            for($i=0; $i < count($image_url); $i++){
                $item = array();
                if(!empty($image_url[$i])){
                    $item['product_id'] = $product_id;
                    if($loop == 1){
                        $item['product_image_major_if'] = 1;
                    }else{
                        $item['product_image_major_if'] = 0;
                    }
                    $item['product_image_url']  = $image_url[$i];
                    $productImageDao->insertProductImage($item);
                    $loop ++;
                }
            }
        });

        return true;
    }

    public function insertProduct($arrData){
        DB::transaction(function() use ($arrData) {

            $product_id  =null;

            $image_url     = $arrData['image_url'];
            $image_name    = $arrData['image_name'];
            $arrData['product_image']  = $image_url[0];
            $ProductDao = new ProductDao();
            $ProductDao->insertProduct($arrData, $product_id);

            $ProductImageDao = new ProductImageDao();

            $loop = 1;
            for($i=0;$i<count($image_url);$i++){
                $item = array();
                if(!empty($image_url[$i])){
                    $item['product_id'] = $product_id;
                    if($loop == 1){
                        $item['product_image_major_if'] = 1;
                    }else{
                        $item['product_image_major_if'] = 0;
                    }
                    $item['product_image_url']  = $image_url[$i];
                    $ProductImageDao->insertProductImage($item);
                    $loop ++;
                }
            }
        });

        return true;
    }

	/**手机端新增产品
	 * @param
	 * @return
	 */
	public function saveProduct($arrData){
        DB::transaction(function() use ($arrData) {

            $product_id = 0;
            $ProductDao = new ProductDao();
            $ProductDao->insertProduct($arrData, $product_id);

            $ProductImageDao = new ProductImageDao();

            $loop = 1;
            $product_image  = $arrData['product_image'];
            foreach ($product_image as $item) {
                $item['product_id'] = $product_id;
                if($loop == 1){
                    $item['product_image_major_if'] = 1;
                }else{
                    $item['product_image_major_if'] = 0;
                }
                $ProductImageDao->insertProductImage($item);
                $loop ++;
            }

        });

		return true;
	}

	/**根据ID删除
	 * @param
	 * @return
	 */
	public function deleteProductById($product_id){
        DB::transaction(function() use ($product_id) {

            //删除与产品有关的表数据
            $ProductDao = new ProductDao();
            $ProductDao->deleteProductById($product_id);

        });

		return true;
	}

	/**更新产品状态
	 * @param
	 * @return
	 */
	public function updateProductStatus($product_status, $product_id){
        $ProductDao = new ProductDao();
        $ProductDao->updateProductStatus($product_status, $product_id);

		return true;
	}


}
