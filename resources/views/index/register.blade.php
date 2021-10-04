<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title></title>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/register.css') }}">
</head>
<body>
    <center>
        <form action="register" method="post">
        <div class="div">
            <h3>
                注册
            </h3>
			@csrf
			<div><input type="text" name="name" placeholder="请输入用户名：" value="{{old('name')}}"></div>
			<div>{{ $errors->first('name') }}</div>
			<div><input type="text" name="email" placeholder="请输入您的邮箱：" value="{{old('email')}}"></div>
			<div>{{ $errors->first('email') }}</div>
			<div><input type="password" name="pwd" placeholder="请输入您的密码：" value="{{old('pwd')}}"></div>
			<div>{{ $errors->first('pwd_again') }}</div>
			<div><input type="password" name="pwd_confirmation" placeholder="请再次输入您的密码：" value="{{old('pwd_again')}}"></div>
			<div>{{ $errors->first('pwd') }}</div>
			@if (session('status'))
			    <div class="alert alert-success">
			        {{ session('status') }}
			    </div>
			@endif
			<input type="submit" value="注册">
			<br>
			<br>
			<a href="login" class="login">已有账号，去登录</a>
        </div>
		</form>
    </center>
</body>
</html>
