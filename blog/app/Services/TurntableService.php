<?php
/*****************************************************************************************************************
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/9/1
 * Time: 16:33
 *****************************************************************************************************************/

namespace App\Services;


use App\Dao\AccountDao;
use App\Dao\MemberRewardsDao;
use App\Dao\ConsumeCatDao;
use App\Dao\PointDaoDao;
use App\Dao\TurntableDao;
use App\Dao\TurntableRewardDao;
use App\Dao\TurntableRecordDao;
use App\Http\SDP_DEFINE;
use App\Models\Account;
use App\Http\Utils;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Mockery\CountValidator\Exception;

class TurntableService {

    function __construct()
    {

    }

    public function queryTurntable($arrData){

        $TurntableDao = new TurntableDao();
        return $TurntableDao->queryTurntable($arrData);
    }

    public function queryRewardTurntable($arrData){

        $TurntableRewardDao = new TurntableRewardDao();
        return $TurntableRewardDao->queryRewardTurntable($arrData);
    }

    /**根据ID获取帐号信息
     * @param 帐号$id
     * @return array
     */
    public function getTurntableById($id){
        $TurntableDao = new TurntableDao();
        return $TurntableDao->getTurntableById($id);
    }

    public function getTurntableRewardById($turntable_event_id){
        $TurntableRewardDao = new TurntableRewardDao();
        return $TurntableRewardDao->getTurntableRewardById($turntable_event_id);
    }

    public function getTurntableRewardByRewardId($turntable_event_reward_id){
        $TurntableRewardDao = new TurntableRewardDao();
        return $TurntableRewardDao->getTurntableRewardByRewardId($turntable_event_reward_id);
    }

    public function insertTurntable($arrData){

        $TurntableDao = new TurntableDao();
        $TurntableDao->insertTurntable($arrData);
        return true;
    }
    /**
     * @param $arrData
     * @return bool
     */
    public function updateTurntable($arrData)
    {

        $TurntableDao = new TurntableDao();
        return $TurntableDao->updateTurntable($arrData);
    }

    public function updateTurntableReward($arrData){

        $TurntableRewardDao = new TurntableRewardDao();
        $TurntableRewardDao->updateTurntableReward($arrData);
        return true;
    }

    public function insertTurntableReward($arrData){

        $TurntableRewardDao = new TurntableRewardDao();
        $TurntableRewardDao->insertTurntableReward($arrData);
        return true;
    }

    public function deleteTurntable($id)
    {
        $TurntableDao = new TurntableDao();
        return  $TurntableDao->deleteTurntableById($id);
    }

    public function deleteTurntableReward($id)
    {
        $TurntableRewardDao = new TurntableRewardDao();
        return  $TurntableRewardDao->deleteTurntableRewardById($id);
    }

    public function getTurntableOne($request)
    {
        $turntable_event_id=$request['turntable_event_id'];
        $arrData =array();
        $TurntableRewardDao = new TurntableRewardDao();
        $arrData["turntableReward"] = $TurntableRewardDao->getTurntableRewardById($turntable_event_id);
        $TurntableDao = new TurntableDao();
        $arrData["turntable"] = $TurntableDao->getTurntableById($turntable_event_id);

        return ($arrData);
    }


    public function oneclickTurntable($request){

        $sys_account_id=$request['sys_account_id'];
        $turntable_event_id=$request['turntable_event_id'];
        $data8 = DB::table('point')
            ->select('point.*' )
            ->where('point.sys_account_id', $sys_account_id)->first();//获取当前拥有的积分数
        $arrData1 =array();//存储返回给前台的json数组信息
        $TurntableDao = new TurntableDao();
        $data = $TurntableDao->getTurntableById($turntable_event_id);
        $sum=$data->turntable_event_sum_games;
        if($data->turntable_event_pointcost_one_time > $data8->point_current_total){
            $arrData1{'hint'}=1;
        }//当前的积分是否够玩此游戏
        else{
            $hint=0;
            $TurntableRewardDao = new TurntableRewardDao();
            $rows = $TurntableRewardDao->getTurntableRewardById($turntable_event_id);//获取所有奖项信息
            $record=0;
            foreach ($rows as $item) {
                $qty=$item->turntable_event_reward_qty-$item->turntable_event_rewarded_qty;//依次获每个奖取当下还剩多少个奖
                $record += $qty;
                $arrData2[] = $record;
            }
            $rnd = rand(1, $sum);
            if(0<$rnd&&$rnd<=$arrData2[0]){
                $a=1;
            }elseif($arrData2[0]<$rnd&&$rnd<=$arrData2[1]){
                $a=2;
            }elseif($arrData2[1]<$rnd&&$rnd<=$arrData2[2]){
                $a=3;
            }elseif($arrData2[2]<$rnd&&$rnd<=$sum){
                $a=0;
            }
            $data1 =array();//存储新增写入抽奖记录的数组
            $data2 =array();//存储更新剩余抽奖总次数的数组
            $data3 =array();//中奖后，存储剩余的奖品数量的数组
            $data4 =array();//中几等奖，存储查出的几等奖信息的数组
            $data5 =array();//写入积分消耗表的数组
            $data6 =array();//更新积分表剩余积分数的数组
            $data7 =array();//写入中奖信息表的数组
            switch ($a) {
                case 0:// 没中奖
                    $returnobj = 0;
                    $arrData1=compact('returnobj','hint');
                    $data1['turntable_event_record_reward']   = 0 ;
                    $data1['turntable_event_record_hit_if']   = 0 ;
                    break;
                case 1:// 一等奖
                    $returnobj = 1;
                    $index=0;
                    $data4 = $TurntableRewardDao->getTurntableRewardByIdLevel($turntable_event_id,"1");
                    $data1['turntable_event_record_reward']   = 1 ;
                    $data1['turntable_event_record_hit_if']   = 1 ;
                    break;
                case 2:// 二等奖
                    $returnobj = 1;
                    $index=1;
                    $data4 = $TurntableRewardDao->getTurntableRewardByIdLevel($turntable_event_id,"2");
                    $data1['turntable_event_record_reward']   = 2 ;
                    $data1['turntable_event_record_hit_if']   = 1 ;
                    break;
                case 3:// 三等奖
                    $returnobj = 1;
                    $index=2;
                    $data4 = $TurntableRewardDao->getTurntableRewardByIdLevel($turntable_event_id,"3");
                    $data1['turntable_event_record_reward']   = 3 ;
                    $data1['turntable_event_record_hit_if']   = 1 ;
                    break;
            }
            $data2['turntable_event_sum_games']=$data->turntable_event_sum_games-1;

            $data2['turntable_event_id']=$turntable_event_id;
            $data1['turntable_event_record_cost_points']=$data->turntable_event_pointcost_one_time;
            $data1['turntable_event_id']=$turntable_event_id;
            $data1['sys_account_id']=$sys_account_id;
            $data5['sys_account_id']=$sys_account_id;
            $data5['consume_point_number']=$data->turntable_event_pointcost_one_time;
            $data6['point_current_total']= DB::table('point')->select('point.*' )
                ->where('point.sys_account_id', $sys_account_id)->first()->point_current_total-$data5['consume_point_number'];
            $data7['sys_account_id']=$sys_account_id;
            if($a!=0){
                $arrData1=compact('index','returnobj','hint');
                $data3['turntable_event_rewarded_qty']=$data4->turntable_event_rewarded_qty +1;
                $data3['turntable_event_reward_id']=$data4->turntable_event_reward_id ;
                $data7['member_reward_title']=$data4->turntable_event_reward_title ;
                $data7['member_reward_desc']=$data4->turntable_event_reward_desc ;
                $data7['member_reward_image']=$data4->turntable_event_reward_img_path ;
            }
            DB::beginTransaction();
            try{
                if($a!=0){
                    $MemberRewardsDao = new MemberRewardsDao();
                    $MemberRewardsDao->insertMemberRewards($data7);
                    $TurntableRewardDao = new TurntableRewardDao();
                    $TurntableRewardDao->updateOneclickTurntable($data3);
                }
                $TurntableDao = new TurntableDao();
                $TurntableDao->updateOneclickTurntable($data2);
                $TurntableRecordDao = new TurntableRecordDao();
                $TurntableRecordDao->insertTurntableRecord($data1);
                $ConsumeCatDao = new ConsumeCatDao();
                $ConsumeCatDao->insertConsumeCat($data5);
                DB::table('point')
                    ->where('point.sys_account_id', $sys_account_id)
                    ->update($data6);
            }catch(Exception $e ){
                DB::rollBack();
            }
            DB::commit();
        }
        return ($arrData1);
    }

}


