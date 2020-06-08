<?php

namespace App\Http\Controllers\index;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Model\Contents;
use App\Model\User;
use App\Http\Verify\Verify;

class PublishController extends Controller
{
    //
     function __construct(Verify $Verify)
    {
        $this->Verify = $Verify;
    }

    public function showpublish()
    {
	    # code...
		return view('index.publish');
	
    }

    public function publish(Request $request)
    {
    	# code...
        $id = Auth::user()->id;
    	$title = $request->input('title');
        $description = $request->input('description');
    	$content = $request->input('content');
        $res = $this->Verify->publish_verify($request);
        if ($res == 'true') {
            # code...
        	$Content = new Contents;
            $Content->user_id = $id;
        	$Content->title = $title;
            $Content->description = $description;
        	$Content->content = $content;
        	$Content->save();
        	echo ("<script>alert('发布成功！');location.href='/index/personal'</script>");
        }else{
            return $res;
        }
    }
}
