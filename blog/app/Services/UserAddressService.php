<?php

/*****************************************************************************************************************
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/9/1
 * Time: 16:33
 *****************************************************************************************************************/

namespace App\Services;

use App\Models\UserAddress;
use Illuminate\Support\Facades\DB;

class UserAddressService {


	public function queryUserAddress($arrData){
		$limit      = isset($arrData['limit']) ?  $arrData['limit'] : 10 ;
		$page       = isset($arrData['page']) ?  $arrData['page'] : 1 ;

		$limit      = !$limit ? 10 : $limit;
		$page       = !$page ? 1 : $page;

		$query = DB::table('user_address');
		$account_id = $arrData['account_id'];
        if(!empty($account_id)){
            $query->where('account_id','=', $account_id);
        }
		$sum       = $query->count();
		if($sum>0){
			$totalPage = ($sum % $limit) == 0 ? intval($sum / $limit) : intval($sum / $limit) + 1;
			$page      = $totalPage > $page ? $page : $totalPage;
			$min       = ($page-1) * $limit;
			$rows      = $query->orderBy('is_default','desc')->skip($min)->take($limit)->get();
		}else{
			$totalPage = $page = 0;
			$rows = array();
		}

		$resultData = array();
		$resultData['rows']      = $rows;
		$resultData['total']     = $sum;
		$resultData['limit']     = $limit;
		$resultData['page']      = $page;
		$resultData['totalPage'] = $totalPage ;

		return $resultData;
	}

	public function deleteAddress($address_id, $sys_account_id) {
        try {
            $model = UserAddress::where('address_id', '=', $address_id)->where('account_id', '=', $sys_account_id)->first();
            if(!$model) return false;
            if($model->is_default) {
                $currModel = UserAddress::where('account_id', $sys_account_id)->first();
                if(!is_null($currModel)) {
                    $currModel->is_default = 1;
                    $currModel->save();
                }
            }
            return $model->delete();
        } catch (\Exception $e) {
            return false;
        }
    }

    public function addAddress($data, $sys_account_id)
    {
        $data['account_id'] = $sys_account_id;
        $data['receiver_country'] = 'CN';
        $count = UserAddress::where('account_id', $sys_account_id)->count();
        if($count == 0) {
            $data['is_default'] = 1;
        }
        $data['is_default']  = isset($data['is_default']) && boolval($data['is_default']) == true ? 1 : 0;
        try {
            $addrModel = UserAddress::create($data);
            if(!$addrModel) return false;
            if($data['is_default'] == 1) {
                UserAddress::where('account_id', $sys_account_id)
                    ->where('address_id','<>',$addrModel->address_id)
                    ->update(['is_default' => 0]);
            }
            return $addrModel;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function updateAddress($data, $address_id, $sys_account_id)
    {
        unset($data['address_id']);
        $data['is_default']  = isset($data['is_default']) && boolval($data['is_default']) == true ? 1 : 0;
        try {
            $addr = UserAddress::where('address_id', '=', $address_id)->where('account_id', '=', $sys_account_id)->first();
            if($addr === false) {
                return false;
            }
            if($addr->update($data) === false) return false;
            if($data['is_default'] == 1) {
                UserAddress::where('account_id', $sys_account_id)
                    ->where('address_id','<>',$address_id)
                    ->update(['is_default' => 0]);
            }
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getAddress($address_id, $sys_account_id)
    {
        try {
            return UserAddress::where('address_id', '=', $address_id)->where('account_id', '=', $sys_account_id)->first();
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getDefaultAddress($sys_account_id)
    {
        try {
            return UserAddress::where('is_default', '=', 1)->where('account_id', '=', $sys_account_id)->first();
        } catch (\Exception $e) {
            return false;
        }
    }
}
