<?php

/*****************************************************************************************************************
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/9/1
 * Time: 16:33
 *****************************************************************************************************************/

namespace App\Services;

use App\Dao\ArticleDao;

class ArticleService {

    function __construct()
    {
    }

    /**根据ID查询群组成员
     * @param
     * @return
     */
    public function queryArticle($arrData){

        $ArticleDao = new ArticleDao();
        return $ArticleDao->queryArticle($arrData);
    }

    /**根据ID获取群组成员信息
     * @param
     * @return
     */
    public function getArticleById($article_id){

        $ArticleDao = new ArticleDao();

        return $ArticleDao->getArticleById($article_id);
    }

    /**新增群组成员
     * @param
     * @return
     */
    public function insertArticle($arrData){

        $ArticleDao = new ArticleDao();

        return $ArticleDao->insertArticle($arrData);
    }

    /**更新群组成员
     * @param
     * @return
     */
    public function updateArticle($arrData, $article_id){

        $ArticleDao = new ArticleDao();

        return $ArticleDao->updateArticle($arrData, $article_id);
    }


    /**根据ID删除群组成员
     * @param
     * @return
     */
    public function deleteArticleById($article_id){

        $ArticleDao = new ArticleDao();

        return $ArticleDao->deleteArticleById($article_id);

    }
    
}
