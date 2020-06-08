<?php

namespace App\Http\Controllers\index;

use Validator;
use URL;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Verify\Verify;

class LoginController extends Controller
{
    //
    function __construct(Verify $verify)
    {
    	$this->Verify = $verify;
    }


    public function showlogin(Request $request)
    {
        if (Auth::user()) {
            # code...
            return redirect()->route('index.home');
        }
        $request->session()->put('redirectPath', URL::previous());
    	return view('index.login');
    }

    public function login(Request $request)
    {
    	# code...
    	
    	return $this->Verify->login_verify($request);
    	
    }

   
}
