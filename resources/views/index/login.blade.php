<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login</title>
   <link rel="stylesheet" href="{{ asset('css/login.css') }}"/>
</head>
<body>
    <center>
		<form action="login" method ="POST">
        <div class="div">
            <h3>
                张东发博客
            </h3>
					 @csrf
					<input type="text" name="username" placeholder="用户名：" value="{{old('username')}}">
					<div>{{ $errors->first('username') }}</div>
					<input type="password" name="password" placeholder="密码：" value="{{old('password')}}">
					<div>{{ $errors->first('password') }}</div>
					<div>{{ session('msg') }}</div>
					<input type="submit" value="登录">
					<br>
					<br>
					<a href="register" class="forgetpwd">没有账号，请注册</a>
					<a href="resetpassword" class="noaccount">忘记密码！</a>
        </div>
		</form>
    </center>
</body>
</html>
