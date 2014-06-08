/**
 * Created by neeke on 14-5-15.
 */

var service = (function () {

    var page_get = function () {
        var get_api = app_setting.api_service_page_get;
    };

    var site_get = function () {
        var get_api = app_setting.api_service_site_get;
    };

    var service_rs_modify = function () {
        var modify_site_api = app_setting.api_service_site_modify;
        var modify_page_api = app_setting.api_service_page_modify;

        var modify_api;

        $(document).delegate('.bootstrap-switch', 'click', function () {
            var postData = {};
            var service_type;

            if ($(this).closest('tr') && $(this).closest('tr').length > 0) {
                modify_api = modify_page_api;
                service_type = $(this).closest('td').attr('data-service-type');

                var page_id = $(this).closest('tr').attr('data-page-id');
                postData.page_id = page_id;

            } else {
                modify_api = modify_site_api;
                service_type = $(this).closest('div').parent('div').parent('div').attr('data-service-type');
            }

            var status = $(this).find("input").is(":checked");

            postData.status = status ? app_enum.service_status_normal : app_enum.service_status_offline;
            postData.service_type = service_type;
            postData.domain_id = APPCONFIG.domain_id;

            T.restPost(modify_api, postData,
                function (back) {
                    TSB.modalAlert({msg: '处理成功'});
                },
                function (back) {
                    TSB.modalAlert({status: 'danger', msg: back.msg});
                    return false;
                }
            );
        });
    };


    return {
        page_get: page_get,
        site_get: site_get,
        service_rs_modify: service_rs_modify
    }

})();