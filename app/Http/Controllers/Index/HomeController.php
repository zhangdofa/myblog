<?php

namespace App\Http\Controllers\index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Contents;
use App\Model\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

class HomeController extends Controller
{
    //
    public function home(Request $request)
    {
    	# code...
        $user = Auth::user();
        // var_dump($user->id);
        if ($user) {
            $cookieSingleToken = session('SINGLE_LOGIN_TOKEN');
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
                    echo("<script>alert('您的账号已在别处登录！');</script>");
                    $data = Contents::orderBy('created_time', 'desc')->paginate(8);
                    return view('index.home',['data' => $data]);
                    // exit;
                }else{
                    $data = Contents::orderBy('created_time', 'desc')->withCount(['comments','zans'])->paginate(8);
                    return view('index.home',['data' => $data]);
                }
            }
        }
    	$data = Contents::orderBy('created_time', 'desc')->withCount(['comments','zans'])->paginate(8);
        return view('index.home',['data' => $data]);
    }


    public function loginout(Request $request)
    {
        # code...
        // $request->session()->flush();
        Auth::guard()->logout();
        $data = Contents::paginate(8);
        return redirect()->route('index.home', ['data' => $data]);
    }
}
