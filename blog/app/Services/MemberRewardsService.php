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
use App\Http\SDP_DEFINE;
use App\Models\Account;
use App\Http\Utils;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Mockery\CountValidator\Exception;

class MemberRewardsService {

    function __construct()
    {

    }

    public function queryMemberRewards($arrData){

        $MemberRewardsDao = new MemberRewardsDao();
        return $MemberRewardsDao->queryMemberRewards($arrData);
    }

    public function queryRewardMemberRewards($arrData){

        $MemberRewardsRewardDao = new MemberRewardsRewardDao();
        return $MemberRewardsRewardDao->queryRewardMemberRewards($arrData);
    }

    /**根据ID获取帐号信息
     * @param 帐号$id
     * @return array
     */
    public function getMemberRewardsById($id){
        $MemberRewardsDao = new MemberRewardsDao();
        return $MemberRewardsDao->getMemberRewardsById($id);
    }

    public function getMemberRewardsRewardById($turntable_event_id){
        $MemberRewardsRewardDao = new MemberRewardsRewardDao();
        return $MemberRewardsRewardDao->getMemberRewardsRewardById($turntable_event_id);
    }

    public function getMemberRewardsRewardByRewardId($turntable_event_reward_id){
        $MemberRewardsRewardDao = new MemberRewardsRewardDao();
        return $MemberRewardsRewardDao->getMemberRewardsRewardByRewardId($turntable_event_reward_id);
    }

    public function insertMemberRewards($arrData){

        $MemberRewardsDao = new MemberRewardsDao();
        $MemberRewardsDao->insertMemberRewards($arrData);
        return true;
    }
    /**
     * @param $arrData
     * @return bool
     */
    public function updateMemberRewards($arrData)
    {

        $MemberRewardsDao = new MemberRewardsDao();
        return $MemberRewardsDao->updateMemberRewards($arrData);
    }

    public function getMemberRewardsRewardsById($id){

        $MemberRewardsRewardDao = new MemberRewardsRewardDao();
        return $MemberRewardsRewardDao->getMemberRewardsRewardsByMemberRewardsId($id);
    }

    public function updateMemberRewardsReward($arrData){

        $MemberRewardsRewardDao = new MemberRewardsRewardDao();
        $MemberRewardsRewardDao->updateMemberRewardsReward($arrData);
        return true;
    }

    public function insertMemberRewardsReward($arrData){

        $MemberRewardsRewardDao = new MemberRewardsRewardDao();
        $MemberRewardsRewardDao->insertMemberRewardsReward($arrData);
        return true;
    }

    public function getMemberRewardsPageWithIDAndIndex($rt_galary_id,$page)
    {
        $MemberRewardsRewardDao = new MemberRewardsRewardDao();
        return  $MemberRewardsRewardDao->getMemberRewardsPageWithIDAndIndex($rt_galary_id,$page);
    }

}


