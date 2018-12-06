<?php
/**
 * Created by PhpStorm.
 * User: Saviorlv(mrk-s)
 * Date: 2018/10/9
 * Time: 16:01
 * Email: 1042080686@qq.com
 */

namespace app\common\components\auth;

use app\common\model\AuthRuleModel;
use think\facade\Config;
use think\facade\Request;
use think\facade\Session;

class AuthUtil
{
    public static $user;//登录用户信息

    public static $page_name;//当前页面功能名
    public static $curr_path;//当前链接
    public static $currFunction;//当前功能
    public static $menuList;//菜单列表
    public static $curr_parent_menu;//当前菜单所属的父菜单
    public static $curr_menu;//当前菜单

    /**
     * @return bool|mixed
     */
    public static function checkLogin() {
        if(Session::get('userInfo')!==null) {
            self::$user = Session::get('userInfo');
            return self::$user;
        } else {
            return false;
        }
    }

    /**
     * 检测权限
     * @return bool
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function checkAuth() {
        $request = Request::instance();
        //$rule_name = '/' . $request->path();

        $m = $request->module();
        $c = $request->controller();
        $a = $request->action();
        $rule_name = $m . '/' . $c . '/' . $a;

        $rule_name = strtolower($rule_name);

        $userID = Session::get('userInfo.id');
        $model = new AuthRuleModel();
        $result = $model->checkAuthRule($userID, $rule_name);
        if (!$result) {
            return false;
        }else{
            return true;
        }
    }

    /**
     * 生成菜单
     */
    public static function createMenu() {
        $request = Request::instance();
        $m = $request->module();
        $c = $request->controller();
        $a = $request->action();
        $rule_name = $m . '/' . $c . '/' . $a;

        $params = $menuList = [];
        self::$user && $params['hag.id'] = self::$user['group_id'];
        $all_menu = self::getUserRule($params);
        if(is_array($all_menu) && count($all_menu)>0){
            foreach ($all_menu as $k=>$v){
                if($v['pid']=='0'){
                    $menuList[$v['id']] = [
                        'id'=> $v['id'],
                        'pid'=> $v['pid'],
                        'title'=> $v['title'],
                        'rule'=> $v['rule'],
                        'route'=> $v['name'],
                        'highlight'=> $v['highlight'],
                        'icon'=> $v['icon'],
                        'is_menu'=> $v['is_menu'],
                        'subMenu' => []
                    ];
                }else{
                    $menuList[$v['pid']]['subMenu'][]=[
                        'id'=> $v['id'],
                        'pid'=> $v['pid'],
                        'title'=> $v['title'],
                        'rule'=> $v['rule'],
                        'route'=> $v['name'],
                        'highlight'=> $v['highlight'],
                        'icon'=> $v['icon'],
                        'is_menu'=> $v['is_menu'],
                    ];
                }
            }
        }

        foreach ($menuList as $val){
            foreach ($val['subMenu'] as $v){
                if(strtolower($rule_name)==strtolower($v['route'])){
                    self::$curr_path = $v['rule'];
                    self::$curr_menu = $v;
                    self::$curr_parent_menu = $menuList[$v['pid']];
                }
            }
        }

        return $menuList;
    }

    /**
     * @return array|false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function getAllRule(){
        $model = new AuthRuleModel();
        return $model->getAllAuthRule([]);
    }

    /**
     * @param array $params
     * @return array|false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function getUserRule($params=[]){
        $model = new AuthRuleModel();
        if(false!==Config::get('auth_check')){
            return $model->getGroupRule($params)->toArray();
        }else{
            return $model->getAllAuthRule([]);
        }

    }

    /**
     * 初始化权限
     * @param array $authData
     */
    public static function initAuth($authData) {

    }

    /**
     * 响应数据
     * @param string $Code 响应码
     * @param string $Msg 响应信息
     * @param array $Data 响应数据
     * @return string
     */
    private static function Response($Code = '0', $Msg = '接口请求成功', $Data = []) {
        $result = array(
            'Code'=>$Code,
            'Msg'=>$Msg,
            'Data'=>$Data
        );
        header("Content-type: text/html; charset=utf-8");
        echo json_encode($result);
        exit();
    }

}