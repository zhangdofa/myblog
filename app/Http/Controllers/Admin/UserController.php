<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\User;
use App\Model\Admin;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
     //
    function __construct($foo = null)
    {
        // $this->middleware('auth');
    }

     public function index($value='')
    {
    	# code...
        $this->user();
    	$data = User::orderBy('created_at', 'desc')->paginate(35);
        $data1 = $data->toArray();
    	return view('admin.user',['data'=>$data1,'next' => $data]);
    }

    public function user($value='')
    {
        # code...
        $this->user = Auth::user()->toArray();
    }

    public function delete(Request $request)
    {
    	# code...
    	$id = $request->input('id');
    	$res = User::where('id',$id)->delete();
    	if ($res) {
    		# code...
    		echo ("<script>alert('删除成功！');location.href='".$_SERVER["HTTP_REFERER"]."';</script>");
    	}else{
    		echo("<script>alert('删除失败，请重试！');location.href='".$_SERVER["HTTP_REFERER"]."';</script>");
    	}
    }

	public function delete1(Request $request)
	    {
	    	# code...
	    	$id = $request->input('id');
	    	$res = User::where('id',$id)->delete();
	    	if ($res) {
	    		# code...
	    		echo ("<script>alert('删除成功！');location.href='".route('admin.user')."';</script>");
	    	}else{
	    		echo("<script>alert('删除失败，请重试！');location.href='".$_SERVER["HTTP_REFERER"]."';</script>");
	    	}
	    }

    public function find(Request $request)
    {
        # code...
        if (isset($request->title) && !empty($request->title)) {
            $data=User::Where('name','like','%'.$request->title.'%')
            ->paginate(35);
            $data1 = $data->toArray();
            return view('admin.user',['data1' => $data1,'find' => $request->title,'next' => $data]);
        }
    }

    public function admininfo($value='')
    {
    	# code...
        $this->user();
    	return view('admin.user',['admin'=>$this->user]);
    }
}
	