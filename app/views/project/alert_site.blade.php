@extends('layouts.master')

@section('title')
网站创建
@stop

@section('app_css')
<link rel="stylesheet" href="/resource/css/site/create.css?v=<?php echo ResourceSpall::getResourceVersion(); ?>">
@stop

@section('app_js')
<script
    src="/resource/js/project/alert_config_setting.js?v=<?php echo ResourceSpall::getResourceVersion(); ?>"></script>
<script>
    $(document).ready(function () {
        alert_config_setting.init();
        alert_config_setting.modify();
    });
</script>
@stop

@section('content')

<div class="main">
    <div class="main-title">网站监控</div>
    <div class="main-body">
        @include('project.site_menu')
        <div class="tab-content">
            <div class="tab-pane" id="base-pane"></div>
            <div class="tab-pane" id="team-pane"></div>
            <div class="tab-pane active" id="alarm-pane">

                @include('project.site_alert_menu')

                <div class="tab-content">

                    <div class="tab-pane active" id="alarm-site-pane">
                        {{ Form::open()}}
                        <input type="hidden" name="app_id" value="<?php echo $baseInfo->app_id; ?>">
                        <input type="hidden" name="target_id" value="<?php echo $baseInfo->domain_id; ?>">
                        <input type="hidden" name="target_type"
                               value="<?php echo ServiceAlertConfigExtEnum::TARGET_TYPE_DOMAIN; ?>">
                        <input type="hidden" name="alert_type"
                               value="<?php echo AlertTypeEnum::SITE_PERFORMACE_INDEX; ?>">
                        <input type="hidden" name="status"
                               value="<?php echo isset($configInfo) ? $configInfo->status : ServiceAlertConfigExtEnum::STATUS_OFFLINE; ?>">

                        <div class="panel panel-default">
                            <div class="panel-heading">网站性能指数
                                <input type="checkbox"
                                       class="js-alert-type-status"
                                       name="switch-checkbox" data-on-color="blue"
                                       data-on-text="&nbsp;" data-off-text="&nbsp;"
                                       checked/>
                            </div>
                            <div class="panel-body">
                                <div class="alarm_block">
                                    <div class="alarm_title">告警阈值设置</div>
                                    <div class="alarm_body">
                                        <div class="a_row">
                                            <label class="radio">
                                                <input type="radio" name="afterwards_or_trend" id="" value="1">
                                                事后告警规则</label>
                                        </div>
                                        <div class="a_row">
                                            如果最近
                                            <select class="form-control a_select" name="afterwards_latly_hour" id="">
                                                <?php echo AlertSpall::mkOptionSelectedByValue(AlertTypeTplConfigEnum::$optionAfterWardsLatlyHourPerformaceIndex); ?>
                                            </select>
                                            内的网站性能指数为如下情况，则意味着出现问题。
                                        </div>
                                        <div class="a_row">
                                            <div class="slider-widget-block">
                                                <div class="slider-widget-label">
                                                    警告：网站性能指数小于 <span id="afterwards_warning_bar">0</span> 分时触发警告&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <label class="checkbox a_checkbox">
                                                        <input type="hidden" name="afterwards_warning_bar">
                                                        <input type="checkbox" name="afterwards_warning_alert" checked/>
                                                        发送告警消息
                                                    </label>
                                                </div>
                                                <div class="slider-widget-item">
                                                    <div class="slider-widget-range">0</div>
                                                    <div id="pi-slider" class="slider-widget slider-warning"></div>
                                                    <div class="slider-widget-range">100</div>
                                                </div>
                                                <div class="slider-widget-label a_right">
                                                    故障：网站性能指数小于 <span id="afterwards_error_bar">0</span> 分时触发故障&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <label class="checkbox a_checkbox">
                                                        <input type="hidden" name="afterwards_error_bar">
                                                        <input type="checkbox" name="afterwards_error_alert" checked/>
                                                        发送告警消息
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="a_row">
                                            <label class="radio">
                                                <input type="radio" name="afterwards_or_trend" id="" value="2">
                                                趋势告警规则
                                            </label>
                                        </div>
                                        <div class="a_row">
                                            如果最近
                                            <select class="form-control a_select" name="trend_latly_hour" id="">
                                                <?php echo AlertSpall::mkOptionSelectedByValue(AlertTypeTplConfigEnum::$optionTrendLatlyHourPerformaceIndex); ?>
                                            </select>
                                            内的网站性能指数，比过去
                                            <select class="form-control a_select" name="trend_departed_day" id="">
                                                <?php echo AlertSpall::mkOptionSelectedByValue(AlertTypeTplConfigEnum::$optionTrendDepartedDayPerformaceIndex); ?>
                                            </select>
                                            高出如下数值，则意味着出现问题。
                                        </div>
                                        <div class="a_row">
                                            <div class="slider-widget-block">
                                                <div class="slider-widget-label">
                                                    警告：增长率大于 <span id="trend_warning_bar">0</span>% 时触发警告&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <label class="checkbox a_checkbox">
                                                        <input type="hidden" name="trend_warning_bar">
                                                        <input type="checkbox" name="trend_waring_alert" checked/>
                                                        发送告警消息
                                                    </label>
                                                </div>
                                                <div class="slider-widget-item">
                                                    <div class="slider-widget-range">0%</div>
                                                    <div id="rate-slider" class="slider-widget slider-warning"></div>
                                                    <div class="slider-widget-range">100%</div>
                                                </div>
                                                <div class="slider-widget-label a_right">
                                                    故障：增长率大于 <span id="trend_error_bar">0</span>% 时触发故障&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <label class="checkbox a_checkbox">
                                                        <input type="hidden" name="trend_error_bar">
                                                        <input type="checkbox" name="trend_error_alert" checked/> 发送告警消息
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="alarm_block">
                                    <div class="alarm_title">监测点设置</div>
                                    <div class="alarm_body">
                                        <div class="a_row">
                                            <label class="radio">
                                                <input type="radio" name="monitor_any_or_appoint" id="" value="1">
                                                任何监测点</label>
                                        </div>
                                        <div class="a_row">
                                            任意 <input class="form-control a_input" type="text" name="monitor_any_count"
                                                      id="" value="5"/>
                                            个监测点出现问题即触发警告或故障
                                        </div>
                                        <div class="a_row">
                                            <label class="radio">
                                                <input type="radio" name="monitor_any_or_appoint" id="" value="2">
                                                指定监测点</label>
                                        </div>
                                        <div class="a_row">
                                            <label class="checkbox a_checkbox">
                                                <input name="monitor_list[]" type="checkbox"/> 上海电信
                                            </label>
                                            <label class="checkbox a_checkbox"><input type="checkbox"/> 上海电信</label>
                                            <label class="checkbox a_checkbox"><input type="checkbox"/> 上海电信</label>
                                            <label class="checkbox a_checkbox"><input type="checkbox"/> 上海电信</label>
                                            <label class="checkbox a_checkbox"><input type="checkbox"/> 上海电信</label>
                                            <label class="checkbox a_checkbox"><input type="checkbox"/> 上海电信</label>
                                            <label class="checkbox a_checkbox"><input type="checkbox"/> 上海电信</label>
                                            <label class="checkbox a_checkbox"><input type="checkbox"/> 上海电信</label>
                                            <label class="checkbox a_checkbox"><input type="checkbox"/> 上海电信</label>
                                            <label class="checkbox a_checkbox"><input type="checkbox"/> 上海电信</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="alarm_block">
                                    <div class="alarm_title">最大报警数设置</div>
                                    <div class="alarm_body">
                                        <div class="a_row">
                                            <div class="slider-widget-block">
                                                <div class="slider-widget-label">
                                                    报警消息：连续超过<span id="alert_max_count">5</span>次将不继续发送
                                                    <input type="hidden" name="alert_max_count" value="">
                                                </div>
                                                <div class="slider-widget-item">
                                                    <div class="slider-widget-range">0</div>
                                                    <div id="max-slider" class="slider-widget slider-warning"></div>
                                                    <div class="slider-widget-range">50</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="panel-footer a_panel_footer">
                                <a href="javascript:;" class="btn btn-blue js-alert-setting-modify">保存</a>
                            </div>
                        </div>
                        {{ Form::close() }}
                    </div>

                </div>
            </div>


        </div>

    </div>
</div>

<div id="site_modal" class="modal fade"></div>


@stop