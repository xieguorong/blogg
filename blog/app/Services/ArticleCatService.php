<?php

/*****************************************************************************************************************
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/9/1
 * Time: 16:33
 *****************************************************************************************************************/

namespace App\Services;

use App\Dao\ArticleCatDao;

class ArticleCatService {

    function __construct()
    {
    }

    /**根据ID查询群组成员
     * @param
     * @return
     */
    public function queryArticleCat($arrData){

        $ArticleCatDao = new ArticleCatDao();
        return $ArticleCatDao->queryArticleCat($arrData);
    }

    /**根据ID获取群组成员信息
     * @param
     * @return
     */
    public function getArticleCatById($article_cat_id){

        $ArticleCatDao = new ArticleCatDao();

        return $ArticleCatDao->getArticleCatById($article_cat_id);
    }

    /**新增群组成员
     * @param
     * @return
     */
    public function insertArticleCat($arrData){

        $ArticleCatDao = new ArticleCatDao();

        return $ArticleCatDao->insertArticleCat($arrData);
    }

    /**更新群组成员
     * @param
     * @return
     */
    public function updateArticleCat($arrData, $article_cat_id){

        $ArticleCatDao = new ArticleCatDao();

        return $ArticleCatDao->updateArticleCat($arrData, $article_cat_id);
    }


    /**根据ID删除群组成员
     * @param
     * @return
     */
    public function deleteArticleCatById($article_cat_id){

        $ArticleCatDao = new ArticleCatDao();

        return $ArticleCatDao->deleteArticleCatById($article_cat_id);

    }
    
}
