<?php

namespace App\Http\Controllers\Index;

use App\Model\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Verify\Sendemail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Http\Verify\Verify;
use Illuminate\Support\Facades\Redis;
use Validator;

class ResetPasswordController extends Controller
{
    //
    function __construct(Sendemail $sendemail,Verify $Verify)
    {
    	$this->sendemail = $sendemail;
    	$this->Verify = $Verify;
    }

    //展示发送重置密码邮件链接页面
    public function showresetpassword()
    {
    	# code...
    	return view('index.resetpassword');
    	
    } 

    //展示重置密码页面
    public function showresetpwd(Request $request)
    {
    	# code...
    	$username = $request->input('name');
    	$token = $request->input('token');
    	$len = iconv_strlen($username);
    	if ($len<=10) {
    		# code...
    		$username = $request->input('name');
    	}else{
    		$username = decrypt($request->input('name'));
    	}
    	return view('index.resetpwd',['name' => $username,'token' => $token]);
    	
    }

    //发送重置密码邮件
    public function resetpassword(Request $request)
    {
    	# code...
    	$username = $request->input('username');
    	$email = $request->input('email');
    	$data = DB::select('select * from users where name = :name and email = :email', ['name' => $username,'email' => $email]);
    	if ($data) {
    		# code...
    		$User = User::where('name',$username)->first();
    		$token = Str::random(60);
    		$token = hash('sha256', $token);
    		$User->resetpwd_token = $token;
    		$User->save();
    		$data = json_decode(json_encode($data),true);
    		$name = $data[0]['name'];
	    	return $this->sendemail->sendmail($email,$name,$token);
    	}
    	return redirect('index/resetpassword')->with('msg','您输入的用户名或邮箱有误！请重新输入！')->withInput();
    }

    //进行重置密码操作
    public function resetpwd(Request $request)
    {
    	# code...
    	$token = $request->input('token');
    	$username = $request->input('name');
    	$validator = $this->Verify->update_pwd($request);
    	if ($validator->fails()) {
            # code...
            $username = encrypt($username);
            return redirect('index/resetpwd?token='.$token.'&name='.$username)
            ->withErrors($validator)
            ->withInput();
        }
    	$data = User::where([
    		['name', '=', $username],
    		['resetpwd_token', '=', $token],
    	])->first();
    	if ($data) {
    		# code...
    		$pwd = $request->input('pwd');
            $pwd = Hash::make($pwd);
			$User = User::where('name',$username)->update(['password' => $pwd, 'resetpwd_token' => '']);
            if ($User) {
                # code...
                Redis::set('SINGLE_UPPWD_TOKEN_' . $data['id'], 'true');
                // $request->session()->flush();
                echo("<script>alert('修改成功！即将前往登录界面！');location.href='".route('index.login')."'</script>");
                exit;
            }else{
                echo("<script>alert('修改失败！请重新发送邮件！');location.href='".route('index.resetpassword')."'</script>");
                exit;
            }
    	}else{
    	   return redirect('index/resetpwd?token='.$token.'&name='.encrypt($username))->with('msg','您存在恶意修改数据行为，请重试！');
        }
    }
}
