@extends('layouts.admin_master')
@section('title')
<title>管理中心--透视宝</title>
@stop
@section('head')
	@include('layouts.admin_head')
@stop


<!--内容开始-->
@section('content')
<!-- 左导航开始 -->
	@include('layouts.admin_left')
<!-- 左导航结束 -->

<!-- 主体内容开始 -->
<div class="main">
	<div class="main-title">管理员信息</div>
</div>
<!-- 主体内容结束 -->
@stop
<!--内容结束-->

