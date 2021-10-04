@extends('layouts.home')
@section('content')
    <div class="right">
        <div class="content">
            <div class="substance1">
                @foreach ($data as $user)
                <div class="describe1">
                    <h3 class="title1" style="text-align: center;">{{ $user->title }}</h3>
                    <div class="userinfo">
                        <ul>
                            <img src="{{ asset('img/user.png')}}" width="15px" height="15px"><li class="">{{ $user->user->name }}</li>
                            <img src="{{ asset('img/date.png')}}" width="15px" height="15px"><li class=""> {{ $user->created_time }}</li>
                        </ul>
                    </div>
                    <div class="title4">{!! $user->content !!}</div>
                    <div class="user_id" style="display: none;">{{ $user->id}}</div>

                </div>
                @endforeach
            </div>
        </div>
        <div class="comment_filed">
          <!--发表评论区begin-->
          <div>
            <div class="comment_num">
                @foreach ($posts as $post)
                @if($post->zan(Auth::id())->exists())
                    <button class="btn  btn-default unzan" postid="{{ $post->id }}" onclick="unzan()">取消赞</button>
                @else
                    <button class="btn  btn-primary zan" onclick="Like()" postid="{{ $post->id }}">赞</button>
                @endif
                <span>{{ $post->zans_count }}</span>   
                <span> | 评论 {{ $post->comments_count }}</span>
                @endforeach
            </div>
            <div>
                <div>
                    @csrf
                <textarea class="txt_commit" replyid="0"></textarea>
                </div>
                <div class="div_txt_submit">
                    <a class="comment_submit" parent_id="0" style="" href="javascript:void(0);"><span style=''>发表评论</span></a>
                </div>      
            </div>
          </div>
        </div>
        <div class="comment_list">
        @foreach($list as $list)
        <!--一级评论列表begin-->
        <ul class="comment-ul">     
                <li comment_id="{{ $list->id }}">                   
                    <div>
                        <div class="pic">
                            <img class="head-pic"  src="{{ asset($list->user->avatars)}}" alt="">  
                        </div>
                        <div class="cm">
                            <div class="cm-header">
                                    <span>{{ $list->user->name }}</span>
                                    <span>{{ $list->created_at }}</span>
                                    </div>
                            <div class="cm-content">
                                        <p>
                                            {{ $list->content }}
                                        </p>
                            </div>
                            <div class="cm-footer">
                                <a class="comment-reply" comment_id="{{ $list->id }}" href="javascript:void(0);">回复</a>                     
                            </div>  
                        </div>                                                              
                    </div>
                    <!--二级评论begin-->
                    <ul class="children">
                    @isset($list->children)
                    @foreach($list->children as $children)
                        <li comment_id="{{ $children->id }}">                  
                            <div>
                                <div class="pic">
                                    <img class="head-pic"  src="{{ asset($children->user->avatars)}}" alt="">  
                                </div>
                                <div class="cm">
                                    <div class="cm-header">
                                            <span>{{ $children->user->name }}</span>
                                            <span>{{ $children->created_at }}</span>
                                            </div>
                                    <div class="cm-content">
                                                <p>
                                                   {{ $children->content }} 
                                                </p>
                                    </div>
                                    <div class="cm-footer">
                                        <a class="comment-reply" replyswitch="off" comment_id="{{ $children->id }}" href="javascript:void(0);">回复</a>                     
                                    </div>  
                                </div>                                                              
                            </div>
                            <!--三级评论begin-->
                            <ul class="children">
                            @isset($children->children)
                            @foreach($children->children as $grandson)
                                <li comment_id="{{ $grandson->id }}">    
                                    <div>
                                        <div class="pic">
                                            <img class="head-pic"  src="{{ asset($grandson->user->avatars)}}" alt="">  
                                        </div>
                                        <div class="cm">
                                            <div class="cm-header">
                                                    <span>{{ $grandson->user->name }}</span>
                                                    <span>{{ $grandson->created_at }}</span>
                                                    </div>
                                            <div class="cm-content">
                                                        <p>
                                                           {{ $grandson->content }} 
                                                        </p>
                                            </div>
                                            <div class="cm-footer">
                                            </div>  
                                        </div>                                                              
                                    </div>  
                                </li>
                            @endforeach
                            @endisset
                            </ul>   
                            <!--三级评论end-->
 
                        </li>
                    @endforeach
                    @endisset
                    </ul>   
                    <!--二级评论end-->
 
                </li>
            </ul>
            <!--一级评论列表end-->             
        @endforeach
        </div>
<script type="text/javascript">
    //点击赞时判断是否登录
    $(document).ready(function(){
        if($(window).width()<= 767){
            $('.zan').attr('disabled',true);
            $('.txt_commit').attr('disabled',true);
            $('.comment-reply').css('display','none');
            return false;
        }
    })
    function Like() {
        // body...
        var name = $('#a').html();
        if (name) {
            // return true;
            var id = $('.zan').attr('postid');
            console.log(id);
            $.ajax({
                type: 'get',
                url: '/index/detail/'+id+'/zan',
                success:function(data) {
                    // body...
                    location.reload();
                },
                error:function(e) {
                    // body...
                    // console.log(e);
                    alert('发生错误，请重试！');
                }
            })
            return false;
        }
        alert('您当前未登录！登录之后才能点赞哦！');
        //return false;
        window.location.href = "login";
    }

    //取消赞
    function unzan() {
        // body...
        var id = $('.unzan').attr('postid');
        $.ajax({
            type:'get',
            url: '/index/detail/'+id+'/unzan',
            success:function(data) {
                // body...
                location.reload();
            },
            error:function(e) {
                // body...
                // console.log(e);
                alert('发生错误，请重试！');
            }
        })
    }


    //window.onbeforeunload = function () {
    //    var scrollPos;
    //    if (typeof window.pageYOffset != 'undefined') {
    //    	scrollPos = window.pageYOffset;
    //    }
    //    else if (typeof document.compatMode != 'undefined' &&
    //    			document.compatMode != 'BackCompat') {
    //    	scrollPos = document.documentElement.scrollTop;
    //    }
    //    else if (typeof document.body != 'undefined') {
    //    	scrollPos = document.body.scrollTop;
    //    }
    //    document.cookie = "scrollTop=" + scrollPos; //存储滚动条位置到cookies中
    //    		 
    //}
    //window.onload = function () {
    //    if (document.cookie.match(/scrollTop=([^;]+)(;|$)/) != null) {
    //    	var arr = document.cookie.match(/scrollTop=([^;]+)(;|$)/); //cookies中不为空，则读取滚动条位置
    //    	document.documentElement.scrollTop = parseInt(arr[1]);
    //    	document.body.scrollTop = parseInt(arr[1]);
    //    							                        }
    //}
    function executeScript(html)
    {
        var reg = /<script[^>]*>([^\x00]+)$/i;
        //对整段HTML片段按<\/script>拆分
        var htmlBlock = html.split("<\/script>");
        for (var i in htmlBlock) 
            {
                var blocks;//匹配正则表达式的内容数组，blocks[1]就是真正的一段脚本内容，因为前面reg定义我们用了括号进行了捕获分组
                  if (blocks = htmlBlock[i].match(reg)) 
                    {
                        //清除可能存在的注释标记，对于注释结尾-->可以忽略处理，eval一样能正常工作
                          var code = blocks[1].replace(/<!--/, '');
                            try 
                            {
                                  eval(code) //执行脚本
                            } 
                            catch (e) 
                            {
                            }

                    }
            }
    }

    //点击"回复"按钮显示或隐藏回复输入框
    $("body").delegate(".comment-reply","click",function(){
        if($(this).next().length>0){//判断出回复div已经存在,去除掉
            $(this).next().remove();
         }else{//添加回复div
            $(".comment-reply").next().remove();//删除已存在的所有回复div    
            //添加当前回复div
            var parent_id = $(this).attr("comment_id");//要回复的评论id
 
            var divhtml = "";
            var s = $(this).attr("replyswitch")
            if('off'==$(this).attr("replyswitch")){//二级评论回复后三级评论不再提供回复功能,将关闭属性附加到"提交回复"按钮"
                divhtml = "<div class='div-reply-txt' style='width:98%;padding:3px;' replyid='2'><div><textarea class='txt-reply' replyid='2' style='width: 100%; height: 60px;'></textarea></div><div style='margin-top:5px;text-align:right;'><a class='comment_submit'  parent_id='"+parent_id+"' style='font-size:14px;text-decoration:none;background-color:#63B8FF;' href='javascript:void(0);' replyswitch='off' >提交回复</a></div></div>";
            }else{
                divhtml = "<div class='div-reply-txt' style='width:98%;padding:3px;' replyid='2'><div><textarea class='txt-reply' replyid='2' style='width: 100%; height: 60px;'></textarea></div><div style='margin-top:5px;text-align:right;'><a class='comment_submit'  parent_id='"+parent_id+"' style='font-size:14px;text-decoration:none;background-color:#63B8FF;' href='javascript:void(0);'>提交回复</a></div></div>";
            }           
            $(this).after(divhtml);
         }
    });
    $("body").delegate(".comment_submit","click",function() {
    // $('.comment_submit').click(function() {
        // body...
        if($(window).width()<= 767){
            $('.comment_submit').attr('disabled',true);
            alert('手机端不允许评论！如需评论请用pc端评论!');
            return false;
        }
        var content_id = $('.user_id').html();//获取完内容后清空输入框
        var content = $.trim($(this).parent().prev().children("textarea").val());//根据布局结构获取当前评论内容
        $(this).parent().prev().children("textarea").val("");//获取完内容后清空输入框
        var name = $('#a').html();
        if (name) {
            if (content == '') {
            alert('评论内容不能为空！');
        }else{
            var cmdata = new Object();
            cmdata.parent_id = $(this).attr('parent_id');//上级评论ID
            cmdata.comment = content;
            cmdata.name = '游客';
            cmdata.content_id = content_id;
            var replyswitch = $(this).attr("replyswitch");//获取回复开关锁属性

            $.ajax({
                type:"post",
                url:"/index/addcomment",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data:{
                    comment:JSON.stringify(cmdata),
                },
                dataType:"json",
                success:function(data){
                    if (typeof(data.error)=='undefined') {
                         $(".comment-reply").next().remove();//删除已存在的所有回复div
                        // var res = @json($list);
                        // console.log(res['user']['name']);
                        var newli = ""; 
                        if (cmdata.parent_id == '0') {
                        var newdiv = "<ul class='children'><li comment_id='"+data.id+"'><div ><div class='pic'>@auth<img class='head-pic'  src='{{ asset(Auth::user()->avatars) }}' alt=''>@endauth</div><div class='cm'><div  class='cm-header'><span>"+name+" </span><span>"+data.created_at+"</span></div><div class='cm-content'><p>"+data.content+"</p></div><div class='cm-footer'><a class='comment-reply' comment_id='"+data.id+"'  href='javascript:void(0);'>回复</a></div></div></div><ul class='children'></ul></li></ul>";
                        $(".comment_list").prepend(newdiv);
                                
                        }else{
                                                     //否则添加到对应的孩子ul列表中                           
                            if('off'==replyswitch){//检验出回复关闭锁存在，即三级评论不再提供回复功能                           
                                newli = "<li comment_id='"+data.id+"'><div ><div class='pic'>@auth<img class='head-pic'  src='{{ asset(Auth::user()->avatars) }}' alt=''>@endauth</div><div class='cm'><div  class='cm-header'><span>"+name+" </span><span>"+data.created_at+"</span></div><div class='cm-content'><p>"+data.content+"</p></div><div class='cm-footer'></div></div></div><ul class='children'></ul></li>";
                            }else{//二级评论的回复按钮要添加回复关闭锁属性                     
                                newli = "<li comment_id='"+data.id+"'><div ><div class='pic'>@auth<img class='head-pic'  src='{{ asset(Auth::user()->avatars) }}' alt=''>@endauth</div><div class='cm'><div  class='cm-header'><span>"+name+" </span><span>"+data.created_at+"</span></div><div class='cm-content'><p>"+data.content+"</p></div><div class='cm-footer'><a class='comment-reply' comment_id='"+data.id+"'  href='javascript:void(0);' replyswitch='off' >回复</a></div></div></div><ul class='children'></ul></li>";
                                console.log(newli);
                            }                           
                            $("li[comment_id='"+data.parent_id+"']").children('ul').prepend(newli);
                        }
                    }else{
                                //有错误信息
                                alert(data.error);
                    }
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    // 状态码
                    console.log(XMLHttpRequest.status);
                    // 状态
                    console.log(XMLHttpRequest.readyState);
                    // 错误信息   
                    console.log(textStatus);
                    console.log(XMLHttpRequest.responseText);
                    executeScript(XMLHttpRequest.responseText);
                }
            });
            }
        }else{
            alert('请先登录！');
            window.location.href = "login";
        }
        
    });
</script>
    </div>
@endsection
