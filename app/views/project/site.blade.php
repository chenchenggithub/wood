@extends('layouts.master')

@section('title')
网站创建
@stop

@section('app_css')
<link rel="stylesheet" href="/resource/css/site/create.css?v=<?php echo ResourceSpall::getResourceVersion(); ?>">
@stop

@section('app_js')
<script src="/resource/js/project/domain.js?v=<?php echo ResourceSpall::getResourceVersion(); ?>"></script>
<script src="/resource/js/project/service.js?v=<?php echo ResourceSpall::getResourceVersion(); ?>"></script>
<script src="/resource/js/project/page.js?v=<?php echo ResourceSpall::getResourceVersion(); ?>"></script>
<script src="/resource/js/project/service_config_setting.js?v=<?php echo ResourceSpall::getResourceVersion(); ?>"></script>
@stop

@section('content')

<div class="main">
    <div class="main-title">网站监控</div>
    <div class="main-body">
        @include('project.site_menu')
        <div class="tab-content">
            <div class="tab-pane active" id="base-pane">
                <div class="panel">
                    {{ Form::open()}}
                    <div class="panel-heading">网站信息</div>
                    <div class="panel-body">
                        <div class="form-base">
                            <div class="form-group">
                                <label for="" class="control-label">名称：</label>

                                <div class="controls">
                                    <input type="text" name="site_name" class="form-control" id="site_name"
                                           placeholder="未命名网站监控项目" request autofocus>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="control-label">域名：</label>

                                <div class="controls">
                                    <input type="text" name="site_domain" class="form-control request" id="site_domain"
                                           placeholder="www.jiankongbao.com">

                                    <div class="form-hint">提示：比如www.jiankongbao.com</div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="controls">
                                    <a href="javascript:;" class="btn btn-blue btn-submit"
                                       id="project_site_modify">保存</a>
                                    <a href="javascript:;" class="btn btn-cancel">取消</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
                @if (isset($baseInfo))
                <div class="panel">
                    <div class="panel-heading" data-toggle="collapse" href="#site-monitor">
                        网络监控
                        <span class="fa fa-chevron-down pull-right"></span>
                    </div>
                    <div class="panel-body collapse in" id="site-monitor">
                        <div class="row">
                            @foreach(ServiceTypeEnum::getTypeForDomain() as $type => $typeInfo)
                            <div class="col-2 js-site-modify" data-service-type="{{ $type }}">
                                <div class="m_type">
                                    <div class="m_type_control">
                                        @if (in_array(ServiceTypeEnum::TYPE_SETTING_MONITOR_KEY,$typeInfo))
                                        <a href="<?php echo DomainSpall::processSettingMonitorUrl($baseInfo->app_id,ServiceSchedulerConfigExtEnum::TARGET_TYPE_DOMAIN,$baseInfo->domain_id,$type);?>" data-toggle="modal" data-target="#site_modal"><i class="location-icon"></i></a>
                                        @endif

                                        @if (in_array(ServiceTypeEnum::TYPE_SETTING_OTHER_KEY,$typeInfo))
                                        <a href="<?php echo DomainSpall::processSettingOtherUrl($baseInfo->app_id,ServiceSchedulerConfigExtEnum::TARGET_TYPE_DOMAIN,$baseInfo->domain_id,$type);?>" data-toggle="modal" data-target="#site_modal"><i class="fa fa-gear"></i></a>
                                        @endif
                                    </div>
                                    <h1>{{ $typeInfo[ServiceTypeEnum::TYPE_LABEL_KEY] }}</h1>

                                    <p>1分钟</p>
                                    <input type="checkbox" name="switch-checkbox"
                                           data-on-color="blue" data-on-text="&nbsp;" data-off-text="&nbsp;"
                                        <?php if (isset($service_status) && array_key_exists($type, $service_status) && $service_status[$type]->status == ServiceTypeEnum::TYPE_STATUS_NORMAL) echo 'checked'; ?>>
                                </div>
                            </div>
                            <div class="setting_box_{{$type}}" style="display: none"></div>
                            @endforeach

                        </div>
                    </div>
                </div>

                <div class="panel">
                    <div class="panel-heading" data-toggle="collapse" href="#page-monitor">
                        页面监控
                        <span class="fa fa-chevron-down pull-right"></span>
                    </div>
                    <div class="panel-body collapse in" id="page-monitor">
                        <div class="page_title">
                            <span class="btn btn-default"><i class="location-icon"></i>监测点&频率</span>
                            <span class="btn btn-default js-page-add"><i class="fa fa-plus"></i>新建</span>
                        </div>
                        <table class="table table-hover table-striped">
                            <thead>
                            <tr>
                                <th width="5%">序号</th>
                                <th class="text-left" width="50%">页面URL</th>
                                <th width="15%">可靠性监控</th>
                                <th width="15%">页面性能监控</th>
                                <th width="15%">&nbsp;</th>
                            </tr>
                            </thead>
                            <tbody id="domain_pages">
                            <tr id="js-page-tpl" style="display: none;">
                                <td>!new </td>
                                <td class="text-left">
                                    <input type="text" name="" id="" class="form-control edit-url js-data-page-url"/>
                                    <span class="fa fa-check-circle js-page-modify-result" style="display: none"></span>
                                </td>
                                <td><input type="checkbox" name="switch-checkbox" data-on-color="blue"
                                           data-on-text="&nbsp;" data-off-text="&nbsp;" checked></td>
                                <td><input type="checkbox" name="switch-checkbox" data-on-color="blue"
                                           data-on-text="&nbsp;" data-off-text="&nbsp;" checked></td>
                                <td>
                                    <i class="fa fa-gear js-page-setting"></i>
                                    <i class="fa fa-times js-page-remove"></i>
                                </td>
                            </tr>

                            @if (isset($page_list))
                            @foreach($page_list as $page_info)
                            <tr class="js-site-modify" data-page-id="{{$page_info->page_id}}">
                                <td>1</td>
                                <td class="text-left">{{$page_info->page_url}}</td>
                                <td data-service-type="<?php echo ServiceTypeEnum::TYPE_HTTP; ?>">
                                    <input type="checkbox" name="switch-checkbox" data-on-color="blue" data-on-text="&nbsp;" data-off-text="&nbsp;" checked>
                                </td>
                                <td data-service-type="<?php echo ServiceTypeEnum::TYPE_SITE; ?>">
                                    <input type="checkbox" name="switch-checkbox" data-on-color="blue" data-on-text="&nbsp;" data-off-text="&nbsp;" checked>
                                </td>
                                <td>
                                    <i class="fa fa-gear js-page-setting"></i>
                                    <i class="fa fa-times js-page-remove"></i>
                                </td>
                            </tr>
                            @endforeach
                            @endif
                            </tbody>
                        </table>
                        <ul class="pagination pull-right">
                            <li><a href="#">&laquo;</a></li>
                            <li class="active"><a href="#">1</a></li>
                            <li><a href="#">2</a></li>
                            <li><a href="#">3</a></li>
                            <li><a href="#">4</a></li>
                            <li><a href="#">5</a></li>
                            <li><a href="#">&raquo;</a></li>
                        </ul>
                    </div>
                </div>
                @endif


            </div>
            <div class="tab-pane" id="team-pane"></div>
            <div class="tab-pane" id="alarm-pane"></div>
            <div class="tab-pane" id="alert-pane"></div>
            <div class="tab-pane" id="del-pane"></div>
        </div>
    </div>
</div>

<div id="site_modal" class="modal fade"></div>


<script>
    $(document).ready(function () {
        project_domain.modify();
        service.service_rs_modify();
        page.page_modify();

        service_config_setting.modify();

        $('#site_modal').on('hidden.bs.modal', function (e) {
            $(this).data('bs.modal','');
        })
    });
</script>

@stop