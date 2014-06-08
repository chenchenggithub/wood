<!DOCTYPE html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>透视宝</title>
	
	<link rel="stylesheet" href="/resource/css/lib/bootstrap.min.css">
	<link rel="stylesheet" href="/resource/css/lib/font-awesome.min.css">
	<link rel="stylesheet" href="/resource/css/lib/main.css">
	<link rel="stylesheet" href="/resource/css/admin/login.css">
</head>
<body>
	
	<div class="login_bg"><img src="/resource/img/admin/bg-login.png" alt="" /></div>
	{{ Form::open(array('url'=>'/signin'))}}
	<div class="login_form">
		<h2 class="form-signin-heading"><img src="/resource/img/admin/logo-login.png" alt="" /></h2>
		<div class="login-input">
			<div class="input-group">
				<span class="input-group-addon"><i class="fa fa-envelope"></i></span>
				<input type="email" name="user_email" class="form-control" placeholder="邮箱/手机号">
			</div>
			<div class="input-group">
				<span class="input-group-addon"><i class="pass_icon"></i></span>
				<input type="password" name="user_pass" class="form-control" placeholder="密码">
			</div>
		</div>
		<div class="login-handle">
			<label class="checkbox left">
			  <input type="checkbox" name="remember" value="1"> 保持登录
			</label>
			<div class="right">
				<a href="#">忘记密码</a>&nbsp;|&nbsp;<a href="/apply">申请试用</a>
			</div>
		</div>
		<button class="btn btn-lg btn-blue btn-block" type="submit">登&nbsp;&nbsp;录</button>
	</div>
	{{ Form::close() }}
</body>
</html>
