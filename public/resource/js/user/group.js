/**
 * Created by dengchao on 14-5-28.
 */
var group = (function () {

    var load_groups = function () {
        var get_api = app_setting.ajax_load_groups;
        T.ajaxLoad(get_api, '__load_groups', '', function () {

            $('#__group_ul li').each(function(){
                var group_id = $(this).val();
                var group_name = $(this).attr('name');

                $(this).children('a').bind('click',function(){
                    $('#__group_ul li').removeClass('active');
                    $(this).parent('li').addClass('active');
                    load_group_user(group_id);
                    return false;
                });

                $(this).children('i').bind('click',function(){
                    $.li = $(this).parent('li');
                    $(this).hide();
                    $.li.children('a').hide();

                    var newHtml = '<div class="depart_control">';
                    newHtml += '<input class="form-control" type="text" name="new_name" id="new_name" placeholder="'+ group_name +'" />';
                    newHtml += '<a href="#" onclick="group.modifyGroup(' + group_id +')" class="btn btn-blue">保存</a>';
                    newHtml += '<a href="#" onclick="group.resetGroup(' + group_id +')" class="btn">取消</a>';
                    newHtml += '</div>';
                    $(newHtml).appendTo($.li);
                    return false;
                });
            });

            $('#__add_btn').bind('click',function(){
                $('.depart_control').show();
                $('#__add_btn').hide();

                $('#__submit_btn').bind('click',function(){
                    add_group();
                });

                $('#__reset_btn').bind('click',function(){
                    $('.depart_control').hide();
                    $('#__add_btn').show();
                    $('#__submit_btn').unbind('click');
                });
                return false;
            });

            $('#__group_ul li:eq(0)').children('a').click();
        });
    };

    var add_group = function () {
        var name = $('#group_name').val();
        if (!name || name == '') return false;

        var get_api = app_setting.ajax_create_group;
        var postData = {};
        postData.group_name = name;

        T.restPost(get_api, postData,
            function () {
                load_groups();
            },
            function (black) {
                T.alert(black.message);
            });
    };

    var modify_group = function (group_id) {
        if(!group_id) return false;
        var name = $('#new_name').val();
        if(!name || name =='') return false;
        var get_api = app_setting.ajax_modify_group;
        var postData = {};
        postData.group_name = name;
        postData.group_id = group_id;
        T.restPost(get_api,postData,function(){
            load_groups();
        },function(black){
            T.alert(black.message);
        });
        return false;
    };

    var reset_modify = function (group_id)
    {
        $.li = $('#__group_ul li[value='+ group_id +']');
        $.li.children('a').show();
        $.li.children('i').css('display','');
        $.li.children('div').remove();
        return false;
    };

    var del_group = function () {

    };

    var load_group_user = function (group_id,page) {
        if(!group_id) return false;
        if (!page) page = 1;

        var get_api = app_setting.ajax_load_group_users;
        var postData = {};
        postData.group_id = group_id;
        postData.page = page;

        T.ajaxLoad(get_api,'__load_group_users',postData,function(){
            $('#__select_group').val(group_id);

            $('#__role_ul li').bind('click',function(){
                $('#__role_ul li').removeClass('active');
                $(this).addClass('active');
                $('#__select_role').val($(this).val());
                return false;
            });

            $('.pagination a').each(function () {
                var href = $(this).attr('href');
                var arr = href.split('?page=');
                var load_page = arr[1];
                $(this).attr('href', '').bind('click', function () {
                    load_group_user(group_id,load_page);
                    return false;
                })
            });

            $('#__add_user').bind('click',function(){
               add_group_user();return false;
            });

            /********绑定拖拽事件********/
            $('img',$('#__users_div')).draggable({
                    cancel: "a.ui-icon",
                    revert: "invalid",
                    containment: "document",
                    helper: "clone",
                    cursor: "move"
            });
            $('#__group_ul li').droppable({
                accept: "#__users_div img",
                activeClass: "ui-state-highlight",
                drop: function(event,ui){
                    var group_id = $(this).val();
                    var user_id = ui.draggable.attr('value');
                    if(!group_id || !user_id) return false;
                    var get_api = app_setting.ajax_modify_user_group;
                    var postData = {};
                    postData.user_id = user_id;
                    postData.group_id = group_id;
                    T.restPost(get_api,postData,function(){
                        var num = parseInt($('#__user_num_' + group_id).html());
                        $('#__user_num_' + group_id).html(num + 1);

                        var old_group = $('#__select_group').val();
                        var old_num = parseInt($('#__user_num_' + old_group).html());
                        $('#__user_num_' + old_group).html(old_num - 1);

                        $('#__user_'+user_id).remove();
                    },function(black){
                        T.alert(black.message);
                    });
                }
            });
            /********绑定拖拽事件结束********/
        });
    };

    var add_group_user = function(){
        var group_id = $('#__select_group').val();
        var role_id = $('#__select_role').val();
        var user_email = $('#user_email').val();
        if(!user_email){T.alert('请填写email'); return false;}
        if(!group_id){T.alert('请选择分组'); return false;}
        if(!role_id){T.alert('请选择角色');return false;}

        var get_api = app_setting.ajax_add_user;
        var postData = {};
        postData.group_id = group_id;
        postData.role_id = role_id;
        postData.user_email = user_email;

        T.restPost(get_api,postData,function(){
            var num = parseInt($('#__user_num_' + group_id).html());
            $('#__user_num_' + group_id).html(num + 1);
            load_group_user(group_id);
        },function(black){
            T.alert(black.message);
        });
    };

    var modify_user_status = function(user_id,status)
    {
        if(!user_id || !status) return false;
        var get_api = app_setting.ajax_modify_user_status;
        var postData = {};
        postData.user_id = user_id;
        postData.user_status = status;
        T.restPost(get_api,postData,function(){
            var group_id = $('#__select_group').val();
            load_group_user(group_id);
        },function(black){
            T.alert(black.message);
        });
    };

    return {
        'loadGroups': load_groups,
        'addGroup': add_group,
        'modifyGroup': modify_group,
        'resetGroup': reset_modify,
        'delGroup': del_group,
        'loadGroupUser': load_group_user,
        'addGroupUser' : add_group_user,
        'modifyUserStatus':modify_user_status
    }

})();