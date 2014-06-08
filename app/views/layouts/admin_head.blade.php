<!-- 头标题 -->
<div class="navbar navbar-inverse navbar-fixed-top web-navbar-top">
	<div class="navbar-header">
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#web-navbar-collapse">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
		<a href="/" class="navbar-brand">透视宝</a>
	</div>
	<div id="web-navbar-collapse" class="collapse navbar-collapse">
		<ul class="nav navbar-nav navbar-right">
			<li>
				<a href="" class="navbar-userpic">
					<img src="/resource/img/userpic.jpg" alt="" />
					<span class="navbar-username">{{ $info->admin_name }}</span>
				</a>
			</li>
			<li>
				<a href="/login_out" onclick="Javascript:return confirm('确实要退出系统吗？')">退出</a>
			</li>
		</ul>
	</div>
</div>
<!-- 头标题 -->


