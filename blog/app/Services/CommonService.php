<?php

/*****************************************************************************************************************
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/9/1
 * Time: 16:33
 *****************************************************************************************************************/

namespace App\Services;


class CommonService
{

    /**
     * @param
     * @return
     */
    public static function getUnpriviligedRoutes($account_id){
        return \DB::select('SELECT
                                mf2.sys_mod_func_method,
                                mf2.sys_mod_func_url
                            FROM
                                sys_mod_func AS mf2
                            LEFT JOIN (
                                SELECT DISTINCT
                                    mf.sys_mod_id,
                                    mf.sys_mod_func_id
                                FROM
                                    account AS a
                                LEFT JOIN s_group_member AS gm ON a.sys_account_id = gm.sys_account_id
                                LEFT JOIN s_role_right AS rr ON gm.s_role_id = rr.s_role_id
                                LEFT JOIN sys_mod_func AS mf ON mf.sys_mod_func_id = rr.sys_mod_func_id
                                AND mf.sys_mod_id = rr.sys_mod_id
                                WHERE
                                    a.sys_account_id = ?
                                AND NOT ISNULL(mf.sys_mod_id)
                            ) AS mf1 ON mf2.sys_mod_func_id = mf1.sys_mod_func_id AND mf2.sys_mod_id = mf1.sys_mod_id
                            WHERE ISNULL(mf1.sys_mod_id) ', [$account_id]);
    }


    /**todo
     * @param
     * @return
     */
    public static function matchUri($pattern,$uri){
        $match = false;
        $parse	=	new \FastRoute\RouteParser\Std();
        $routeData = $parse->parse($pattern);
        if(count($routeData) == 1 && is_string($routeData[0])){
            if($uri == $routeData[0]){
                $match = true;
            }
        }else{
            $regex = '';
            $variables = array();
            foreach ($routeData as $part) {
                if (is_string($part)) {
                    $regex .= preg_quote($part, '~');
                    continue;
                }
                list($varName, $regexPart) = $part;

                if (isset($variables[$varName])) {
                    throw new BadRouteException(sprintf(
                        'Cannot use the same placeholder "%s" twice', $varName
                    ));
                }
                $variables[$varName] = $varName;
                $regex .= '(' . $regexPart . ')';
            }
            if (preg_match('~^'. $regex.'$~' , $uri,$matches)) {
                $match = true;
            }
        }
        return $match;
    }
}