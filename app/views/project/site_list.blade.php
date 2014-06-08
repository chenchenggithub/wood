@extends('layouts.master')

@section('title')
网站列表
@stop

@section('app_css')
@stop

@section('app_js')

@stop

@section('content')

<div class="main">

    @foreach($aSiteInfoList as $key=>$siteInfo)
    <li class="span5" style="padding-top: 20px">
        <div class="thumbnail">

            <div class="caption">
                <h3>
                    <a href="<?php echo DomainSpall::processSiteUrl($siteInfo->domain_id);?>">
                        {{ $siteInfo->site_name }}
                    </a>
                </h3>
                <p>显示网站监控的主要信息，包括性能指数，页面数量，告警消息数</p>
                <p>鼠标移动上显示操作，包括停用，启用和编辑</p>
            </div>

        </div>
    </li>

    @endforeach


</div>

@stop