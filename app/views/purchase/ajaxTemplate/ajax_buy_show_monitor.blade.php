@extends('layouts.ajax_master')
@section('content')
<div class="modal-dialog" style="width:680px;">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h5 class="modal-title">监测点配置</h5>
        </div>
        <div class="modal-body">
            <p class="monitor_des">总的购买监测点数 <span class="text-red" id="select_monitor_num">{{$select_monitor_count}}</span> 个，总值 <span class="text-red" id="select_yundou_num">{{$yundou_count}}</span> 云豆</p>
            <div class="modal-panel-body">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>名称</th><th>区域</th><th>云豆数</th>
                    </tr>
                    </thead>
                    <tbody id="load_selected_monitor_list">

                    </tbody>
                </table>
                <ul class="pagination pull-right" id="selected_monitor_page_list_id">

                </ul>
            </div>
        </div>
    </div>
</div>
<script>
    //使该页面不缓存数据
    $('#show_monitor').on('hidden.bs.modal', function (e) {
        $(this).data('bs.modal','');
    });

    //加载已选择的监测点
    function loadShowMonitorFunc(page){
        var monitor = {{$monitor}};
        var page_num = {{$page_num}};
        var select_monitor = [];
        for(var i in monitor.select_monitor){
            select_monitor.push(i);
        }
        var add_monitor = $("#buyAddPurchaseFormId").find("input[name='add_monitor']").val().split(',');
        var new_add_monitor = [];
        for(var i=0;i< add_monitor.length;i++){
            if(add_monitor[i] != ''){
                new_add_monitor[i]= add_monitor[i];
            }
        }
        var all_select_monitor = select_monitor.concat(new_add_monitor);

        var total = all_select_monitor.length;
        var start = (page-1)*page_num+1;
        var end = page*page_num;
        if(end >total) end = total;
        var selected_monitor_list = '';
        var count_num = 1;
        var select_monitor_num =0;
        var select_yundou_num =0;
        for(var i in all_select_monitor){
            var index = all_select_monitor[i];
            if(index != ""){
                if(count_num >= start && count_num<=end)
                    selected_monitor_list += '<tr><td>'+monitor.all_monitor[index][1]+'</td><td>'+monitor.all_monitor[index]['area_name']+'</td><td>'+monitor.all_monitor[index][2]+'</td></tr>';
                count_num++;
            }
            select_monitor_num++;
            select_yundou_num += monitor.all_monitor[index][2];
        }

        $("#select_monitor_num").html(select_monitor_num);
        $("#select_yundou_num").html(select_yundou_num);
        $("#load_selected_monitor_list").html(selected_monitor_list);
        var page_html = getSelectedMonitorPageList(page,page_num,total);
        $("#selected_monitor_page_list_id").html(page_html);
    }
    //获取分页列表
    function getSelectedMonitorPageList(page,page_num,total){
        var all_page = Math.ceil(total/page_num);
        var page_html = '';
        var page_head = page - 1;
        var page_last = page + 1;
        if(page_head <=0) page_head = 1;
        if(page_last >=all_page) page_last = all_page;
        page_html += '<li><a href="javascript:loadShowMonitorFunc('+page_head+');">«</a></li>'
        for(var i=1;i<=all_page;i++){
            if(i == page){
                page_html += '<li class="active"><a href="javascript:loadShowMonitorFunc('+i+');">'+i+'</a></li>';
            }else{
                page_html += '<li><a href="javascript:loadShowMonitorFunc('+i+');">'+i+'</a></li>';
            }
        }
        page_html += '<li><a href="javascript:loadShowMonitorFunc('+page_last+');">»</a></li>'
        return page_html;
    }

    loadShowMonitorFunc(1);
</script>
@stop