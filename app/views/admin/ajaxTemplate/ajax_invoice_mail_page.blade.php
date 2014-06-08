@extends('layouts.ajax_master')
@section('content')
<table>
    <input type="hidden" id="invoice_apply_id" value="{{$invoice_mail_info->invoice_apply_id}}">
    <tr style="height: 45px;">
        <td align="right">订单号:</td>
        <td style="padding-left:20px;">
            @foreach($invoice_mail_info->order_num_arr as $num)
            #{{$num}}&nbsp;
            @endforeach
        </td>
    </tr>
    <tr style="height: 45px;">
        <td align="right">申请时间:</td>
        <td style="padding-left:20px;">{{$invoice_mail_info->apply_time}}</td>
    </tr>
    <tr style="height: 45px;">
        <td align="right">开票金额(￥):</td>
        <td style="padding-left:20px;">{{$invoice_mail_info->invoice_amount}}</td>
    </tr>
    <tr style="height: 45px;">
        <td align="right">发票单号:</td>
        <td style="padding-left:20px;">{{$invoice_mail_info->invoice_code}}</td>
    </tr>
    <tr style="height: 45px;">
        <td align="right">发票抬头:</td>
        <td style="padding-left:20px;">{{$invoice_mail_info->invoice_header}}</td>
    </tr>
    <tr style="height: 45px;">
        <td align="right">联系人:</td>
        <td style="padding-left:20px;">{{$invoice_mail_info->contact}}</td>
    </tr>
    <tr style="height: 45px;">
        <td align="right">联系电话:</td>
        <td style="padding-left:20px;">{{$invoice_mail_info->telephone}}</td>
    </tr>
    <tr style="height: 45px;">
        <td align="right">邮寄地址:</td>
        <td style="padding-left:20px;">{{$invoice_mail_info->address}}</td>
    </tr>
    <tr style="height: 45px;">
        <td align="right">申请人备注:</td>
        <td style="padding-left:20px;">{{$invoice_mail_info->remark}}</td>
    </tr>
    <tr style="height: 45px;">
        <td align="right">系统备注:</td>
        <td style="padding-left:20px;"><textarea id="mail_remark_id" style="width:300px;height: 60px;"></textarea></td>
    </tr>
    <tr style="height: 45px;">
        <td align="right">快递公司:</td>
        <td style="padding-left:20px;"><input id="express_company_id" type="text" value="" style="width:300px;" /></td>
    </tr>
    <tr style="height: 45px;">
        <td align="right">快递单号:</td>
        <td style="padding-left:20px;"><input id="express_code_id" type="text" value="" style="width:300px;" /></td>
    </tr>
</table>
<br />
<button onclick="admin_invoice_manage.dispose_invoice_mail()">寄出</button>&nbsp;&nbsp;&nbsp;
@stop