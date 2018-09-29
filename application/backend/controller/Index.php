<?php
namespace app\backend\controller;

use app\common\controller\baseAdmin;

class Index extends baseAdmin
{
    public function index()
    {
        phpinfo();
    }
}
