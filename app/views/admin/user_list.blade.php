@extends('layouts.admin_master')
@section('title')
<title>用户审核--透视宝</title>
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
	<div class="main-title">用户审核</div>
	<div class="main-body">
		<div class="container-fluid">
			<div class="row-fluid">
				<div class="panel">
					<div class="panel-heading">
						<h2 class="panel-title">状态：</h2>
						<div id="__register_status_div">
							<span class="fa fa-arrows">
								<a register_status="0">全部</a>
							</span>
							<span class="fa fa-info-circle">
								<a register_status={{ UserEnum::REGISTER_STATUS_NORMAL }}>等待审核</a>
							</span>
							<span class="fa fa-chevron-down">
								<a register_status={{ UserEnum::REGISTER_STATUS_PASS }}>审核通过</a>
							</span>
							<span class="fa fa-times">
								<a register_status={{ UserEnum::REGISTER_STATUS_FAIL }}>审核失败</a>
							</span>
						</div>
					</div>
					<div class="panel-body">
						<div id="placeholder">
						
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- 主体内容结束 -->

@stop
<!--内容结束-->
@section('app_js')
<script type="text/javascript" src="/resource/js/admin/register.js?v={{ ResourceSpall::getResourceVersion() }}"></script>
<script>
	$(function(){
		register.load_register_user();
		$('#__register_status_div a:eq(1)').click();
	});
	function passRegister(id)
	{
		register.dispose_register('pass',id);
	}
	function failRegister(id)
	{
		register.dispose_register('fail',id);
	}
</script>
@stop