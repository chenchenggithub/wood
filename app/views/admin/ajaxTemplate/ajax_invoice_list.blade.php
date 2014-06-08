@extends('layouts.ajax_master')
@section('content')
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
    @foreach($invoice_list as $list)
    <tr>
        <td>{{$list->user_id}}</td>
        <td>{{$list->user_email}}</td>
        <td>{{$list->status_msg}}</td>
        <td>{{$list->audit_time}}</td>
        <td>{{$list->invoice_time}}</td>
        <td>{{$list->mail_time}}</td>
        <td>{{$list->invoice_amount}}</td>
        <td>{{$list->apply_time}}</td>
        <td>
            @foreach($list->order_num_arr as $num)
              <a href="">#{{$num}}&nbsp;</a>
            @endforeach
        </td>
        <td>
            @if($list->status == InvoiceEnum::INVOICE_PROCESSING)
            <a href="javascript:admin_invoice_manage.load_invoice_audit({{$list->invoice_apply_id}});">处理</a>
            @elseif($list->status == InvoiceEnum::INVOICE_CHECK_FAIL)
            <a href="javascript:void(0);">处理</a>
            @elseif($list->status == InvoiceEnum::INVOICE_CHECK_SUCCESS)
            <a href="javascript:admin_invoice_manage.load_invoice_invoicing({{$list->invoice_apply_id}});">处理</a>
            @elseif($list->status == InvoiceEnum::INVOICE_WAIT_MAIL)
            <a href="javascript:admin_invoice_manage.load_invoice_mail({{$list->invoice_apply_id}});">处理</a>
            @elseif($list->status == InvoiceEnum::INVOICE_MAILED)
            <a href="javascript:void(0);">处理</a>
            @endif
        </td>
    </tr>
    @endforeach
</table>
<?php echo $invoice_list->links('pagination::ajax_simple'); ?>
@stop