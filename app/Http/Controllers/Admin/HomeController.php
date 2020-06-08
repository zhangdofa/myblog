<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Model\Contents;
use App\Http\Verify\Verify;
use Illuminate\Support\Facades\Redis;

class HomeController extends Controller
{
    //
     function __construct(Verify $verify){
    	$this->Verify = $verify;
        // $this->middleware('auth');
    }

    public function index(Request $request)
    {
    	# code...
    	$data = Contents::orderBy('created_time', 'desc')->paginate(35);
    	return view('admin.home',['data'=> $data]); 
    }
    public function find_result(Request $request)
    {
        # code...
        if (isset($request->title) && !empty($request->title)) {
            $data=Contents::Where('title','like','%'.$request->title.'%')
            ->orderBy('created_time', 'desc')
            ->paginate(35);
            return view('admin.home',['data1' => $data,'find' => $request->title]);
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

    
    public function edit(Request $request)
    {
    	# code...
    	$id = $request->input('id');
    	$data = Contents::where('id',$id)->first();
    	return view('admin.edit',['data' => $data]);
    }

    public function update(Request $request)
    {
    	# code...
    	$id = $request->input('id');
    	$title = $request->input('title');
        $description = $request->input('description');
    	$content = $request->input('content');
        $res = $this->Verify->publish_verify($request);
        if ($res == 'true') {
            # code...
        	$Content = Contents::find($id);
        	$Content->title = $title;
            $Content->description = $description;
        	$Content->content = $content;
        	$Content->save();
        	echo ("<script>alert('修改成功！');location.href='".route('admin.index')."';</script>");
        }else{
            return $res;
        }
    }

}
