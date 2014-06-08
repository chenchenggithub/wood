@extends('layouts.ajax_master')
@section('content')
<div class="modal-dialog" style="width:680px;">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h5 class="modal-title">监测点设置</h5>
        </div>
        <div class="modal-body">
            <div class="modal-panel-title">
                <span class="pull-left">状态：</span>
                <ul class="nav nav-pills">
                    <li class="active"><a href="javascript:void(0);" onclick="settingSelectMonitorList('all',1,this);">全部（100）</a></li>
                    <li><a href="javascript:void(0);" onclick="settingSelectMonitorList('unselected',1,this);">可选（70）</a></li>
                    <li><a href="javascript:void(0);" onclick="settingSelectMonitorList('selected',1,this);">已购买（30）</a></li>
                </ul>
            </div>
            <p class="monitor_des">本次购买监测点数 <span class="text-red" id="setting_add_monitor_num">0</span> 个，总值 <span class="text-red" id="setting_add_yundou_num">0</span> 云豆</p>
            <div class="modal-panel-body" id="setting_all_monitor_id">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th width="30px">&nbsp;</th><th>名称</th><th>区域</th><th>状态</th><th>云豆数</th>
                    </tr>
                    </thead>
                    <tbody id="load_setting_all_monitor_list">
                    <tr>
                        <td>
                            <input type="checkbox" />
                        </td>
                        <td>上海电信</td><td>华北地区</td><td>已购买</td><td>1</td>
                    </tr>

                    </tbody>
                </table>
                <ul class="pagination pull-right" id="setting_all_monitor_page_list">

                </ul>
            </div>

            <div class="modal-panel-body" id="setting_selected_monitor_id">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th width="30px">&nbsp;</th><th>名称</th><th>区域</th><th>状态</th><th>云豆数</th>
                    </tr>
                    </thead>
                    <tbody id="load_setting_selected_monitor_list">
                    <tr>
                        <td>
                            <input type="checkbox" />
                        </td>
                        <td>上海电信</td><td>华北地区</td><td>已购买</td><td>1</td>
                    </tr>

                    </tbody>
                </table>
                <ul class="pagination pull-right" id="setting_selected_monitor_page_list">

                </ul>
            </div>

            <div class="modal-panel-body" id="setting_unselected_monitor_id">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th width="30px">&nbsp;</th><th>名称</th><th>区域</th><th>状态</th><th>云豆数</th>
                    </tr>
                    </thead>
                    <tbody id="load_setting_unselected_monitor_list">
                    <tr>
                        <td>
                            <input type="checkbox" />
                        </td>
                        <td>上海电信</td><td>华北地区</td><td>已购买</td><td>1</td>
                    </tr>

                    </tbody>
                </table>
                <ul class="pagination pull-right" id="setting_unselected_monitor_page_list">

                </ul>
            </div>

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-blue" data-dismiss="modal"  onclick="saveAddMonitor()">保存</button>
            <button type="button" class="btn" data-dismiss="modal">取消</button>
        </div>
    </div>
</div>
<input id="temp_add_monitor_id" type="hidden" value="" />
<script>
    //console.log({{$monitor}});
    var monitor = {{$monitor}};
    function settingSelectMonitorList(type,page,thisObj){
        if(typeof thisObj != 'undefined'){
            $(thisObj).parent().removeClass('active').addClass('active');
            $(thisObj).parent().siblings().removeClass('active');
        }

        if(type == 'all'){
            $("#setting_all_monitor_id").show();
            $("#setting_selected_monitor_id").hide();
            $("#setting_unselected_monitor_id").hide();
            loadSettingMonitorFunc(type,page);
        }else if(type == 'selected'){
            $("#setting_all_monitor_id").hide();
            $("#setting_selected_monitor_id").show();
            $("#setting_unselected_monitor_id").hide();
            loadSettingMonitorFunc(type,page);
        }else if(type == 'unselected'){
            $("#setting_all_monitor_id").hide();
            $("#setting_selected_monitor_id").hide();
            $("#setting_unselected_monitor_id").show();
            loadSettingMonitorFunc(type,page);
        }
    }

    //加载已选择的监测点
    function loadSettingMonitorFunc(type,page){
       // var monitor = {{$monitor}};
        var page_num = {{$page_num}};
        if(type == 'all'){
            var total = tsb_count(monitor.all_monitor);
            var start = (page-1)*page_num+1;
            var end = page*page_num;
            if(end >total) end = total;
            var all_monitor_list = '';
            var count_num = 1;
            for(var i in monitor.all_monitor){
                if(count_num >= start && count_num<=end)
                    all_monitor_list += '<tr><td>&nbsp;</td><td>'+monitor.all_monitor[i][1]+'</td><td>'+monitor.all_monitor[i]['area_name']+'</td><td>'+monitor.all_monitor[i]['is_buy']+'</td><td>'+monitor.all_monitor[i][2]+'</td></tr>';
                count_num++;
            }
            $("#load_setting_all_monitor_list").html(all_monitor_list);
            var page_html = getSettingMonitorPageList(page,page_num,total,type);
            $("#setting_all_monitor_page_list").html(page_html);
        }

        if(type == 'selected'){
            var total = tsb_count(monitor.select_monitor);
            var start = (page-1)*page_num+1;
            var end = page*page_num;
            if(end >total) end = total;
            var selected_monitor_list = '';
            var count_num = 1;
            for(var i in monitor.select_monitor){
                if(count_num >= start && count_num<=end)
                    selected_monitor_list += '<tr><td><input type="checkbox" checked disabled /></td><td>'+monitor.select_monitor[i][1]+'</td><td>'+monitor.select_monitor[i]['area_name']+'</td><td>'+monitor.select_monitor[i]['is_buy']+'</td><td>'+monitor.select_monitor[i][2]+'</td></tr>';
                count_num++;
            }
            $("#load_setting_selected_monitor_list").html(selected_monitor_list);
            var page_html = getSettingMonitorPageList(page,page_num,total,type);
            $("#setting_selected_monitor_page_list").html(page_html);
        }

        if(type == 'unselected'){
            var total = tsb_count(monitor.unselected_monitor);
            var start = (page-1)*page_num+1;
            var end = page*page_num;
            if(end >total) end = total;
            var unselected_monitor_list = '';
            var count_num = 1;
            for(var i in monitor.unselected_monitor){
                if(count_num >= start && count_num<=end)
                    unselected_monitor_list += '<tr><td><input type="checkbox" value="'+i+'" onclick="changeAddMonitor(this)" /></td><td>'+monitor.unselected_monitor[i][1]+'</td><td>'+monitor.unselected_monitor[i]['area_name']+'</td><td>'+monitor.unselected_monitor[i]['is_buy']+'</td><td>'+monitor.unselected_monitor[i][2]+'</td></tr>';
                count_num++;
            }
            $("#load_setting_unselected_monitor_list").html(unselected_monitor_list);
            var page_html = getSettingMonitorPageList(page,page_num,total,type);
            $("#setting_unselected_monitor_page_list").html(page_html);
            checkIsExistsMonitor();
        }
    }

    //获取分页列表
    function getSettingMonitorPageList(page,page_num,total,type){
        var all_page = Math.ceil(total/page_num);
        var page_html = '';
        var page_head = page - 1;
        var page_last = page + 1;
        if(page_head <=0) page_head = 1;
        if(page_last >=all_page) page_last = all_page;
        page_html += '<li><a href="javascript:settingSelectMonitorList(\''+type+'\','+page_head+');">«</a></li>'
        for(var i=1;i<=all_page;i++){
            if(i == page){
                page_html += '<li class="active"><a href="javascript:settingSelectMonitorList(\''+type+'\','+i+');">'+i+'</a></li>';
            }else{
                page_html += '<li><a href="javascript:settingSelectMonitorList(\''+type+'\','+i+');">'+i+'</a></li>';
            }
        }
        page_html += '<li><a href="javascript:settingSelectMonitorList(\''+type+'\','+page_last+');">»</a></li>'
        return page_html;
    }

    //改变
    function changeAddMonitor(thisObj){
       var add_monitor = $("#temp_add_monitor_id").val();
        if($(thisObj).is(':checked')){
            add_monitor += $(thisObj).val()+',';
            $("#temp_add_monitor_id").val(add_monitor);
        }else{
            var add_monitor_arr = add_monitor.split(',');
            var new_add_monitor_arr = [];
            for(var i in add_monitor_arr){
                if(add_monitor_arr[i] !="" && add_monitor_arr[i] !=$(thisObj).val())
                    new_add_monitor_arr.push(add_monitor_arr[i]);
            }
            $("#temp_add_monitor_id").val(new_add_monitor_arr.join(',')+',');
        }

        var add_monitor_arr = $("#temp_add_monitor_id").val().split(',');
        var add_yundou_num = 0;
        var add_add_monitor_num = 0;
        for(var i in add_monitor_arr){
            if(add_monitor_arr[i] != ''){
                add_add_monitor_num++;
                add_yundou_num += monitor.unselected_monitor[add_monitor_arr[i]][2];
            }
        }
        $("#setting_add_monitor_num").html(add_add_monitor_num);
        $("#setting_add_yundou_num").html(add_yundou_num);
    }

    function checkIsExistsMonitor(){
        var add_monitor = $("#temp_add_monitor_id").val();
        var add_monitor_arr =  add_monitor.split(',');
        $("#load_setting_unselected_monitor_list").find('input').each(function(){
            for(var i in add_monitor_arr){
                if($(this).val() == add_monitor_arr[i]) {
                    $(this).attr('checked','checked');
                    break;
                }
            }
        });
    }

    //保存增加的监测点
    function saveAddMonitor(){
        $("#buyAddPurchaseFormId").find("input[name='add_monitor']").val($("#temp_add_monitor_id").val());
        var add_monitor_arr = $("#temp_add_monitor_id").val().split(',');
        var add_yundou_num = 0;
        var add_add_monitor_num = 0;
        for(var i in add_monitor_arr){
            if(add_monitor_arr[i] != ''){
                add_add_monitor_num++;
                add_yundou_num += monitor.unselected_monitor[add_monitor_arr[i]][2];
            }
        }
        var basic_yundou_num = 0;
        for(var i in monitor.select_monitor){
            if(monitor.select_monitor[i] != ''){
                basic_yundou_num += monitor.select_monitor[i][2];
            }
        }

        $("#add_monitor_count").html(add_add_monitor_num);
        $("#add_yundou_count").html(add_yundou_num);
        var all_monitor_count =  tsb_count(monitor.select_monitor) + add_add_monitor_num;
        var all_yundou_count = basic_yundou_num + add_yundou_num;
        $("#all_monitor_count").html(all_monitor_count);
        $("#all_yundou_count").html(all_yundou_count);
        calculate_package();//重新计算价格
    }
    //默认加载全部监测点
    settingSelectMonitorList('all',1);
</script>
@stop