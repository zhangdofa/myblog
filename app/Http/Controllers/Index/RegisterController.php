<?php

namespace App\Http\Controllers\index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Verify\Verify;

class RegisterController extends Controller
{
    //
    function __construct(Verify $Verify)
    {
        $this->Verify = $Verify;
    }

    public function showregister()
    {
    	# code...
        if (Auth::user()) {
            # code...
            return redirect()->route('index.home');
        }
    	return view('index.register');
    }

    public function register(Request $request)
    {
    	# code...
        return $this->Verify->register_verify($request);
	}
}
