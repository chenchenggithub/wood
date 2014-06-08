@extends('layouts.ajax_master')

@section('content')
<table class="table table-striped">
    <tr>
        <td>申请时间</td>
        <td>发票抬头</td>
        <td>申请订单</td>
        <td>申请金额</td>
        <td>申请状态</td>
    </tr>
    @foreach($invoice_records as $record)
    <tr>
        <td>{{$record->apply_time}}</td>
        <td>{{$record->invoice_header}}</td>
        <td>{{$record->order_ids}}</td>
        <td>{{$record->invoice_amount}}</td>
        <td>{{$record->status}}</td>
    </tr>
    @endforeach
</table>
@stop
