/**
 * Created by neeke on 14-5-30.
 */
var page = (function () {

    var page_get = function () {
        var get_api = app_setting.api_service_page_get;
    };

    var page_modify = function () {
        var domain_id = APPCONFIG.domain_id;
        var app_id = APPCONFIG.app_id;
        var modify_api = app_setting.api_project_page_update;

        $(".js-monitor-list-load").click(function () {

        });

        $(".js-page-add").click(function () {
            var add_tpl = $("#js-page-tpl").html();
            add_tpl = '<tr data-page-id="">' + add_tpl + '</tr>';
            $("#domain_pages tr:eq(0)").after(add_tpl);

        });

        $(document).delegate('.js-data-page-url', 'blur', function () {
            var this_dom = $(this);
            var page_url = this_dom.val();
            if (page_url.length < 1) return false;

            var post_data = {};
            post_data.domain_id = domain_id;
            post_data.app_id = app_id;
            post_data.page_url = page_url;
            T.restPost(app_setting.api_project_page_create,post_data,
                function(back) {
                    this_dom.closest('tr').attr('data-page-id',back.data);
                    this_dom.closest('td').find('span').show();

                    setTimeout(function(){
                        this_dom.closest('td').html(page_url);
                    },1000);
                },
                function(back) {
                    TSB.modalAlert({status: 'danger', msg: back.msg});
                    this_dom.addClass('input-error');
                }
            );
        });

        $(document).delegate('.js-page-remove', 'click', function () {
            var this_dom = $(this);
            var page_id = this_dom.closest('tr').attr('data-page-id');

            if (page_id && page_id > 0) {
                var api_status_modify = app_setting.api_project_page_status_modify;
                var modify_data = {};
                modify_data.status = app_enum.page_status_offline;
                modify_data.page_id = page_id;
                T.restPost(api_status_modify, modify_data,
                    function (back) {
                        TSB.modalAlert({msg: '处理成功'});
                        this_dom.closest('tr').remove();
                    },
                    function (back) {
                        TSB.modalAlert({status: 'danger', msg: back.msg});
                        return false;
                    }
                )
            }
        });

        $(document).delegate('.js-monitor-remove', 'click', function () {
            T.alert($(this).closest('div').attr('data-monitor-id'));
        });

        $(document).delegate('.js-page-setting', 'click', function () {
            var page_id = $(this).attr('data-page-id');

        });
    };


    return {
        page_modify: page_modify
    }

})();