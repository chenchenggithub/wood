<!-- 监测点与监测频率设置 弹窗 -->
{{ Form::open()}}
<div class="modal-dialog">
    <div class="modal-content">
        <input type="hidden" name="app_id" value="{{$app_id}}">
        <input type="hidden" name="target_type" value="{{$target_type}}">
        <input type="hidden" name="target_id" value="{{$target_id}}">
        <input type="hidden" name="service_type" value="{{$service_type}}">
        <input type="hidden" name="frequency" value="">

        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h5 class="modal-title">监测点与监测频率设置</h5>
        </div>
        <div class="modal-body">
            <div class="modal-panel">
                <h5 class="modal-panel-title">监测频率设置</h5>

                <div class="modal-panel-body">
                    <div class="slider-widget-block">
                        <div class="slider-widget-label">
                            监测频率<span id="frequency-slider-label">2</span>分钟
                        </div>
                        <div class="slider-widget-item">
                            <div class="slider-widget-range">2</div>
                            <div data-label="frequency-slider-label" class="slider-widget slider-success"></div>
                            <div class="slider-widget-range">30</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-panel">
                <h5 class="modal-panel-title">监测点设置
                    <small>
                        （已购买监测点 <span class="text-red js-data-monitor-count-default">0</span> 个，
                        已选择 <span class="text-red js-data-monitor-count-choose">0</span> 个）
                    </small>
                </h5>
                <div class="modal-panel-body">
                    <?php echo DomainSpall::mkMonitorByAreaGroup($data['monitor_list_default'], $data['monitor_list']); ?>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-blue js-service-setting-modify">保存</button>
            <button type="button" class="btn" data-dismiss="modal">取消</button>
        </div>
    </div>
    <!-- /.modal-content -->
</div><!-- /.modal-dialog -->
{{ Form::close() }}
<script type="text/javascript">
    $(function () {
        service_config_setting.init(<?php echo json_encode($data);?>);
    });
</script>
	  
	  
	  