@extends('layouts.ajax_master')
@section('content')
<table class="table table-striped">
    <thead>
    <tr style="background-color: #ccc;">
        <td>策略ID</td>
        <td>策略名称</td>
        <td>优惠条件</td>
        <td>优惠方式</td>
        <td>优惠码数量</td>
        <td>生成新优惠码</td>
        <td>创建时间</td>
        <td>操作</td>
    </tr>
    </thead>
    @foreach($strate_list as $list)
    <tr>
        <td>{{$list->strategy_id}}</td>
        <td>{{$list->name}}</td>
        <td>{{$list->use_condition}}</td>
        <td>{{$list->promo_patt}}</td>
        <td>{{$list->create_code_count}}</td>
        <td><a href="javascript:void(0);" onclick="admin_promo.create_promo_code({{$list->strategy_id}})">生成优惠码</a></td>
        <td>{{$list->create_time}}</td>
        <td><a href="javascript:void(0);" onclick="admin_promo.update_promo_strategy({{$list->strategy_id}})">修改</a> </td>
    </tr>
    @endforeach
</table>
<?php echo $strate_list->links('pagination::ajax_simple');?>
@stop