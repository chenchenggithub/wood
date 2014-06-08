@extends('layouts.master')

@section('title')
网站监控
@stop

@section('app_css')
@stop

@section('app_js')
<!--<script src="/resource/js/project/domain_board.js?v=--><?php //echo ResourceSpall::getResourceVersion(); ?><!--"></script>-->
@stop


@section('content')

<div class="main">

    @include('project.breadcrumbs')

    <div class="tabbable tabs-left" style="padding-left: 10px;">
        <ul class="nav nav-tabs">
            @foreach(DomainSpall::processSiteBoardMenu($tab) as $key=>$menu)
                <li @if(array_key_exists('active',$menu)) class="active" @endif>
                    <a href="{{ $menu['url'].$domain_id }}" data-js="{{$key}}">{{ $menu['label'] }}</a>
                </li>
            @endforeach
        </ul>

        <div class="tab-content">
            <div class="tab-pane active">
                @include(DomainSpall::processSiteBoardTpl())
            </div>
        </div>
    </div>

</div>

@stop