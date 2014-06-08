/**
 * Created by neeke on 14-5-15.
 */
var app_enum = (function () {

    return {
        'service_status_normal': 1,
        'service_status_offline': 0,
        'page_status_normal': 1,
        'page_status_offline': 0,
        'alert_config_status_normal':1,
        'alert_config_status_offline':2,
        'alert_config_status_stop':3
    };
})();

var app_setting = (function () {

    return {
        'api_project_app_create': '/api/app/create',
        'api_project_app_update': '/api/app/update',
        'api_project_app_get': '/api/app/get',
        'api_project_app_list': '/api/app/list',

        'api_project_site_create': '/api/site/create',
        'api_project_site_update': '/api/site/update',
        'api_project_site_get': '/api/site/get',
        'api_project_site_list': '/api/site/list',

        'api_project_page_create': '/api/page/create',
        'api_project_page_modify': '/api/page/modify',
        'api_project_page_status_modify': '/api/page/status/modify',
        'api_project_page_get': '/api/page/get',
        'api_project_page_list': '/api/page/list',

        'api_service_site_get': '/api/service/site/get',
        'api_service_site_modify': '/api/service/site/modify',

        'api_service_page_get': '/api/service/page/get',
        'api_service_page_modify': '/api/service/page/modify',

        'api_monitor_list_load': '/api/service/monitor/list',
        'api_service_setting_modify': '/api/service/setting/modify',

        'api_alert_setting_get': '/api/alert/setting/get',
        'api_alert_setting_modify': '/api/alert/setting/modify',

        /****** admin ******/
        'ajax_load_register_user': '/ajax/get_register_user',
        'ajax_dispose_register': '/ajax/dispose_register',

        /***** group ******/
        'ajax_load_groups': '/ajax/get_groups',
        'ajax_create_group': '/ajax/create_group',
        'ajax_modify_group': '/ajax/modify_group',
        'ajax_load_group_users': '/ajax/get_group_users',
        'ajax_add_user': '/ajax/user/create',
        'ajax_modify_user_status': '/ajax/user/modify_status',
        'ajax_modify_user_group': '/ajax/user/modify_group',

        /****** user center ******/
        'ajax_load_modify_email': '/ajax/user/new_email',
        'ajax_send_email_code': '/ajax/user/email_code',
        'ajax_modify_email': '/ajax/user/modify_email'

    };

})();

