/**
 * Created by neeke on 14-6-5.
 */
var alert_config_setting = (function () {

    function config_init(cfg) {
        var js_alert_type_array = $('.js-alert-type-status');
        $.each(js_alert_type_array,function(key,oThis){
            var oForm = oThis.form;
            var status = oForm.elements.status.value;

            if (status == app_enum.alert_config_status_normal) {

            } else {
                $(oThis).click();
            }

        });

        TSB.slider('#pi-slider', {
            range: true,
            min: 0,
            max: 100,
            values: [ 30, 60 ],
            slideFun: function (event, ui) {
                $('#afterwards_warning_bar').text(ui.values[1]);
                $('input[name="afterwards_warning_bar"]').val(ui.values[1]);

                $('#afterwards_error_bar').text(ui.values[0]);
                $('input[name="afterwards_error_bar"]').val(ui.values[0]);
            }
        });
        TSB.slider('#rate-slider', {
            range: true,
            min: 0,
            max: 100,
            values: [ 30, 60 ],
            slideFun: function (event, ui) {
                $('#trend_warning_bar').text(ui.values[0]);
                $('input[name="trend_warning_bar"]').val(ui.values[0]);

                $('#trend_error_bar').text(ui.values[1]);
                $('input[name="trend_error_bar"]').val(ui.values[1]);
            }
        });
        TSB.slider('#max-slider', {
            range: 'min',
            value: 5,
            min: 0,
            max: 100,
            slideFun: function (event, ui) {
                $('#alert_max_count').text(ui.value);
                $('input[name="alert_max_count"]').val(ui.values);
            }
        });
    }

    function switchHandle() {
        $('#mySwitch').on('switch-change', function (e, data) {
            var $el = $(data.el)
                , value = data.value;
            console.log(e, $el, value);
        });
    }

    function config_modify() {
        var api_modify = app_setting.api_alert_setting_modify;


        $(".js-alert-setting-modify").click(function () {
            var data = $(this).closest('form').serialize();
            T.restPost(api_modify, data,
                function (back) {
                    TSB.modalAlert({msg: '处理成功'});
                },
                function (back) {
                    TSB.modalAlert({status: 'danger', msg: back.msg});
                }
            );
        });

    }

    return {
        init: config_init,
        modify: config_modify
    };

})();