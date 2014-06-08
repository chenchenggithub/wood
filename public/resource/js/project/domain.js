/**
 * Created by neeke on 14-5-15.
 */

var domain_id = 0;

var project_domain = (function () {

    function init() {
        var api_get = app_setting.api_project_site_get;

        $('input[name="site_name"]').val(APPCONFIG.site_name);
        $('input[name="site_domain"]').val(APPCONFIG.site_domain);
    }

    function create(data) {
        var api_create = app_setting.api_project_site_create;
        T.restPost(api_create, data,
            function (back) {
                window.domain_id = back.data;
                TSB.modalAlert({msg: '处理成功'});
                setTimeout(function () {
                    window.location = '/site/modify/' + window.domain_id;
                }, 1000);
            },
            function (back) {
                TSB.modalAlert({status: 'danger', msg: back.msg});
            }
        )
    }

    function update(data) {
        var api_update = app_setting.api_project_site_update;
    }

    function modify() {
        $('#project_site_modify').click(function () {
            var data = $(this).closest('form').serialize();
            if (APPCONFIG.domain_id) {
                update(data);
            } else {
                create(data);
            }
        });
    }

    return {
        init: init,
        modify: modify
    }
})();

if (window.APPCONFIG) {
    project_domain.init();
}

