@extends('layouts.master')

@section('title')
  历史订单
@stop

@section('app_css')

@stop

@section('content')
<div class="main">
    <div class="main-title">系统</div>
    <div class="main-body">
        @include('layouts.tsb_left_leaf')
        <div class="main-container" id="main-container-id">
            <table class="table table-striped">
                <tr width="80%">
                    <td width="20%">订单编号</td>
                    <td width="20%">购买时间</td>
                    <td width="20%">应付金额</td>
                    <td width="20%">订单类型</td>
                    <td width="20%">订单状态</td>
                </tr>
                @foreach($order_list as $v)
                <tr>
                    <td>{{$v->order_id}}</td>
                    <td>{{$v->order_time}}</td>
                    <td>{{$v->payment_amount}}</td>
                    <td>{{$v->order_type}}</td>
                    <td>{{$v->order_status}}</td>
                </tr>
                @endforeach
            </table>
            <?php echo $order_list->links();?>
        </div>
    </div>
</div>
@stop

@section('app_js')

@stop
