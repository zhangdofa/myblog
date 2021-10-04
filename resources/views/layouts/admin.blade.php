<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- <title>{{ config('app.name', 'Laravel') }}</title> -->
    <title>后台管理</title>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://cdn.staticfile.org/jquery/1.10.2/jquery.min.js"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app1.css') }}" rel="stylesheet">
    <link href="{{ asset('css/home.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">

</head>
<body>
        <div class="head">
            <nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0">
                <a class="navbar-brand navbar navbar-dark col-sm-3 col-md-2 mr-0" href="#">后台管理系统</a>
                {{--<input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search">--}}
            </nav>
      
        </div>
        <div class="menu">
            <ul class="UL" style="">
                <li class="item">
                    <a href="{{ route('admin.index') }}">文章管理</a>
                </li>
                <li class="item">
                    <a href="{{ route('admin.user') }}">用户管理</a>
                </li>
                <li class="item">
                    <a href="{{ route('admin.admininfo') }}">管理员信息</a>
                </li>
                <li class="item">
                    <a href="{{ route('admin.loginout') }}">退出登录</a>
                </li>
            </ul>
        </div>
        <main class="py-4">
            @yield('content')
        </main>
</body>
</html>
