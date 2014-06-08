@extends('layouts.master')

@section('title')
    购买项目
@stop

@section('app_css')
<link href="/resource/css/system/purchase.css" type="text/css" rel="stylesheet"/>
<link href="/resource/css/lib/jquery-ui.min.css" type="text/css" rel="stylesheet"/>
@stop

@section('content')
<div class="main">
<div class="main-title">系统</div>
<div class="main-body">
<!-- main-slider -->
@include('layouts.tsb_left_leaf')

<!-- main-container -->
<div class="main-container" id="main-container-id">
<div class="main-container-title">总购买信息<span class="font-normal">（基础套餐：<span class="text-red">￥1999/月</span>）</span></div>
<div class="main-container-body">
<div class="category_block">
    <div class="cg_row">
        <div class="cg_col">
            <div class="cg_title"><i class="host_icon"></i>主机监控</div>
            <div class="cg_body">
                <dl>
                    <dt id="all_host_count">{{$package['host']['count']}}</dt>
                    <dd>主机数</dd>
                </dl>
                <dl>
                    <dt id="all_host_frequency">{{$package['host']['frequency']}}min</dt>
                    <dd>检测频率</dd>
                </dl>
            </div>
        </div>
        <div class="cg_col">
            <div class="cg_title"><i class="site_icon"></i>网站监控</div>
            <div class="cg_body">
                <dl>
                    <dt id="all_website_count">{{$package['website']['count']}}</dt>
                    <dd>项目数</dd>
                </dl>
                <dl>
                    <dt id="all_website_frequency">{{$package['website']['frequency']}}min</dt>
                    <dd>检测频率</dd>
                </dl>
            </div>
        </div>
        <div class="cg_col">
            <div class="cg_title"><i class="mobile_icon"></i>移动监控</div>
            <div class="cg_body">
                <dl>
                    <dt id="all_mobileapp_count">{{$package['mobile_app']['count']}}</dt>
                    <dd>项目数</dd>
                </dl>
                <dl>
                    <dt id="all_mobileapp_frequency">{{$package['mobile_app']['frequency']}}min</dt>
                    <dd>检测频率</dd>
                </dl>
            </div>
        </div>
        <div class="cg_col">
            <div class="cg_title"><i class="monitor_icon"></i>监测点</div>
            <div class="cg_body m_number">
                <dl>
                    <dt id="all_monitor_count">{{count($package['monitor'])}}</dt>
                    <dd>监测点数 <a href="/buy/ajax/load_show_monitor" class="btn btn-default" data-toggle="modal" data-target="#show_monitor">查看</a></dd>
                </dl>
                <dl>
                    <dt id="all_yundou_count">{{$basic_yundou_count}}</dt>
                    <dd>云豆数</dd>
                </dl>
            </div>
        </div>
        <div class="cg_col current_info">
            <div class="text-center">基础套餐（<span class="text-red">@if($is_has_package == false) 0 @else 1 @endif</span>）</div>
            <div class="text-center">已增购次数（<span class="text-red">{{$add_purchase_count}}</span>）</div>
        </div>
    </div>
</div>

<div class="pur_form">
    <ul class="nav nav-tediums">
        <li class="active"><a href="#buy-pane" data-toggle="tab">增购</a></li>
        @if($is_has_package)
        <li><a href="#renew-pane" data-toggle="tab">续费</a></li>
        @endif
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="buy-pane">
            <div class="pur_form_title">本次增购项目</div>
            <div class="category_block">
                <div class="cg_row">
                    <div class="cg_col">
                        <div class="cg_title"><i class="host_icon"></i>主机监控</div>
                        <div class="cg_body">
                            <dl>
                                <dt>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-minus-square-o" onclick="dispose_package('host','reduce')"></i></span>
                                    <input id="add_host_count" type="text" class="form-control" value="0" disabled style="text-align: center;" />
                                    <span class="input-group-addon"><i class="fa fa-plus-square-o" onclick="dispose_package('host','add')"></i></span>
                                </div>
                                </dt>
                                <dd>主机数</dd>
                            </dl>
                            <dl>
                                <dt>

                                    <select onchange="dispose_package('host','frequency')" id="add_host_frequency" class="cg_select">
                                        @foreach($add_purchase_frequency['host'] as $v)
                                        <option value='{{$v}}' @if($package['host']['frequency'] == $v) selected @endif>{{$v}} min</option>
                                        @endforeach
                                    </select>
                                </dt>
                                <dd>检测频率</dd>
                            </dl>
                        </div>
                    </div>
                    <div class="cg_col">
                        <div class="cg_title"><i class="site_icon"></i>网站监控</div>
                        <div class="cg_body">
                            <dl>
                                <dt>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-minus-square-o" onclick="dispose_package('website','reduce')"></i></span>
                                    <input id="add_website_count" type="text" class="form-control" value="0" disabled style="text-align: center;"/>
                                    <span class="input-group-addon"><i class="fa fa-plus-square-o" onclick="dispose_package('website','add')"></i></span>
                                </div>
                                </dt>
                                <dd>项目数</dd>
                            </dl>
                            <dl>
                                <dt>

                                    <select onchange="dispose_package('website','frequency')" id="add_website_frequency" class="cg_select">
                                        @foreach($add_purchase_frequency['website'] as $v)
                                        <option value='{{$v}}' @if($package['website']['frequency'] == $v) selected @endif>{{$v}} min</option>
                                        @endforeach
                                    </select>
                                </dt>
                                <dd>检测频率</dd>
                            </dl>
                        </div>
                    </div>
                    <div class="cg_col">
                        <div class="cg_title"><i class="mobile_icon"></i>移动监控</div>
                        <div class="cg_body">
                            <dl>
                                <dt>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-minus-square-o" onclick="dispose_package('mobileapp','reduce')"></i></span>
                                    <input id="add_mobileapp_count" type="text" class="form-control" value="0" disabled style="text-align: center;" />
                                    <span class="input-group-addon"><i class="fa fa-plus-square-o" onclick="dispose_package('mobileapp','add')"></i></span>
                                </div>
                                </dt>
                                <dd>项目数</dd>
                            </dl>
                            <dl>
                                <dt>
                                    <select onchange="dispose_package('mobileapp','frequency')" id="add_mobileapp_frequency" class="cg_select">
                                        @foreach($add_purchase_frequency['mobileapp'] as $v)
                                        <option value='{{$v}}' @if($package['mobile_app']['frequency'] == $v) selected @endif>{{$v}} min</option>
                                        @endforeach
                                    </select>
                                </dt>
                                <dd>检测频率</dd>
                            </dl>
                        </div>
                    </div>
                    <div class="cg_col">
                        <div class="cg_title"><i class="monitor_icon"></i>监测点</div>
                        <div class="cg_body m_number">
                            <dl>
                                <dt id="add_monitor_count">0</dt>
                                <dd>监测点数 <a href="/buy/ajax/load_setting_monitor" class="btn btn-default" data-toggle="modal" data-target="#setting_monitor">设置</a></dd>
                            </dl>
                            <dl>
                                <dt id="add_yundou_count">0</dt>
                                <dd>云豆数</dd>
                            </dl>
                        </div>
                    </div>
                    <div class="cg_col current_info">
                        <div class="text-center">增购总单价：<span class="text-red" id="add_total_price">￥0/月</span></div>
                        <div class="text-center"><a href="#" class="btn btn-default" data-toggle="modal" data-target="#show_buy_details">查看详情</a></div>
                    </div>
                </div>
            </div>
            <div class="cost_block">
                <div class="form-horizontal">
                    <div class="form-group">
                        <label for="" class="col-md-4 control-label">购买时限：</label>
                        <div class="col-md-7">
                            <select class="form-control" id="purchase_time">
                                @if($is_has_package == false)
                                @foreach($add_purchase_time as $k=>$v)
                                <option value='{{$k}}'>{{$v}}</option>
                                @endforeach
                                @else
                                <option value='{{$add_purchase_time}}'>{{$add_purchase_time}}</option>
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-md-4 control-label">每月总价：</label>
                        <div class="col-md-7"><p class="form-control-static" id="unit_price">￥{{$package['package_price']}}</p></div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-md-4 control-label">合计：</label>
                        <div class="col-md-7"><p class="form-control-static" id="total_price">￥{{$package['package_price']}}*1月 =￥{{$package['package_price']}}</p></div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-md-4 control-label">使用优惠码：</label>
                        <div class="col-md-7">
                            <input type="text" class="form-control" id="promo_code" value="" />
                            <p class="form-hint" id="buy_promo_explanation"></p>
                        </div>
                    </div>
                    <div class="form-group cose_submit">
                        <label for="" class="col-md-4 control-label">实际应付费用：</label>
                        <div class="col-md-8">
                            <span id="buy_actual_expression"></span><span class="cose_result" id="actual_total_price">￥{{$package['package_price']}}</span>
                            <button class="btn btn-blue right" onclick="confirm_add_purchase()">确认并购买</button>
                        </div>

                    </div>
                </div>
            </div>

        </div>
        <div class="tab-pane" id="renew-pane">
            <div class="cost_block">
                <div class="form-horizontal">
                    <div class="form-group">
                        <label for="" class="col-md-4 control-label">购买时限：</label>
                        <div class="col-md-7">
                            @if($is_has_package)
                            <select class="form-control" id="renewals_time">
                                @foreach($renewals_purchase_time as $k=>$v)
                                <option value='{{$k}}'>{{$v}}</option>
                                @endforeach
                            </select>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-md-4 control-label">每月总价：</label>
                        <div class="col-md-7"><p class="form-control-static" id="renewals_unit_price">￥{{$renewals_unit_price}}</p></div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-md-4 control-label">合计：</label>
                        <div class="col-md-7"><p class="form-control-static" id="renewals_total_price">￥{{$renewals_unit_price}}*1月 =￥{{$renewals_unit_price}}</p></div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-md-4 control-label">使用优惠码：</label>
                        <div class="col-md-7">
                            <input type="text" class="form-control" id="renewals_promo" value="" />
                            <p class="form-hint" id="renewals_promo_explanation"></p>
                        </div>
                    </div>
                    <div class="form-group cose_submit">
                        <label for="" class="col-md-4 control-label">实际应付费用：</label>
                        <div class="col-md-8">
                            <span id="renewals_actual_expression"></span><span class="cose_result" id="real_renewals_total_price">￥{{$renewals_unit_price}}</span>
                            <button class="btn btn-blue right" onclick="confirm_renewals()">确认并购买</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
    {{Form::open(array('url'=>'/buy/dispose_add_purchase','id'=>'buyAddPurchaseFormId','method'=>'post'))}}
    <input type="hidden" name="buy_type" value="1" />
    <input type="hidden" name="add_host_count" value="0" />
    <input type="hidden" name="add_host_frequency" value="0" />
    <input type="hidden" name="add_website_count" value="0" />
    <input type="hidden" name="add_website_frequency" value="0" />
    <input type="hidden" name="add_mobileapp_count" value="0" />
    <input type="hidden" name="add_mobileapp_frequency" value="0" />
    <input type="hidden" name="monitor_count" value="0" />
    <input type="hidden" name="add_monitor" value="" />
    <input type="hidden" name="add_yundou_count" value="0" />
    <input type="hidden" name="purchase_time" value="">
    <input type="hidden" name="promo_code" value="" />
    {{Form::close()}}

    {{Form::open(array('url'=>'/buy/dispose_renewals','id'=>'buyRenewalsFormId','method'=>'post'))}}
    <input type="hidden" name="renewals_time" value="">
    <input type="hidden" name="promo_code" value="" />
    {{Form::close()}}

    <div id="show_monitor" title="默认监测点" class="modal fade"></div>
    <div id="setting_monitor" title="增购监测点" class="modal fade"></div>

    <div id="show_buy_details" title="查看详情" class="modal fade">
        <div class="modal-dialog" style="width:650px;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h5 class="modal-title">订单详情</h5>
                </div>
                <div class="modal-body">
                    <img src="/resource/img/system/order_details.png" alt="" class="center-block" />
                </div>
            </div><!-- /.modal-content -->
        </div>
    </div>



</div>
</div>
</div>
@stop

@section('app_js')
<script src="/resource/js/purchase/purchase.js"></script>
<script>

    //初始化套餐的数量
    var basic_host_count = {{$package['host']['count']}},
    basic_website_count = {{$package['website']['count']}},
    basic_mobileapp_count = {{$package['mobile_app']['count']}},
    basic_monitor_count =  {{count($package['monitor'])}},
    basic_package_price = {{$package['package_price']}};
    var default_add_host_count = {{$default_add_count['host']}},
    default_add_website_count = {{$default_add_count['website']}},
    default_add_mobileapp_count = {{$default_add_count['mobileapp']}};

    //增购处理方式
    function confirm_add_purchase(){
        var buy_type = $("#buyAddPurchaseFormId").find("input[name='buy_type']").val();
        $("#buyAddPurchaseFormId").find("input[name='add_host_count']").val(parseInt($("#add_host_count").val()));
        $("#buyAddPurchaseFormId").find("input[name='add_website_count']").val(parseInt($("#add_website_count").val()));
        $("#buyAddPurchaseFormId").find("input[name='add_mobileapp_count']").val(parseInt($("#add_mobileapp_count").val()));
        $("#buyAddPurchaseFormId").find("input[name='add_yundou_count']").val(parseInt($("#add_yundou_count").html()));
        $("#buyAddPurchaseFormId").find("input[name='add_host_frequency']").val(parseInt($("#add_host_frequency").val()));
        $("#buyAddPurchaseFormId").find("input[name='add_website_frequency']").val(parseInt($("#add_website_frequency").val()));
        $("#buyAddPurchaseFormId").find("input[name='add_mobileapp_frequency']").val(parseInt($("#add_mobileapp_frequency").val()));
        $("#buyAddPurchaseFormId").find("input[name='purchase_time']").val(parseInt($("#purchase_time").val()));
        $("#buyAddPurchaseFormId").find("input[name='promo_code']").val($.trim($("#promo_code").val()));
        $("#buyAddPurchaseFormId").find("input[name='add_mobileapp_frequency']").val(parseInt($("#add_mobileapp_frequency").val()));
        var submitData = $("#buyAddPurchaseFormId").serialize();
        T.ajaxLoad('/buy/ajax/dispose_add_purchase','main-container-id',submitData,function(){});
    }

    //续费处理方式
    function confirm_renewals(){
        $("#buyRenewalsFormId").find("input[name='renewals_time']").val(parseInt($("#renewals_time").val()));
        $("#buyRenewalsFormId").find("input[name='promo_code']").val($.trim($("#renewals_promo").val()));
        var submitData = $("#buyRenewalsFormId").serialize();
        T.ajaxLoad('/buy/ajax/dispose_renewals','main-container-id',submitData,function(){});
    }
    //TSB.modalAlert({status:'error',msg:'保存失败'});
</script>
@stop

