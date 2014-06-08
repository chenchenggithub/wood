@extends('layouts.ajax_master')

@section('content')
{{ Form::open(array('url'=>'/invoice/dispose_apply','method'=>'post'))}}
<!--<form action="/invoice/dispose_apply" method="post">-->
<table class="table table-striped" id="order_list_id">
    <tr>
        <td><input type="checkbox" name="" value="" /></td>
        <td>订单编号</td>
        <td>购买时间</td>
        <td>应付金额</td>
    </tr>
    @foreach($order_list as $k=>$v)
    <tr>
        <td><input type="checkbox" name="order_history_ids[]" value="{{$v->order_id}}" onclick="calculate_price();" /></td>
        <td>{{$v->order_num}}</td>
        <td>{{$v->order_time}}</td>
        <td>{{$v->payment_amount}}</td>
    </tr>
    @endforeach
</table>
<div style="width:100%;height:3px;background: red;margin: 10px 0px;"></div>
    <table style="float:right;margin-right: 100px;" >
        <tr>
            <td>发票金额：</td><td><span id="invoice_money"></span></td>
        <tr>
            <td>发票抬头:</td><td><input type="text" name="invoice_header" value=""/></td>
        </tr>
        <tr>
            <td>邮寄地址:</td><td><input type="text" name="address" value=""/></td>
        </tr>
        <tr>
            <td>邮编:</td><td><input type="text" name="zip_code" value=""/></td>
        </tr>
        <tr>
            <td>收件人:</td><td><input type="text" name="contact" value=""/></td>
        </tr>
        <tr>
            <td>收件人手机:</td><td><input type="text" name="telephone" value=""/></td>
        </tr>
        <tr>
            <td>备注:</td><td><textarea name="remark" cols="25" rows="5"></textarea></td>
        </tr>
        <tr>
            <td></td>
            <td><input type="submit" value="申请发票" /></td>
        </tr>
    </table>

<!--</form>-->
{{ Form::close() }}
@stop
@section('app_js')
<script>
    //计算申请发票订单的价格
    function calculate_price(){
        var order_ids = "";
        $("#order_list_id").find(":checkbox").each(function(){
           if($(this).is(':checked')) order_ids += $(this).val()+',';
        });
        T.restPost('/invoice/calculate_order',{'order_ids':order_ids},function(callbackData){
            var data = callbackData.data;
            $("#invoice_money").html(data.pay_sum);
        });
    }
</script>
@stop
