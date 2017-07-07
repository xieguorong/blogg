<?php

/*****************************************************************************************************************
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/9/1
 * Time: 16:33
 *****************************************************************************************************************/

namespace App\Services;

use App\Dao\OrderDao;
use App\Dao\TransactionDao;
use App\Http\SDP_DEFINE;
use App\Http\Utils;
use App\Models\Order;
use App\Models\OrderTransaction;
use Carbon\Carbon;
use Faker\Provider\Uuid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderService {

    private $_errors = [];

	public function queryOrder(Request $request){

		$TransactionDao = new TransactionDao();

		$model   = $TransactionDao->queryTransaction($request);

		return $model;

	}


	public function queryUserOrder($arrData){

		$orderDao = new OrderDao();

		$resultData =  $orderDao->queryUserOrder($arrData);

		return $resultData;
	}

	public function getOrderById($id){

		$orderDao = new OrderDao();

		return $orderDao->getOrderById($id);
	}

	public function getAccountOrderById($sys_account_id,$id){
		$orderDao = new OrderDao();

		return $orderDao->getAccountOrderById($sys_account_id,$id);
	}


    public function addOrder($products, $address, $sys_account_id)
    {
        $this->clearErrors();

        if(empty($products)) {
            $this->recordError('订单数据不完整');
            return false;
        }
        $status = SDP_DEFINE::ORDER_AWAIT_HANDLING;
        // calc, get data
        $ProductService = new ProductService();
        $tranactions = array();
        foreach($products as $product) {
            $prodInfo = $ProductService->getProductById($product['product_id']);
            if(!$prodInfo) {
                $this->recordError(sprintf('产品不存在. product_id=%s', $product['product_id']));
                return false;
            }
            $supplier_id                                       = $prodInfo->sys_account_id;
            $item                                              = array();
            $item['product_id']                                = $product['product_id'];
            $item['product_title']                             = $prodInfo->product_title;
            $item['product_sku']                               = '';
            $item['product_sku_desc']                          = '';
            $item['order_trans_item_price']                    = floatval($prodInfo->product_price);
            $item['order_trans_item_quantity']                 = intval($product['qty']);
            $item['status']                                    = $status;
            $item['order_trans_item_supplier']                 = $supplier_id;
            $tranactions[$supplier_id]['order_trans_supplier'] = $supplier_id;
            $tranactions[$supplier_id]['items'][]              = $item;
        }
        if($address) {
            unset($address['account_id']);
        }
        $total_price = $post_fee = $quantity = 0;
        foreach ($tranactions as &$tran) {
            $tran['order_trans_id'] = Utils::GetOrderId();
            $tran['account_id']     = $sys_account_id;
            $s_price = $s_post_fee  = $s_quantity = 0;
            foreach ($tran['items'] as $item) {
                $s_price    += $item['order_trans_item_price'] * $item['order_trans_item_quantity'];
                $s_quantity += $item['order_trans_item_quantity'];
            }
            $tran['order_trans_qty']           = $s_quantity;
            $tran['order_trans_total_price']   = $s_price;
            $tran['order_trans_shipping_cost'] = $s_post_fee;
            $tran['order_trans_paid_amount']   = $s_price + $s_post_fee;
            $total_price += $s_price;
            $post_fee    += $s_post_fee;
            $quantity    += $s_quantity;
        }
        unset($tran);
        DB::beginTransaction();
        try {
            // insert order
            $order                       = new Order($address);
            $order->order_paid_amount    = $total_price + $post_fee;
            $order->order_total_price    = $total_price;
            $order->order_shipping_cost  = $post_fee;
            $order->order_qty            = $quantity;
            $order->account_id           = $sys_account_id;
            $order->status               = $status;
            $order->order_payment_method = 'COD';
            $order->save();
            $order_id = $order->order_id;
            foreach ($tranactions as $tran) {
                $insData = $tran;
                unset($insData['items']);
                $orderTrans           = new OrderTransaction($insData);
                $orderTrans->order_id = $order_id;
                $orderTrans->status   = $status;
                $orderTrans->save();
                $order_trans_id = $tran['order_trans_id'];
                foreach($tran['items'] as $item) {
                    // insert item
                    $data                        = $item;
                    $data['order_id']            = $order_id;
                    $data['order_trans_id']      = $order_trans_id;
                    $data['order_trans_item_id'] = Uuid::uuid();
                    $data['created_at']          = Carbon::now()->toDateTimeString();
                    $bRet = DB::table('order_transaction_item')->insert($data);
                    if($bRet === false) {
                        throw new \Exception('Insert order item faild.');
                    }
                }
            }
            DB::commit();
            return true;
        } catch (\Exception $e){
            DB::rollback();
            $this->recordError($e->getMessage());
            return false;
        }
    }

    public function errors()
    {
        return $this->_errors;
    }

    private function clearErrors()
    {
        $this->_errors = [];
    }

    private function recordError($message) {
        $this->_errors[] = $message;
    }
}
