<?php
namespace App\Http\Verify;

use URL;
use Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Model\User;
use Illuminate\Support\Facades\Redis;

/**
 * 验证
 */
class Verify extends Controller
{
	//进行登录验证
	public function login_verify($request)
	{
		# code...
		//登录验证规则
    	$validator = Validator::make($request->all(), [
            'username' => 'required|max:20',
            'password' => 'required|min:6',
        ]);
        if ($validator->fails()) {
            return redirect('index/login')
                        ->withErrors($validator)
                        ->withInput();
        }

        //验证无误与数据库进行匹配
        $username = $request->input('username');
    	$password = $request->input('password');
        $data = User::where('name',$username)->first();
	    $data = json_decode(json_encode($data),true);
    	if ($data) {
    		# code...
    		if (Hash::check($password,$data['password'])) {
    			# code...
                $user_id = $data['id'];
                // 在 Session 中存储一条数据...
                    # code...
                $credentials = array('name' => $username,'password' => $password );
                
                return $this->authenticate($credentials,$request,$user_id);
		    	// $name = $data['name'];
       //          // 在 Session 中存储一条数据...
       //          session(['name' => $name]);
		    	// return redirect('index/home')->with('username',$name);
    		}
    		return redirect('index/login')->with('msg','password error!')->withInput();
    	}
    	return redirect('index/login')->with('msg','No account!')->withInput();
	}


     public function authenticate($credentials,$request,$user_id)
    {   
        if (Auth::guard()->attempt($credentials)) {
            // 身份验证通过...
            // session(['name' => $credentials['name']]);
            $timeStampNow = time();
            $userLoginIp = $request->getClientIp();
            // $user = Auth::user();
            // var_dump($user);
            $singleToken = md5($userLoginIp . $user_id . $timeStampNow);
            Redis::set('SINGLE_LOGIN_TOKEN_' . $user_id, $timeStampNow);
            Redis::set('SINGLE_UPPWD_TOKEN_' . $user_id, 'false');
            session(['SINGLE_LOGIN_TOKEN' => $singleToken,'SINGLE_UPPWD_TOKEN' => 'false']);
            $url = $request->session()->get('redirectPath');
            $request->session()->forget('redirectPath');
            return redirect($url);
            // return redirect()->intended()    ;
        }
    }

	//注册验证
	public function register_verify($request)
	{
		# code...
		//注册验证规则
		// var_dump($request->all());
		$validator = Validator::make($request->all(), [
            'name'=>'required|alpha|unique:users|between:2,20',
		    'email'=>'required|email|unique:users',
		    'pwd_confirmation'=>'required|alpha_num|between:6,12',
		    'pwd'=>'required|alpha_num|between:6,12|confirmed',
        ]);
            // $errors = $validator->errors(); // 输出的错误，自己打印看下
            // echo($errors);
        if ($validator->fails()) {
            return redirect('index/register')
                        ->withErrors($validator)
                        ->withInput();
        }

        $userinfo = $request->all();
        $user = new User();
        $user->name = $userinfo['name'];
        $user->email = $userinfo['email'];
        $user->password = Hash::make($userinfo['pwd']);
        $res = $user->save();
        if ($res) {
            # code...
            return redirect('index/login');
        }
        return view('index.register');
	}

    public function update_pwd($request)
    {
        # code...
        $validator = Validator::make($request->all(),[
            'pwd_confirmation'=>'required|alpha_num|between:6,12',
            'pwd'=>'required|alpha_num|between:6,12|confirmed',

        ]);
        return $validator;
       
    }
	

    public function publish_verify($request)
    {
        # code...
        $validator = Validator::make($request->all(),[
            'title'=>'required|max:47',
            'description'=>'required|max:255',
            'content' => 'required',
        ]);
        // $errors = $validator->errors(); 
        // echo($errors);
         if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        return 'true';
    }
}