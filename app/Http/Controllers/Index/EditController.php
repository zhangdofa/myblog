<?php

namespace App\Http\Controllers\index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Contents;
use App\Http\Verify\Verify;

class EditController extends Controller
{
    //
    function __construct(Verify $verify){
    	$this->Verify = $verify;
    }
    
    public function edit(Request $request)
    {
    	# code...
        $id = $request->input('id');
            $data = Contents::where('id',$id)->first();
            return view('index.edit',['data' => $data]);
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
        	echo ("<script>alert('修改成功！');history.go(-2);</script>");
        }else{
            return $res;
        }
    }
}
