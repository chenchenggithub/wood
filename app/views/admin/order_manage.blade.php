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

<div class="main">
    <div class="main-title">用户订单</div>
    <div class="main-body">
        <div class="container-fluid">
            <div class="row-fluid">
                <div class="panel">
                    <div class="panel-heading">
                        <h2 class="panel-title">操作：</h2>
                        <div id="promo_strategy_id">
                            <span class="fa fa-info-circle"><a id="strategy_list_id" onclick="admin_order_manage.load_order_list(this)" href="javascript:void(0);" class="btn btn-primary">订单列表</a></span>
                            <span class="fa fa-arrows"><a id="promo_code_list_id" onclick="" href="javascript:void(0);">订单详情</a></span>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div id="placeholder" style="width:100%;height:600px;">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <td>订单号</td>
                                    <td>用户邮箱</td>
                                    <td>联系电话</td>
                                    <td>订单类型</td>
                                    <td>订单状态</td>
                                    <td>订单金额</td>
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
<script>
    $(function(){
        T.ajaxLoad('/order_manage/ajax/load_order_list', 'placeholder', {}, function () {});
    });
</script>
<script src="/resource/js/admin/admin_order_manage.js"></script>
@stop

@section('app_js')
<script src="/resource/js/admin/admin_order_manage.js"></script>
<script>
     T.ajaxLoad('/order_manage/ajax/load_order_list', 'placeholder', {}, function () {});
</script>
@stop