@extends('layouts.ajax_master')

@section('content')
<div class="main-container-title">订单信息</div>
<div class="main-container-body">
    <dl class="dl-horizontal order_info">
        <dt>订单编号：</dt>
        <dd class="text-blue">#{{$order['order_number']}}</dd>
    </dl>
    <dl class="dl-horizontal order_info">
        <dt>生成时间：</dt>
        <dd>{{$order['order_time']}}</dd>
    </dl>
    <dl class="dl-horizontal order_info">
        <dt>应付金额：</dt>
        <dd class="text-red">{{$order['payment_amount']}}</dd>
    </dl>
    <dl class="dl-horizontal order_info">
        <dt>订单状态：</dt>
        <dd>{{$order['order_status']}}</dd>
    </dl>
</div>
<div class="main-container-title">总购买信息<span class="font-normal">（{{$order_other['package_type']}}：<span class="text-red">￥{{$order_other['package_price']['unit_price']}}/月</span>）</span></div>
<div class="main-container-body">
    <div class="category_block">
        <div class="cg_row">
            <div class="cg_col">
                <div class="cg_title"><i class="host_icon"></i>主机监控</div>
                <div class="cg_body">
                    <dl>
                        <dt>{{$commodity[PackageEnum::HOST]}}</dt>
                        <dd>主机数</dd>
                    </dl>
                    <dl>
                        <dt>{{$commodity[PackageEnum::HOST_FREQUENCY]}}min</dt>
                        <dd>检测频率</dd>
                    </dl>
                </div>
            </div>
            <div class="cg_col">
                <div class="cg_title"><i class="site_icon"></i>网站监控</div>
                <div class="cg_body">
                    <dl>
                        <dt>{{$commodity[PackageEnum::WEBSITE]}}</dt>
                        <dd>项目数</dd>
                    </dl>
                    <dl>
                        <dt>{{$commodity[PackageEnum::WEBSITE_FREQUENCY]}}min</dt>
                        <dd>检测频率</dd>
                    </dl>
                </div>
            </div>
            <div class="cg_col">
                <div class="cg_title"><i class="mobile_icon"></i>移动监控</div>
                <div class="cg_body">
                    <dl>
                        <dt>{{$commodity[PackageEnum::MOBILE_APP]}}</dt>
                        <dd>项目数</dd>
                    </dl>
                    <dl>
                        <dt>{{$commodity[PackageEnum::MOBILE_APP_FREQUENCY]}}min</dt>
                        <dd>检测频率</dd>
                    </dl>
                </div>
            </div>
            <div class="cg_col">
                <div class="cg_title"><i class="monitor_icon"></i>监测点</div>
                <div class="cg_body m_number">
                    <dl>
                        <dt>{{$commodity[PackageEnum::MONITOR]['monitor_count']}}</dt>
                        <dd>监测点数 <a href="#" class="btn btn-default"  data-toggle="modal" data-target="#order_show_monitor">查看</a></dd>
                    </dl>
                    <dl>
                        <dt>{{$commodity[PackageEnum::MONITOR]['yundou']}}</dt>
                        <dd>云豆数</dd>
                    </dl>
                </div>
            </div>

            <div class="cg_col current_info">
                <div class="text-center">基础套餐（<span class="text-red">@if($order_other['is_has_package']) 1 @else 0 @endif</span>）</div>
                <div class="text-center">已增购次数（<span class="text-red">{{$order_other['add_purchase_count']}}</span>）</div>
            </div>
        </div>
    </div>
    <div class="cost_block">
        <div class="form-horizontal">
            <div class="form-group">
                <label for="" class="col-md-4 control-label">购买时限：</label>
                <div class="col-md-7">
                    <select class="form-control" name="" id="" disabled>
                        <option value="">{{$order_other['purchase_time']}}</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-md-4 control-label">每月总价：</label>
                <div class="col-md-7"><p class="form-control-static">￥{{$order_other['package_price']['basic_package_price']}} + ￥{{$order_other['package_price']['add_total_price']}}=￥{{$order_other['package_price']['unit_price']}}</p></div>
            </div>
            <div class="form-group">
                <label for="" class="col-md-4 control-label">合计：</label>
                <div class="col-md-7"><p class="form-control-static">￥{{$order_other['package_price']['unit_price']}} * {{$order_other['package_price']['purchase_time']}}月 = ￥{{$order_other['package_price']['total_price']}}</p></div>
            </div>
            <div class="form-group">
                <label for="" class="col-md-4 control-label">使用优惠码：</label>
                <div class="col-md-7">
                    <input type="text" class="form-control" value="{{$order_other['promo_code']}}" disabled />
                    <p class="form-hint"></p>
                </div>
            </div>
            <div class="form-group cose_submit">
                <label for="" class="col-md-4 control-label">实际应付费用：</label>
                <div class="col-md-8">
                    @if($order_other['package_price']['status_code'] == ProfessionErrorCodeEnum::PROMO_STRATEGY_SUCCESS)
                        @if($order_other['package_price']['promo_strategy'] == PromoStrategyEnum::DISCOUNT)
                    ￥{{$order_other['package_price']['total_price']}} * {{$order_other['package_price']['promo_value']}} =<span class="cose_result">￥{{$order_other['package_price']['real_total_price']}}</span>
                        @endif
                        @if($order_other['package_price']['promo_strategy'] == PromoStrategyEnum::PROMO_AMOUNT)
                    ￥{{$order_other['package_price']['total_price']}} - {{$order_other['package_price']['promo_value']}} =<span class="cose_result">￥{{$order_other['package_price']['real_total_price']}}</span>
                        @endif

                    @else
                     <span class="cose_result">￥{{$order_other['package_price']['real_total_price']}}</span>
                    @endif
                    <button class="btn btn-blue right" onclick="comfirm_order_fun({{$order_other['order_id']}})">确认订单</button>
                </div>
            </div>
        </div>
    </div>


{{--<div title="默认监测点">
    <fieldset>
        @foreach($commodity[PackageEnum::MONITOR]['select_monitor'] as $k=>$v)
        <input type="checkbox" name="" value="{{$k}}" checked="checked" disabled="disabled" />{{$v[1]}}({{$v[2]}}云豆)
        @endforeach
    </fieldset>
</div>--}}

<div id="order_show_monitor" class="modal fade">
    <div class="modal-dialog" style="width:680px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h5 class="modal-title">监测点配置</h5>
            </div>
            <div class="modal-body">
                <p class="monitor_des">总的购买监测点数 <span class="text-red">{{$commodity[PackageEnum::MONITOR]['monitor_count']}}</span> 个，总值 <span class="text-red">{{$commodity[PackageEnum::MONITOR]['yundou']}}</span> 云豆</p>
                <div class="modal-panel-body">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>名称</th><th>区域</th><th>云豆数</th>
                        </tr>
                        </thead>
                        <tbody id="load_order_add_monitor_list">

                        </tbody>
                    </table>
                    <ul class="pagination pull-right" id="order_add_monitor_page_list_id">

                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    $('#main-container-id').scrollTop(0);
    $('.main').scrollTop(0);

    //加载已选择的监测点
    function loadOrderAddMonitorFunc(page){
        var order_add_monitor = {{$order_add_monitor}};
        var page_num = {{$page_num}};
        var total = tsb_count(order_add_monitor);
        var start = (page-1)*page_num+1;
        var end = page*page_num;
        if(end >total) end = total;
        var selected_monitor_list = '';
        var count_num = 1;
        for(var i in order_add_monitor){
            if(count_num >= start && count_num<=end)
                selected_monitor_list += '<tr><td>'+order_add_monitor[i][1]+'</td><td>'+order_add_monitor[i]['area_name']+'</td><td>'+order_add_monitor[i][2]+'</td></tr>';
            count_num++;
        }

        $("#load_order_add_monitor_list").html(selected_monitor_list);
        var page_html = getOrderAddMonitorPageList(page,page_num,total);
        $("#order_add_monitor_page_list_id").html(page_html);
    }
    //获取分页列表
    function getOrderAddMonitorPageList(page,page_num,total){
        var all_page = Math.ceil(total/page_num);
        var page_html = '';
        var page_head = page - 1;
        var page_last = page + 1;
        if(page_head <=0) page_head = 1;
        if(page_last >=all_page) page_last = all_page;
        page_html += '<li><a href="javascript:loadOrderAddMonitorFunc('+page_head+');">«</a></li>'
        for(var i=1;i<=all_page;i++){
            if(i == page){
                page_html += '<li class="active"><a href="javascript:loadOrderAddMonitorFunc('+i+');">'+i+'</a></li>';
            }else{
                page_html += '<li><a href="javascript:loadOrderAddMonitorFunc('+i+');">'+i+'</a></li>';
            }
        }
        page_html += '<li><a href="javascript:loadOrderAddMonitorFunc('+page_last+');">»</a></li>'
        return page_html;
    }
    loadOrderAddMonitorFunc(1);

    //确认订单
    function comfirm_order_fun(order_id){
        var submitData = {order_id:order_id};
        T.ajaxLoad('/buy/ajax/load_order_settlement','main-container-id',submitData,function(){});
    }
</script>
@stop

