<?php

namespace App\Http\Controllers\admin;

use Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Model\Admin;
use Illuminate\Support\Facades\Redis;

class LoginController extends Controller
{
    //

    function __construct($foo = null)
    {
        // $this->middleware('guest:admin')->except('logout');
    }
    public function index()
    {
    	return view('admin.login');
    }

    public function login(Request $request)
    {
    	# code...
    	return $this->login_verify($request);
    	
    }

    public function loginout($value='')
    {
        # code...
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
    //进行登录验证
	public function login_verify($request)
	{
		# code...
		//登录验证规则
    	$validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'password' => 'required|string',
        ]);
        if ($validator->fails()) {
            return redirect('admin/login')
                        ->withErrors($validator)
                        ->withInput();
        }

        //验证无误与数据库进行匹配
        $username = $request->input('name');
    	$password = $request->input('password');
        $data = Admin::where('name',$username)->first();
    	// $data = DB::select('select * from users where name = :name', ['name' => $username]);
	    $data = json_decode(json_encode($data),true);
    	if ($data) {
    		# code...
    		if (Hash::check($password,$data['password'])) {
    			# code...
		    	$user_id = $data['id'];
                // 在 Session 中存储一条数据...
                if ($data['authority'] == 1) {
                    # code...
                    $credentials = array('name' => $username,'password' => $password );
                    
                    return $this->authenticate($credentials,$request,$user_id);
                }
		    	return redirect('admin/login')->with('username',$name);
    		}
    		return redirect('admin/login')->with('msg','password error!')->withInput();
    	}
    	return redirect('admin/login')->with('msg','No account!')->withInput();
	}

	public function authenticate($credentials,$request,$user_id)
    {
        if (Auth::guard('admin')->attempt($credentials)) {
            // 身份验证通过...
            $timeStampNow = time();
            $userLoginIp = $request->getClientIp();
            // $user = Auth::user();
            // var_dump($user);
            $singleToken = md5($userLoginIp . $user_id . $timeStampNow);
            Redis::set('SINGLE_TOKEN_' . $user_id, $timeStampNow);
            session(['SINGLE_TOKEN' => $singleToken]);
            return redirect()->intended('admin/index');
        }
    }
}
