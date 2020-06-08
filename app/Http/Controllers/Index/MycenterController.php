<?php

namespace App\Http\Controllers\index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Verify\UploadImg;
use App\Model\User;

class MycenterController extends Controller
{
    //
    public function index()
    {
    	# code...
    	$res = Auth::user();
    	// var_dump($res);
    	return view('index.mycenter',['data' => $res]);
    }

    public function uploadimg(Request $request)
    {
    	# code...
    	$file = $request->file('title_img');
        if ($file) {
            # code...

            $file_ext = $file->extension();  //获取图片后缀
            $file_type = ['jpeg','jpg','gif','gpeg','png'];
            if (in_array(strtolower($file_ext),$file_type)) {
            	# code...
        		$path = $file->store('public');
        		$user = User::find(Auth::id());
        		$user->avatars = Storage::url($path);
        		$user->save();
        		return back();
            }else{
                exit('图片类型只能为：jpeg、jpg、gif、gpeg、png');
            }
        }else{
            exit('请选择图片！');
        }
    }
}
