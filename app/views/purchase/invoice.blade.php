@extends('layouts.master')

@section('title')
  发票管理
@stop

@section('app_css')

@stop

@section('content')
<div class="main">
    <div class="main-title">系统</div>
    <div class="main-body">
        @include('layouts.tsb_left_leaf')
        <div class="main-container" id="main-container-id">
            <div style="float: left;width:900px;">
                <button onclick="invoice_records()" style="">申请记录</button>
                <button onclick="invoice_apply()" style="">发票申请</button>
                <div style="width:100%;height:3px;background: red;margin: 10px 0px;"></div>
                <div id="invoice_apply"></div>
            </div>
        </div>
    </div>
</div>
@stop

@section('app_js')
<script>
    function invoice_apply(){
        T.ajaxLoad('/invoice/apply','invoice_apply');
    }

    function invoice_records(){
        T.ajaxLoad('/invoice/records','invoice_apply');
    }
    invoice_records();
</script>
@stop