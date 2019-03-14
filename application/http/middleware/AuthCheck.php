<?php
/**
 * Created by PhpStorm.
 * User: mrk-sun
 * Date: 2018/10/09
 * Time: 14:10
 * @author saviorlv <1042080686@qq.com>
 */
namespace app\http\middleware;

use app\common\components\auth\AuthUtil;
use think\facade\Config;
use think\facade\Url;

/**
 * Class authCheck
 * @package app\http\middleware
 */
class AuthCheck
{
    /**
     * @param $request
     * @param \Closure $next
     * @return mixed|\think\response\Redirect|void
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function handle($request, \Closure $next)
    {
        //登录检测
        $user = AuthUtil::checkLogin();
        if($user!==false){
            $request->user = $user;
        }else{
            return redirect(Url::build('/login'));
        }
        if(Config::get('auth_check')!==false){
            //权限检测
            $res = AuthUtil::checkAuth();

            if(!$res){
                if($request->isAjax()){
                    return self::jsonResponse('403',"暂无该权限，请联系管理员");
                }else{
                    throw new \think\exception\HttpException(403, '暂无该权限，请联系管理员');
                }
            }
        }

        //生成菜单
        $request->menuList = AuthUtil::createMenu();
        $request->curr_parent_menu = AuthUtil::$curr_parent_menu;
        $request->curr_menu = AuthUtil::$curr_menu;
        $request->curr_path = AuthUtil::$curr_path;

        return $next($request);
    }

    /**
     * @param string $Code
     * @param string $Msg
     * @param array $Data
     */
    protected static function jsonResponse($Code = '0', $Msg = '请求成功', $Data=[])
    {
        $result = array(
            'Code'=>$Code,
            'Msg'=>$Msg,
            'Data'=>$Data
        );
        echo \json_encode($result,JSON_UNESCAPED_UNICODE);
        exit();
    }
}
