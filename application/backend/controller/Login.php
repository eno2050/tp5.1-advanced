<?php
/**
 * Created by PhpStorm.
 * User: Saviorlv(mrk-s)
 * Date: 2018/10/16
 * Time: 11:52
 * Email: 1042080686@qq.com
 */

namespace app\backend\controller;


use app\common\components\auth\AuthUtil;
use app\common\controller\BaseHome;
use app\common\service\AuthService;
use think\App;
use think\facade\Session;
use think\facade\Url;

class Login extends BaseHome
{
    protected $authService;
    public function __construct(AuthService $authService,App $app = null)
    {
        $this->authService = $authService;
        parent::__construct($app);
    }

    /**
     * @return \think\response\View
     */
    public function login(){
        $user = AuthUtil::checkLogin();
        if($user!==false){
            return redirect(Url::build('/admin/home'));
        }
        return view('login/index');
    }
    /**
     * 登陆
     * @return \think\Response
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function loginCheck(){
        $result = $this->authService->loginCheck();

        return $this->jsonResponse($result['Code'],$result['Msg'],$result['Data']);
    }

    /**
     * @return \think\response\Redirect
     */
    public function logout(){
        Session::delete('userInfo');

        return redirect(Url::build('/login'));
    }
}