<?php
/*****************************************************************************************************************
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/9/1
 * Time: 16:33
 *****************************************************************************************************************/

namespace App\Services;

use App\Dao\SectionDao;
use App\Dao\GroupDao;
use App\Dao\GroupMemberDao;
use App\Dao\MemberGrantDao;
use App\Http\SDP_DEFINE;

use App\Http\Utils;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SectionService
{

    function __construct()
    {

    }

    public function querySection($arrData){

        $SectionDao = new SectionDao();
        return $SectionDao->querySection($arrData);
    }

    /**根据ID获取帐号信息
     * @param 帐号 $id
     * @return array
     */
    public function getSectionById($id)
    {
        $SectionDao = new SectionDao();
        return $SectionDao->getSectionById($id);
    }

    /**
     * @param $arrData
     * @return bool
     */
    public function updateSection($arrData)
    {
        $SectionDao = new SectionDao();
        return $SectionDao->updateSection($arrData);
    }

    /**新增
     * @param
     * @return array
     */
    public function insertSection($arrData)
    {
        $SectionDao = new SectionDao();
        return $SectionDao->insertSection($arrData);
    }

    /**删除帐号
     * @param
     * @return array
     */
    public function deleteSectionById($section_id)
    {
        $SectionDao = new SectionDao();
        $SectionDao->deleteSectionById($section_id);
        //删除与账号有关的表数据

        return true;
    }


}
