@extends('layouts.ajax_master')
@section('content')
<table class="table table-striped">
    <thead>
    <tr style="background-color: #ccc;">
        <td>策略ID</td>
        <td>策略名称</td>
        <td>优惠码</td>
        <td>使用次数</td>
        <td>创建时间</td>
        <td>创建用户</td>
    </tr>
    </thead>
    @foreach($code_list as $list)
    <tr>
        <td>{{$list->strategy_id}}</td>
        <td>{{$list->name}}</td>
        <td>{{$list->code}}</td>
        <td>{{$list->used_count}}</td>
        <td>{{$list->create_time}}</td>
        <td>{{$list->admin_email}}</td>
    </tr>
    @endforeach

</table>
<?php echo $code_list->links('pagination::ajax_simple');?>
@stop