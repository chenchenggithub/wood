@extends('layouts.ajax_master')
@section('content')
<div class="pay_block" style="border-top: 0px;">
    <div class="pay_info">
        <ul>
            <li>支付金额：<span class="pay_money">￥{{$order->payment_amount}}</span></li>
        </ul>
        <ul>
            <li>订单编号：#{{$order->order_id}}</li>
            <li>订单类型：{{OrderEnum::$order_type[$order->order_type]}}</li>
            <li>收款方：监控宝</li>
        </ul>
    </div>
    <div class="alert alert-blue"><b>提示：</b>通常情况下，所有购买项目会在支付成功后立即自动生效。如果支付成功后由于银行数据同步延迟造成购买项目无法自动生效，请您通过反馈联系我们，并注明您的购买记录编号（#{{$order->order_id}}），我们会为您尽快处理。此处为提示信息，后续给出准确的说明文字。</div>
    <div class="payment">
        <div class="payment_title">请选择合适的付款方式：</div>
        <div class="payment_body">
            <ul class="payment_list">
                <li class="title">支付宝付款：</li>
                <li>
                    <div class="table-block">
                        <div class="table-cell"><input type="radio" name="" id="" /></div>
                        <div class="table-cell"><img class="pay-img" src="/resource/img/system/zhifubao.png" alt="" /></div>
                        <div class="table-cell"><a href="#" class="btn btn-blue pay_btn">确认支付</a></div>
                    </div>
                </li>
                <li class="title">银行线下汇款：</li>
                <li>
                    <div class="table-block">
                        <div class="table-cell bank_transfer">
                            <dl class="dl-horizontal">
                                <dt>开户银行：</dt>
                                <dd>工商银行北京公主坟支行</dd>
                                <dt>现代化支付系统行号：</dt>
                                <dd>102100000466</dd>
                                <dt>开户名称：</dt>
                                <dd>云智慧（北京）科技有限公司</dd>
                                <dt>开户帐号：</dt>
                                <dd>0200246909200010777</dd>
                            </dl>
                        </div>
                        <div class="table-cell"><a href="#" class="btn btn-default pay_btn">在线反馈</a></div>
                    </div>
                    <div class="alert alert-blue bank_des"><b>说明：</b>汇款后请把您的订单号（#{{$order->order_id}}）和支付金额（￥{{$order->payment_amount}}）反馈给我们，我们会在收到款后为您开通服务。</div>
                </li>
                <li class="title">PayPal付款：（国际版才有）</li>
                <li>
                    <div class="table-block">
                        <div class="table-cell"><input type="radio" name="" id="" /></div>
                        <div class="table-cell"><img class="pay-img" src="/resource/img/system/paypal.png" alt="" /></div>
                        <div class="table-cell"><a href="javascript:void(0);" class="btn btn-default pay_btn" onclick="">确认支付</a></div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
</div>
@stop