<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<p>亲爱的<strong> {{ $user_name }}</strong>，您好！</p>
		<p>您的试用透视宝申请已经成功通过审核了哦，</p>
		<p>账号初始密码为：{{ $password }}</p>
		<p>赶紧点击一下链接激活账号吧！</p>
		<p>
			<a href="http://toushibao.com/user_activate?token={{ $token }}">
				http://toushibao.com/user_activate?token={{ $token }}
			</a>
		</p>
	</body>
</html>
