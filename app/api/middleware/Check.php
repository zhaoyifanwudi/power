<?php
namespace app\api\middleware;
class Check{
    public function handle($request,\Closure $next){
        return $next($request);
    }
}