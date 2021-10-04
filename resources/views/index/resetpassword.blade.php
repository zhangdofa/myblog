<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title></title>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/register.css') }}">
</head>
<body>
    <center>
        <form action="resetpassword" method="post">
        <div class="div">
            <h3>
                找回密码
            </h3>
			@csrf
			<div><input type="text" name="username" placeholder="请输入您的用户名：" value="{{old('username')}}"></div>
			<div><input type="text" name="email" placeholder="请输入您的邮箱：" value="{{old('email')}}"></div>
            @if (session('msg'))
            <div>{{ session('msg') }}</div>
            @endif
			<input type="submit" value="发送邮件">
        </div>
		</form>
    </center>
</body>
</html>
