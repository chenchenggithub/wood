/**
 * Created by neeke on 14-6-3.
 */
var service_config_setting = (function () {

    function config_init(cfg) {
        var frequency = 2;
        if (cfg.frequency) {
            frequency = cfg.frequency;
        } else {
            frequency = cfg.frequency_default;
        }

        $('#frequency-slider-label').html(frequency);
        $('input[name="frequency"]').val(frequency);

        TSB.slider('.slider-widget', {
            range: "min",
            value: frequency,
            min: 2,
            max: 30,
            slideFun: function (event, ui) {
                var sliderId = $(this).attr('data-label');
                $('#' + sliderId).text(ui.value);
                $('input[name="frequency"]').val(ui.value);
            }
        });

        if (cfg.monitor_list_default_count) {
            $('.js-data-monitor-count-default').html(cfg.monitor_list_default_count);
        }
        if (cfg.monitor_list_count) {
            $('.js-data-monitor-count-choose').html(cfg.monitor_list_count);
        }

        if (cfg.monitor_list) {

        }
    }

    function config_modify() {
        $(document).delegate('.js-service-setting-modify', 'click', function () {
            var data = $(this).closest('form').serialize();
            var api_modify = app_setting.api_service_setting_modify;
            T.restPost(api_modify, data,
                function (back) {
                    window.domain_id = back.data;
                    TSB.modalAlert({msg: '保存成功'});
                    setTimeout(function () {
                        $("#site_modal").modal('hide');
                    }, 1000);
                },
                function (back) {
                    TSB.modalAlert({status: 'danger', msg: back.msg});
                }
            )
        });
    }


    return {
        init: config_init,
        modify: config_modify
    };
})();