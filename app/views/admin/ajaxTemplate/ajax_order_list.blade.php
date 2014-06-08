@extends('layouts.ajax_master')
@section('content')
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
    @foreach($order_list as $list)
    <tr>
        <td>{{$list->order_num}}</td>
        <td>{{$list->user_email}}</td>
        <td>{{$list->user_mobile}}</td>
        <td>{{$list->order_format_type}}</td>
        <td>{{$list->order_format_status}}</td>
        <td>{{$list->payment_amount}}</td>
        <td><a href="javascript:void(0);" onclick="admin_order_manage.load_order_detail({{$list->order_id}},{{$list->order_type}})">查看</a></td>
    </tr>
    @endforeach
</table>
<?php echo $order_list->links('pagination::ajax_simple');?>
@stop