@extends('layouts.ajax_master')
@section('content')
<table>
    <input type="hidden" id="invoice_apply_id" value="{{$invoice_invoicing_info->invoice_apply_id}}">

    <tr style="height: 45px;">
        <td align="right">审核时间:</td>
        <td style="padding-left:20px;">{{$invoice_invoicing_info->audit_time}}</td>
    </tr>
    <tr style="height: 45px;">
        <td align="right">发票抬头:</td>
        <td style="padding-left:20px;">{{$invoice_invoicing_info->invoice_header}}</td>
    </tr>
    <tr style="height: 45px;">
        <td align="right">开票金额(￥):</td>
        <td style="padding-left:20px;">{{$invoice_invoicing_info->invoice_amount}}</td>
    </tr>
    <tr style="height: 45px;">
        <td align="right">系统备注:</td>
        <td style="padding-left:20px;">{{$invoice_invoicing_info->audit_remark}}</td>
    </tr>
    <tr style="height: 45px;">
        <td align="right">发票单号:</td>
        <td style="padding-left:20px;"><input id="invoice_code_id" type="text" value="" style="width:300px;" /></td>
    </tr>

</table>
<br />
<button onclick="admin_invoice_manage.dispose_invoice_invoicing()">开发票</button>
@stop