<?php
namespace app\api\controller;

use app\common\controller\baseApi;

class Index extends baseApi
{
    public function index()
    {
        return "api-modules";
    }
}
