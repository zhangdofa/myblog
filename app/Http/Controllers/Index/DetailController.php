<?php

namespace App\Http\Controllers\index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Contents;
use App\Model\Comments;
use App\Model\Zan;
use Illuminate\Support\Facades\Auth;

class DetailController extends Controller
{
    //
    public function detail(Request $request)
    {
    	# code...
    	$id = $request->get('id');
    	$result = Contents::where('id',$id)->get();
    	$list = $this->comment_list($id);
        $posts = Contents::where('id',$id)->withCount(['comments','zans'])->get();
        // foreach ($posts as $post) {
        //     var_dump($post->zans_count);
        // }
    	return view('index.detail',['data' => $result,'list' => $list,'posts' => $posts]);
    }

    protected function comment_list($content_id,$parent_id=0,&$result = array())
    {
    	# code...
    	$arr = Comments::where(['parent_id' => $parent_id,'contents_id' => $content_id])->orderBy('created_at', 'desc')->get();
    	if (empty($arr)) {
    		# code...
    		return array();
    	}
    	foreach ($arr as $cm) {
    		# code...
    		$thisArr = &$result[];
    		$cm['children'] = $this->comment_list($content_id,$cm['id'],$thisArr);
    		$thisArr = $cm;
    	}
    	return $result;
    }

    public function addcomment(Request $request)
    {
    	# code...
    	$res = $_POST["comment"];
    	if((isset($_POST["comment"]))&&(!empty($_POST["comment"]))) {
    		# code...
    		$res = json_decode($res,TRUE);
    		// dd($res);
    		$comment = new Comments;
    		$comment->parent_id = $res['parent_id'];
    		$comment->user_id = Auth::user()->id;
    		$comment->contents_id = $res['content_id'];
    		$comment->content = $res['comment'];
    		$comment->save();
    		return json_encode($comment);
    	}
    }

    //生成赞
    public function zan(Request $request)
    {
        # code...
        $content_id = $request->content_id;
        $params = [
            'user_id' => Auth::id(),
            'contents_id' => (int)$content_id,
        ];
        //接受参数 进行业务处理 如果没有就创建
        Zan::firstOrCreate($params);
        return back();
    }

    //取消赞
    public function unzan(Request $request){
        // var_dump($post->zan(Auth::id()));
        $content_id = $request->content_id;
        $res = Contents::find($content_id)->zan(Auth::id())->delete();
        return back();
    }
}
