<div>
	<ul class="nav nav-pills" id="__step_ul">
	  <li class="active">
		<a href="#">第一步</a>
	  </li>
	  <li>
	  	<a href="#">第二步</a>
	  </li>
	  <li>
	  	<a href="#">第三步</a>
	  </li>
	</ul>
</div>
<form class="form-horizontal" role="form" id="__form_step1">
<div class="form-group">
	<label for="inputNewEmail" class="col-sm-2 control-label">新的邮箱地址：</label>
	<div class="col-sm-6">
		<input type="text" class="form-control" name="new_email" id="inputNewEmail" />
	</div>
</div>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
		<button type="button" id="__sub_step1" class="btn btn-primary">下 一 步</button>
	</div>
</div>
</form>

<form class="form-horizontal" role="form" id="__form_step2" style="display:none;">
<div class="form-group">
	<label for="inputEmail3" class="col-sm-2 control-label">新的邮箱地址：</label>
	<div class="col-sm-6">
		<p class="form-control-static" id="__email_step2"></p>
	</div>
	<div class="col-sm-2">
		<input type="button" class="btn" id="__btn_send_code" value="获取验证码" />
	</div>
</div>
<div class="form-group" id="__send_result" style="display:none;">
	<label class="col-sm-2 control-label"></label>
	<div class="col-sm-8">
		<div class="alert"></div>
	</div>
</div>
<div class="form-group">
	<label for="inputEmailCode" class="col-sm-2 control-label">验证码：</label>
	<div class="col-sm-4">
		<input type="text" class="form-control" name="email_conde" id="inputEmailCode" />
	</div>
</div>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
		<button type="button" id="__sub_step2" class="btn btn-primary">下 一 步</button>
	</div>
</div>
</form>

<form class="form-horizontal" role="form" id="__form_step3" style="display:none;">
<div class="form-group">
	<div class="col-sm-6">
		<p class="form-control-static">邮箱修改成功！</p>
	</div>
</div>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
		<button type="button" id="__sub_step3" class="btn btn-primary">返回个人资料</button>
	</div>
</div>
</form>

