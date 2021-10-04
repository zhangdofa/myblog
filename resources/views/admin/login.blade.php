<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login</title>
   <link rel="stylesheet" href="{{ asset('css/login.css') }}"/>
</head>
<body>
    <center>
		<form action="{{ route('admin.login')}}" method ="POST">
        <div class="div">
            <h3>
                后台管理系统
            </h3>
					 @csrf
					<input type="text" name="name" placeholder="用户名：" value="{{old('name')}}">
					<div>{{ $errors->first('name') }}</div>
					<input type="password" name="password" placeholder="密码：" value="{{old('password')}}">
					<div>{{ $errors->first('password') }}</div>
					<div>{{ session('msg') }}</div>
					<input type="submit" value="登录">
					<br>
					<br>
					<a href="resetpassword" class="noaccount">忘记密码！</a>
        </div>
		</form>
    </center>
</form>
</body>
</html>