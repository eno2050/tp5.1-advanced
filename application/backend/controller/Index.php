<?php
namespace app\backend\controller;

use app\common\controller\BaseAdmin;

class index extends BaseAdmin
{
    /**
     * 首页
     * @return \think\response\View
     */
    public function index()
    {
        return $this->loadFrame('index/index');
    }
}
