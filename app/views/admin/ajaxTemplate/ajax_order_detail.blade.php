@extends('layouts.ajax_master')
@section('content')
<table>
    <tr>
        <td>订单编号:</td>
        <td>{{$order['order_number']}}</td>
    </tr>
    <tr>
        <td>生成时间:</td>
        <td>{{$order['order_time']}}</td>
    </tr>
    <tr>
        <td>应付金额:</td>
        <td>{{$order['payment_amount']}}</td>
    </tr>
    <tr>
        <td>支付状态:</td>
        <td>{{$order['order_status']}}</td>
    </tr>
</table>
@if($is_renewals == false)
<div style="width:100%;height:30px;background:yellow;">包含的项目：</div>
<table>
    @foreach($commodity as $k=>$v)
    @if($k != PackageEnum::MONITOR)
    <tr>
        <td>{{$v['name']}}:</td>
        <td>{{$v['value']}}</td>
    </tr>
    @endif
    @if($k == PackageEnum::MONITOR)
    <tr>
        <td>{{$v['name']}}:</td>
        <td>
            @if(!empty($v['value']))
            @foreach ($v['value'] as $monitor_name)
            {{$monitor_name}},
            @endforeach
            @endif
        </td>
    </tr>
    @endif
    @endforeach
</table>

<div style="width:100%;height:30px;background:yellow;">操作订单</div>
<br />
<button onclick="admin_order_manage.submit_order_confirm({{$order_id}})">确认订单支付</button>
<button onclick="window.location.href='/order_manage'">返回订单列表</button>

@endif
@stop