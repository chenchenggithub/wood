@extends('layouts.master')

@section('title')
	用户管理
@stop

@section('app_css')
<link rel="stylesheet" href="/resource/css/admin/user_manage.css">
@stop

@section('content')
<div class="main">
	<div class="main-title">系统管理  > 账户信息 > 用户管理</div>
	<div class="main-body">
		@include('layouts.tsb_left_leaf')
		<div class="main-container">
			<div class="main-container-body">
				<div id="__load_groups"></div>
			 	<div id="__load_group_users"></div>
			</div>
		</div>
	</div>
</div>
@stop
<!-- 头标题 -->

@section('app_js')
<script src="/resource/js/user/group.js"></script>
<script>
	$(function(){
		group.loadGroups();
	});
</script>
@stop