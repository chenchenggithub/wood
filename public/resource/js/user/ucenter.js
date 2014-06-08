/**
 * Created by dengchao on 14-6-4.
 */
var ucenter = (function(){

    var load_ucenter = function(){
        $('#myCenter').modal({
            remote:"/user/center",
            keyboard:false,
            backdrop:"static"
        });
        return false;
    };

    var load_user_info = function()
    {

    }

    var load_modify_email = function()
    {
        var get_api = app_setting.ajax_load_modify_email;
        T.ajaxLoad(get_api,'__ucenter_layout','',function(){
            $('#__sub_step1').click(function(){
                var new_email = $('#inputNewEmail').val();
                if(!new_email) return false;
                $('#__form_step1').hide();
                $('#__form_step2').show();
                $('#__step_ul li').removeClass('active');
                $('#__step_ul li:eq(1)').addClass('active');
                $('#__email_step2').html($('#inputNewEmail').val());
                //获取验证码
                $('#__btn_send_code').click(function(){
                    var get_api = app_setting.ajax_send_email_code;
                    var postData = {};
                    postData.new_email = new_email;
                    T.restPost(get_api,postData,function(){
                        var html = "验证码已成功发送到您的邮箱，请您在24小时内完成验证。";
                        $('#__send_result').show().children('.alert').addClass('alert-success').html(html);
                    },function(black){
                        T.alert(black.msg);
                    });
                });
                //完成验证
                $('#__sub_step2').click(function(){
                    var email_code = $('#inputEmailCode').val();
                    if(!email_code) return false;
                    var get_api = app_setting.ajax_modify_email;
                    var postData = {};
                    postData.new_email = new_email;
                    postData.email_code = email_code;
                    T.restPost(get_api,postData,function(){
                        $('#__form_step2').hide();
                        $('#__form_step3').show();
                        $('#__sub_step3').click(function(){
                            load_ucenter();
                        });
                    },function(black){
                        T.alert(black.msg);
                    });
                });
            });
            return false;
        })
    };

    return {
        loadUcenter : load_ucenter,
        loadModifyEmail : load_modify_email
    }
})();
