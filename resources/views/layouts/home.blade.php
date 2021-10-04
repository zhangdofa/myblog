<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->

    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1, maximum-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>张东发博客</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script type="text/javascript" src="{{ asset('js/jquery-3.4.1.min.js')}}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('img/lovely.ico')}}" type="image/x-icon" />
    <!-- Styles -->
    <link href="{{ asset('css/app1.css') }}" rel="stylesheet">
    <link href="{{ asset('css/home.css') }}" rel="stylesheet">
</head>
<body>
        <div class="head">
            <div class="myblog">
                <a href="{{ url('/index/home') }}">Myblog</a>
            </div>
            @if (session('updatepwd'))
            <div id="msg" style="display: none;">{{ session('updatepwd') }}</div>
            @endif
            @auth
            <div class="wel">
                <div class="dropbtn">
                    <img src="{{ asset(Auth::user()->avatars) }}" class="avatars">
                    <a id="a" href="javascript:void(0)" onclick="showList(this)" onmouseover="showList()">{{Auth::user()->name}}</a>
                </div>

<!-- 
                <form id="logout-form" action="{{ route('index.loginout') }}" method="POST" style="display: none;">
                    @csrf
                </form> -->
            </div>
            <div class="dropdown-content" onmouseleave="showList()" id="dropdown-a">
                    <div><a href="{{ url('/index/loginout') }}">Loginout</a></div>
                    <div><a href="{{ url('/index/personal') }}">Article  center</a></div>
                    <div><a href="{{ url('/index/mycenter') }}">My center</a></div>
                </div>
            @endauth
            @guest
            <div class="wel1">
                <a class="login" href="{{ url('/index/login') }}">Login</a>
                <a class="register" href="{{ url('/index/register') }}">Register</a>
            </div>
	       @endguest
	    <div class="dropdown wel2" style="">
              <a href="javascript:void(0)" onclick="showList1(this)"><img src="{{ asset('img/menu.png') }}"></a>
              <div class="dropdown-content about" style="display: none;">
                <a href="#" href="javascript:void(0)" onclick="about(this)">联系站长</a>
                <a href="#">提示：<span style="color: red">手机版不支持发布内容，如有需要，请前往pc端打开本网站。</span></a>
              </div>
            </div>
        </div>

        <main class="py-4">
            <center>
    
<div class="body">
    <div class="left">
    <div class="info">
    <div class="portrait">
        <img src="{{ asset('img/touxiang.jpeg') }}">
    </div>
        <table id="table">
            <tr>
                <td>昵称：</td>
                <td>zhangdongfa</td>
            </tr>
            <tr>
                <td>性别：</td>
                <td>男</td>
            </tr>
            <tr>
                <td>年龄：</td>
                <td>21</td>
            </tr>
            <tr>
                <td>地区：</td>
                <td>厦门</td>
            </tr>
            <tr>
                <td>邮箱：</td>
                <td>2631193744@qq.com</td>
            </tr>
            <tr>
                <td>座右铭：</td>
                <td>愿你成为自己喜欢的模样，不抱怨，不将就，有自由，有光芒。</td>
            </tr>
            
            </table>
    </div>
    <div class="author">
        <div class="lef">站长联系方式：</div>
        <div class="righ">15779033833</div>
        <div class="lef">QQ：</div>
        <div class="righ">2631193744</div>
        <div class="lef">微信：</div>
        <div class="righ">18507077290</div>
        <div class="lef">赞助方式：</div>
        <div class="righ">支付宝，微信</div>
        <div class="pay">
            <img src="{{ asset('img/alipy.jpg') }}" class="alipy">
            <img src="{{ asset('img/weixin.png') }}" class="weixin">
        </div>
    </div>
      @auth
      <div id="publish">
            <div class="publish" onclick="window.location.href='/index/publish'">
                <img src="{{ asset('img/add.png') }}">
            </div>
            <div>快来发布您的文章吧！</div>
      </div>
      @endauth
    </div>
    @yield('content')
    
</div>
<script>
    $(function(){
    $(".substance .describe").click(function() {
        $(this).addClass('selected');  // 给被点击元素添加样式
        var index = $(this).find('.id').html();
        window.location.href='/index/detail?id='+index;
    })

    var msg = $('#msg').text();
    if (msg) {
        alert(msg);
    }
   // var width = window.screen.width;
   //     if (width <= 1366) {
   //         $('.right').css({"width":"43rem","margin-right":"10%"});
   //         $('.wel1').css({"right":"0%"})
   //         $('.wel').css({"right":"3.6%"})
   //         // alert(width);
   //     }
})
</script>
</center>
        </main>

        <div class="footer">©2020 zhangdongfa. All rights reserved.<a href="http://beian.miit.gov.cn" target="_blank"> 赣ICP备2020011038号-1.</a></div>
</body>
<script>
    function showList(o) {
        if($("#dropdown-a").is(":hidden")){
             $("#dropdown-a").show();    //如果元素为隐藏,则将它显现
        }else{
            $("#dropdown-a").hide();     //如果元素为显现,则将其隐藏
        }
    }
    function showList1(o) {
	if($(".about").is(":hidden")){
	     $(".about").show();    //如果元素为隐藏,则将它显现
	}else{
		$(".about").hide();     //如果元素为显现,则将其隐藏
    	}
    }

     function about(o) {
	  // body...
	  $(".about").hide();
	  $("#publish").hide();
          $('.right').css('display','none');
          $('.left').css({'display':'block','margin':'0 10% 0 10%'});
    }
</script>
</html>
