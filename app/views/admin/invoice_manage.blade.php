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
    <div class="main-title">发票管理</div>
    <div class="main-body">
        <div class="container-fluid">
            <div class="row-fluid">
                <div class="panel">
                    <div class="panel-heading">

                        <div id="promo_strategy_id">

                            <span class="fa fa-arrows">发票状态：</span>
                            <select id="invoice_status_id" onchange="admin_invoice_manage.load_invoice_list()">
                                <option value="{{InvoiceEnum::INVOICE_PROCESSING}})">等待审核</option>
                                <option value="{{InvoiceEnum::INVOICE_CHECK_SUCCESS}}">审核成功</option>
                                <option value="{{InvoiceEnum::INVOICE_CHECK_FAIL}}">审核失败</option>
                                <option value="{{InvoiceEnum::INVOICE_WAIT_MAIL}}">等待邮寄</option>
                                <option value="{{InvoiceEnum::INVOICE_MAILED}}">已经邮寄</option>
                                <option value="0">全部</option>
                            </select>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div id="placeholder" style="width:100%;height:600px;">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <td>用户ID</td>
                                    <td>客户E-mail</td>
                                    <td>发票状态</td>
                                    <td>审核时间</td>
                                    <td>开票时间</td>
                                    <td>邮寄时间</td>
                                    <td>申请金额</td>
                                    <td>申请时间</td>
                                    <td>申请订单号</td>
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
<script src="/resource/js/admin/admin_invoice_manage.js"></script>
<script>
    admin_invoice_manage.load_invoice_list();
</script>
@stop