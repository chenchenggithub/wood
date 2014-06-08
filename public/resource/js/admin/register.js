/**
 * Created by dengchao on 14-5-20.
 */
var register = (function () {
    var load_register_user = function () {
        $('#__register_status_div a').bind('click', function () {

            $('#__register_status_div a').removeClass('btn btn-primary');
            $(this).addClass('btn btn-primary');

            load_page_user();
        });
    };

    var load_page_user = function (page) {
        if (!page) page = 1;
        var get_api = app_setting.ajax_load_register_user;
        var status = $('#__register_status_div a[class*=btn]').attr('register_status');

        var postData = {};
        postData.register_status = status;
        postData.page = page;

        T.ajaxLoad(get_api, 'placeholder', postData, function () {
            $('.pagination a').each(function () {
                var href = $(this).attr('href');
                var arr = href.split('?page=');
                var load_page = arr[1];
                $(this).attr('href', '').bind('click', function () {
                    load_page_user(load_page);
                    return false;
                })
            });
        })
    };

    var dispose_register = function (type,id) {
        if(!type || !id) return false;
        var status = 0;
        if(type == 'pass') status = 2;
        if(type == 'fail') status = 3;

        var get_api = app_setting.ajax_dispose_register;

        var postData = {};
        postData.register_id = id;
        postData.register_status = status;

        T.restPost(get_api,postData,function(){
            console.log(id);
            $('#__user_' + id).hide();
            return false;
        },
        function(black){
            T.alert(black.msg);return false;
        })
    };

    return {
        'load_register_user': load_register_user,
        'dispose_register': dispose_register
    }

})();