<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

class CheckPwdUpdate
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
            # code...
            $cookieSingleToken = session('SINGLE_UPPWD_TOKEN');
            if ($cookieSingleToken) {
                # code...
                $isupdate = Redis::get('SINGLE_UPPWD_TOKEN_' . $user->id);
                if ($isupdate != $cookieSingleToken) {
                    # code...
                    // $request->session()->flush();
                    Auth::guard()->logout();
                    // var_dump(Auth::user()->id);
                    return redirect('/index/home')->with('updatepwd','您的密码已经修改！如有需要请重新登录！');
                }
                return $next($request);
            }
            return $next($request);
        }
        return $next($request);
    }
}
