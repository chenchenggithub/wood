<html>
<head>
<title>用户注册--透视宝</title>
</head>
<body>
	<div class="main" style="margin-right:90px;">
		<div class="main-body" style="margin-top:10px;">
			{{ Form::open(array('class'=>'form-horizontal','url'=>'/apply')) }}
				<p class="lead" style="padding-left:30px;">申请公司信息</p>
	  			<div class="control-group">
					<label class="control-label" for="company_name">公司名称:</label>
					<div class="controls">
						<input type="text" id="company_name" name="company_name" />
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="company_url">网站链接:</label>
					<div class="controls">
						<input type="text" id="company_url" name="company_url" />
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="company_industry">所在行业:</label>
					<div class="controls">
						<select name="company_industry" id="company_industry">
						  @foreach($industry as $key=>$name)
						  <option value="{{ $key }}">{{ $name }}</option>
						  @endforeach
						</select>
					</div>
				</div>
				<p class="lead" style="padding-left:30px;">联系人信息</p>
				<div class="control-group">
					<label class="control-label" for="user_name">姓名:</label>
					<div class="controls">
						<input type="text" id="user_name" name="user_name" />
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="user_email">邮箱地址:</label>
					<div class="controls">
						<input type="text" id="user_email" name="user_email" />
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="user_mobile">手机号码:</label>
					<div class="controls">
						<input type="text" id="user_mobile" name="user_mobile" />
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<input type="submit" value="提交申请试用" class="btn btn-primary"/>
					</div>
				</div>
	        {{ Form::close() }}
		</div>
	</div>
</body>
</html>