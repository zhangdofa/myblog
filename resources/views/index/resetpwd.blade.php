<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title></title>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/register.css') }}">
</head>
<body>
    <center>
        <form action="resetpwd" method="post">
        <div class="div">
            <h3>
                找回密码
            </h3>
			@csrf
			<div>
            <input type="text" name="name" placeholder="请输入您的用户名：" value="{{ $name }}" readonly></div>
			<div><input type="password" name="pwd" placeholder="请输入新密码：" value=""></div>
            <div><input type="password" name="pwd_confirmation" placeholder="请再次输入新密码：" value=""></div>
            <div>{{ $errors->first('pwd') }}</div>
            <input type="hidden" calss="token" name='token' value="{{ $token }}">
            @if (session('msg'))
            <div>{{ session('msg') }}</div>
            @endif
			<input type="submit" value="确认">
        </div>
		</form>
    </center>
</body>
</html>
