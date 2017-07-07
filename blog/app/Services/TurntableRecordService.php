<?php
/*****************************************************************************************************************
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/9/1
 * Time: 16:33
 *****************************************************************************************************************/

namespace App\Services;


use App\Dao\TurntableRecordDao;
use App\Dao\TurntableRecordRewardDao;
use App\Dao\AccountDao;
use App\Http\SDP_DEFINE;
use App\Models\Account;
use App\Http\Utils;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TurntableRecordService {

	function __construct()
	{
		 
	}

	public function queryTurntableRecord($arrData){

        $TurntableRecordDao = new TurntableRecordDao();
		return $TurntableRecordDao->queryTurntableRecord($arrData);
	}

    public function queryRewardTurntableRecord($arrData){

        $TurntableRecordRewardDao = new TurntableRecordRewardDao();
        return $TurntableRecordRewardDao->queryRewardTurntableRecord($arrData);
    }

	/**根据ID获取帐号信息
	 * @param 帐号$id
	 * @return array
	 */
	public function getTurntableRecordById($id){
		$TurntableRecordDao = new TurntableRecordDao();
		return $TurntableRecordDao->getTurntableRecordById($id);
	}

  public function getTurntableRecordRewardById($turntable_event_id){
      $TurntableRecordRewardDao = new TurntableRecordRewardDao();
      return $TurntableRecordRewardDao->getTurntableRecordRewardById($turntable_event_id);
    }

    public function getTurntableRecordRewardByRewardId($turntable_event_reward_id){
        $TurntableRecordRewardDao = new TurntableRecordRewardDao();
        return $TurntableRecordRewardDao->getTurntableRecordRewardByRewardId($turntable_event_reward_id);
    }

    public function insertTurntableRecord($arrData){

        $TurntableRecordDao = new TurntableRecordDao();
        $TurntableRecordDao->insertTurntableRecord($arrData);
        return true;
    }
    /**
     * @param $arrData
     * @return bool
     */
    public function updateTurntableRecord($arrData)
    {

        $TurntableRecordDao = new TurntableRecordDao();
        return $TurntableRecordDao->updateTurntableRecord($arrData);
    }

	public function getTurntableRecordRewardsById($id){

		$TurntableRecordRewardDao = new TurntableRecordRewardDao();
		return $TurntableRecordRewardDao->getTurntableRecordRewardsByTurntableRecordId($id);
	}

	public function updateTurntableRecordReward($arrData){

		$TurntableRecordRewardDao = new TurntableRecordRewardDao();
        $TurntableRecordRewardDao->updateTurntableRecordReward($arrData);
        return true;
    }

    public function insertTurntableRecordReward($arrData){

        $TurntableRecordRewardDao = new TurntableRecordRewardDao();
        $TurntableRecordRewardDao->insertTurntableRecordReward($arrData);
        return true;
    }

    public function getTurntableRecordPageWithIDAndIndex($rt_galary_id,$page)
    {
        $TurntableRecordRewardDao = new TurntableRecordRewardDao();
        return  $TurntableRecordRewardDao->getTurntableRecordPageWithIDAndIndex($rt_galary_id,$page);
    }

    public function getTurntableRecordOneById($id){
        $arrData =array();
        $TurntableRecordDao = new TurntableRecordDao();
        $arrData["turntable"] = $TurntableRecordDao->getTurntableRecordById($id);
        $TurntableRecordRewardDao = new TurntableRecordRewardDao();
        $arrData["reward"] = $TurntableRecordRewardDao->getTurntableRecordRewardById($id);
        return ($arrData);
    }

    public function oneclickTurntableRecord($arrData){

        account=$arrData["account"];
        $AccountDao=AccountDao();
        $AccountDao->updateAccountPoint();
        $PointRecordDao=PointRecordDao();
        $PointRecordDao->updatePointRecord();
        $TurntableRecordDao = new TurntableRecordDao();
        $arrData["turntable"] = $TurntableRecordDao->updateOneclickTurntableRecord($id);
        $TurntableRecordRecordDao = new TurntableRecordRecordDao();
        $arrData["reward"] = $TurntableRecordRecordDao->insertTurntableRecordRecord($id);
        return ($arrData);
    }
}


