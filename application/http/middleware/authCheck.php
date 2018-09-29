<?php

namespace app\http\middleware;

class authCheck
{
    public function handle($request, \Closure $next)
    {
        return $next($request);
    }
}
