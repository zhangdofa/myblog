<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

class CheckLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::user();
        if ($user) {
            $cookieSingleToken = session('SINGLE_LOGIN_TOKEN');
            // var_dump($cookieSingleToken);
            if ($cookieSingleToken) {
                // 从 Redis 获取 time
                $lastLoginTimestamp = Redis::get('SINGLE_LOGIN_TOKEN_' . $user->id);
                // 重新获取加密参数加密
                $ip = $request->getClientIp();
                $redisSingleToken = md5($ip . $user->id . $lastLoginTimestamp);
                if ($cookieSingleToken != $redisSingleToken) {
                    //认定为重复登录了
                    // return "true";
                    // $request->session()->flush();
                    Auth::guard()->logout();
                    echo("<script>location.href='".route('index.login')."';</script>");
                    exit;
                }else{
                    return $next($request);
                }
            }
        }else{
             echo("<script>alert('您当前未登录！请先登录！');location.href='".route('index.login')."';</script>");
             exit;
        }
    }
}
