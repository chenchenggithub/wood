@extends('layouts.admin_master')
@section('title')
<title>管理中心--透视宝</title>
@stop

@section('head')
@include('layouts.admin_head')
@stop

@section('leftMenu')
@include('layouts.admin_left')
@stop
<!--内容开始-->
@section('content')
<!-- 左导航开始 -->

<!-- 左导航结束 -->

<!-- 主体内容开始 -->
<div class="main">
    <div class="main-title">优惠码</div>
    <div class="main-body">
        <div class="container-fluid">
            <div class="row-fluid">
                <div class="panel">
                    <div class="panel-heading">
                        <h2 class="panel-title">操作：</h2>
                        <div id="promo_strategy_id">
                            <span class="fa fa-info-circle"><a id="strategy_list_id" onclick="admin_promo.load_pormo_strategy(this)" href="javascript:void(0);" class="btn btn-primary">优惠策略列表</a></span>
                            <span class="fa fa-arrows"><a id="promo_code_list_id" onclick="admin_promo.load_promo_list(this)" href="javascript:void(0);">优惠码列表</a></span>
                            <span class="fa fa-chevron-down"><a id="create_strategy_id" onclick="admin_promo.load_create_strategy(this)" href="javascript:void(0);" >创建优惠策略</a></span>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div id="placeholder" style="width:100%;height:600px;">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <td>公司名称</td>
                                    <td>申请时间</td>
                                    <td>网站链接</td>
                                    <td>所在行业</td>
                                    <td>联系人</td>
                                    <td>手机</td>
                                    <td>操作</td>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@stop

@section('app_js')
<script src="/resource/js/admin/admin_promo.js"></script>
<script>
    T.ajaxLoad('/ajax/load_promo_strategy','placeholder',{},function(){});
</script>
@stop
