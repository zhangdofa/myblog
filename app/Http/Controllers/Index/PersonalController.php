<?php

namespace App\Http\Controllers\Index;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Model\Contents;
// use Laravel\Scout\Searchable;

class PersonalController extends Controller
{
    //
    public function showpersonal(Request $request)
    {
    	# code...
    	$data = Contents::where('user_id',Auth::user()->id)->orderBy('created_time', 'desc')->paginate(35);
        $data1 = $data->toArray();
    	return view('index.personal',['data' => $data1,'next' => $data]);
    }


    public function find_result(Request $request)
    {
        # code...
        if (isset($request->title) && !empty($request->title)) {
            $data=Contents::where('user_id',Auth::user()->id)
            ->where('title','like','%'.$request->title.'%')
            ->orderBy('created_time', 'desc')
            ->paginate(35);
            $data1 = $data->toArray();
            return view('index.personal',['data1' => $data1,'find' => $request->title,'next' => $data]);
        }else{
            echo('<script>alert("查找内容不能为空！");history.go(-1);</script>');
        }
    }


    public function delete_article(Request $request)
    {
    	# code...
    	$id = $request->input('id');
    	$res = Contents::where('id',$id)->delete();
    	if ($res) {
    		# code...
    		echo ("<script>alert('删除成功！');location.href='".$_SERVER["HTTP_REFERER"]."';</script>");
    	}else{
    		echo("<script>alert('删除失败，请重试！');location.href='".$_SERVER["HTTP_REFERER"]."';</script>");
    	}
    }

}
