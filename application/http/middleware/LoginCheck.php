<?php
/**
 * Created by PhpStorm.
 * User: Saviorlv(mrk-s)
 * Date: 2018/10/17
 * Time: 11:54
 * Email: 1042080686@qq.com
 */

namespace app\http\middleware;


class LoginCheck
{
    public function handle($request, \Closure $next)
    {
        return $next($request);
    }

}