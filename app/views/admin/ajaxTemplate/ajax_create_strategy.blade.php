@extends('layouts.ajax_master')
@section('content')
<style>
    .promo_nav{
        float:left;
        margin:10px 0px;
        width:100%;
        height: 35px;
        line-height:35px;
        font-size:17px;
        background-color: #E0E9F1;
    }
    .promo_strategy_nav{
        float:left;
        margin-bottom: 5px;
        width:100%;
        height: 35px;
        line-height:35px;
        font-size:15px;
        background-color: #ccc;
    }
</style>
{{Form::open(array('url'=>'/promo_code/dispose_promo_strategy','method'=>'post','id'=>'create_strategy_form_id','onsubmit'=>'ajaxSubmit();return false'))}}
<div class="promo_nav">策略名称</div>
<div class="input-group input-group-lg">
    <span class="input-group-addon">优惠策略名称：</span>
    <input type="text" class="form-control" name="promo_name" placeholder="">
</div>
<div class="input-group input-group-lg">
    <span class="input-group-addon">策略备注：</span>
    <textarea name="promo_remark"></textarea>
</div>
<div class="promo_nav">优惠码使用条件</div>
<div class="promo_strategy_nav">使用期限</div>
<div class="input-group input-group-lg">
    <span class="input-group-addon">开始时间：</span>
    <input type="text" class="datepicker" name="{{PromoStrategyEnum::TIME_LIMIT}}[]" id="" value="">
</div>
<div class="input-group input-group-lg">
    <span class="input-group-addon">结束时间：</span>
    <input type="text" class="datepicker" name="{{PromoStrategyEnum::TIME_LIMIT}}[]" placeholder="">
</div>

<div class="promo_strategy_nav">使用次数</div>
<div class="input-group input-group-lg">
    <span class="input-group-addon">次数限制：</span>
    <input type="text" class="form-control" name="{{PromoStrategyEnum::USE_COUNT}}" placeholder="">
</div>

<div class="promo_strategy_nav">消费达到金额</div>
<div class="input-group input-group-lg">
    <span class="input-group-addon">消费金额：</span>
    <input type="text" class="form-control" name="{{PromoStrategyEnum::CONSUMPTION_AMOUNT}}" placeholder="">
</div>

<div class="promo_nav">优惠码优惠模式</div>
<div class="promo_strategy_nav">折扣</div>
<div class="input-group input-group-lg">
    <span class="input-group-addon">折扣，如八折为0.80：</span>
    <input type="text" class="form-control" name="{{PromoStrategyEnum::DISCOUNT}}" placeholder="">
</div>
<div class="promo_strategy_nav">优惠金额</div>
<div class="input-group input-group-lg">
    <span class="input-group-addon">具体减少金额：</span>
    <input type="text" class="form-control" name="{{PromoStrategyEnum::PROMO_AMOUNT}}" placeholder="">
</div>

<div class="input-group input-group-lg">
    <input type="submit" class="form-control" value="保存">
</div>

{{Form::close()}}
<script src="/resource/js/lib/jquery-ui-1.10.4/jquery-ui.custom.min.js"></script>
<link href="/resource/css/lib/jquery-ui.min.css" type="text/css" rel="stylesheet" />
<script>
    $(function() {
        $(".datepicker").datepicker();

    })
    //form提交事件
    function ajaxSubmit(){
        admin_promo.submit_promo_strategy($('#create_strategy_form_id').serialize());
    }

</script>
@stop