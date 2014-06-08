@extends('layouts.ajax_master')
@section('content')
<table>
     <input type="hidden" id="invoice_apply_id" value="{{$invoice_audit_info->invoice_apply_id}}">
    <tr style="height: 45px;">
        <td align="right">订单号:</td>
        <td style="padding-left:20px;">
            @foreach($invoice_audit_info->order_num_arr as $num)
                #{{$num}}&nbsp;
            @endforeach
        </td>
    </tr>
    <tr style="height: 45px;">
        <td align="right">申请时间:</td>
        <td style="padding-left:20px;">{{$invoice_audit_info->apply_time}}</td>
    </tr>
    <tr style="height: 45px;">
        <td align="right">开票金额(￥):</td>
        <td style="padding-left:20px;"><input id="invoice_amount_id" type="text" name="invoice_amount" value="{{$invoice_audit_info->invoice_amount}}" style="width:300px;" /></td>
    </tr>
    <tr style="height: 45px;">
        <td align="right">发票单号:</td>
        <td style="padding-left:20px;">{{$invoice_audit_info->invoice_code}}</td>
    </tr>
    <tr style="height: 45px;">
        <td align="right">发票抬头:</td>
        <td style="padding-left:20px;">{{$invoice_audit_info->invoice_header}}</td>
    </tr>
    <tr style="height: 45px;">
        <td align="right">联系人:</td>
        <td style="padding-left:20px;">{{$invoice_audit_info->contact}}</td>
    </tr>
    <tr style="height: 45px;">
        <td align="right">联系电话:</td>
        <td style="padding-left:20px;">{{$invoice_audit_info->telephone}}</td>
    </tr>
    <tr style="height: 45px;">
        <td align="right">邮寄地址:</td>
        <td style="padding-left:20px;">{{$invoice_audit_info->address}}</td>
    </tr>
    <tr style="height: 45px;">
        <td align="right">申请人备注:</td>
        <td style="padding-left:20px;">{{$invoice_audit_info->remark}}</td>
    </tr>
    <tr style="height: 45px;">
        <td align="right">系统备注:</td>
        <td style="padding-left:20px;"><textarea id="audit_remark_id" style="width:300px;height: 60px;"></textarea></td>
    </tr>
</table>
<br />
<button onclick="admin_invoice_manage.dispose_invoice_audit({{InvoiceEnum::INVOICE_CHECK_SUCCESS}})">审核成功</button>&nbsp;&nbsp;&nbsp;
<button onclick="admin_invoice_manage.dispose_invoice_audit({{InvoiceEnum::INVOICE_CHECK_FAIL}})">审核失败</button>
@stop