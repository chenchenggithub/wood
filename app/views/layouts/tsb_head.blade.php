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
			<li><a href="#"><i class="fa fa-plus"></i>新建</a></li>
			<li>
				<a href="#myCenter" class="navbar-userpic" onclick="ucenter.loadUcenter();return false;">
				    @if(isset(UserService::getUserCache()->head_portrait) && !UserService::getUserCache()->head_portrait)
					<img src="{{UserService::getUserCache()->head_portrait}}" alt="" />
					@else
					<img src="/resource/img/admin/user_head.png" alt="" />
					@endif
					<span class="navbar-username">{{ UserService::getUserCache()->user_name }}</span>
				</a>
			</li>
			<li>
				<a href="/signin_out" onclick="Javascript:return confirm('确实要退出系统吗？')">退出</a>
			</li>
		</ul>
	</div>
</div>

<!-- 用户中心 -->
<div id="myCenter" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="background-color:#f0f0f0; padding-top:0;"></div>

