<div class="modal-header">
	<h4 id="myModalLabel" style="text-align:center;"><strong>用户中心</strong></h4>
</div>
<div class="modal-body">
	<div style="width:250px; height:100%; background-color:#e0e0e0; float:left;">
		<ul class="nav main-nav">
			<li>
				<a href="">个人设置</a>
				<ul class="nav">
					<li class="active">
						<a href="#" onclick="ucenter.loadUcenter();">个人资料</a>
					</li>
					<li>
						<a href="#">偏好选项</a>
					</li>
				</ul>
			</li>
			<li>
				<a href="">通知设置</a>
				<ul class="nav">
					<li>
						<a href="#">手机短信</a>
					</li>
					<li>
						<a href="#">Email</a>
					</li>
					<li>
						<a href="#">微信</a>
					</li>
				</li>
			</li>
		</ul>
	</div>
	<div style="padding:15px; float:left; width:1000px; min-width:750px;">
		<div style="padding: 0;min-height:100%;" id="__ucenter_layout">
			<div style="border-bottom:2px solid #BCBCC5;">
				<div style="font-size:16px; font-weight:bold; padding-bottom:20px;">基本设置</div>
				{{Form::open(array('url'=>'/user/modify_info','class'=>'form-horizontal','role'=>'form'))}}
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label">登录邮箱：</label>
						<div class="col-sm-6">
							<p class="form-control-static">{{$userInfo->user_email}}</p>
						</div>
						<div class="col-sm-2">
							<input type="button" class="btn" onClick="ucenter.loadModifyEmail();" value="修改邮箱" />
						</div>
					</div>
					<div class="form-group">
						<label for="inputPassword3" class="col-sm-2 control-label">手机号码：</label>
						<div class="col-sm-6">
						  	<input type="text" class="form-control" name="user_mobile" id="inputMobile" placeholder="手机号码" value="{{$userInfo->user_mobile}}" @if($userInfo->mobile_auth == UserEnum::USER_MOBILE_AUTH_YES)disabled="disabled"@endif />
						</div>
						@if($userInfo->mobile_auth == UserEnum::USER_MOBILE_AUTH_NO)
						<div class="col-sm-2">
							<input type="button" class="btn" value="认证手机" />
						</div>
						@else
						<div class="col-sm-2">
							<input type="button" class="btn btn-success" value="解除认证" />
						</div>
						@endif
					</div>
					<div class="form-group">
						<label for="inputPassword3" class="col-sm-2 control-label">姓名：</label>
						<div class="col-sm-6">
						  	<input type="text" class="form-control" name="user_name" id="inputUsername" placeholder="姓名" value="{{$userInfo->user_name}}" />
						</div>
					</div>
					<div class="form-group">
						<label for="inputPassword3" class="col-sm-2 control-label">QQ：</label>
						<div class="col-sm-6">
						  	<input type="text" class="form-control" name="user_qq" id="inputQQ" placeholder="QQ号码" value="@if($userInfo->user_qq){{$userInfo->user_qq}}@endif" />
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
						  	<button type="submit" class="btn btn-primary">保 存</button>
						</div>
					</div>
				{{Form::close()}}
			</div>
			
			<div style="padding-top:30px;">
				<div style="font-size:16px; font-weight:bold; padding-bottom:20px;">修改密码</div>
				{{Form::open(array('url'=>'/user/modify_pass','class'=>'form-horizontal','role'=>'form'))}}
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label">原密码：</label>
						<div class="col-sm-6">
							<input type="password" class="form-control" name="now_pass" id="inputNowPass" placeholder="原密码">
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label">新密码：</label>
						<div class="col-sm-6">
							<input type="password" class="form-control" name="user_pass" id="inputUserPass" placeholder="新密码">
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label">新密码：</label>
						<div class="col-sm-6">
							<input type="password" class="form-control" name="user_pass_repeat" id="inputUserPassRepeat" placeholder="重复密码">
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
						  	<button type="submit" class="btn btn-primary">确认修改</button>
						</div>
					</div>
				{{Form::close()}}
			</div>
			
		</div>
	</div>
			
</div>
<div class="modal-footer">
	<div style=" height:30px; background-color:#404452; text-align:center">
		<a href="#" data-dismiss="modal" aria-hidden="true" style="color:#FFFFFF; font-size:24px; font-weight:bolder;">
			^	
		</a>
	</div>
</div>
	
