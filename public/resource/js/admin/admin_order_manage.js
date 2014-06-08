var admin_order_manage = (function () {
    var load_order_list = function (thisObj) {
        $("#promo_strategy_id").find('.btn').removeClass('btn btn-primary');
        $(thisObj).addClass('btn btn-primary');
        T.ajaxLoad('/order_manage/ajax/load_order_list', 'placeholder', {}, function () {
        });
    }
    var load_order_detail = function (order_id,order_type) {
        $("#promo_strategy_id").find('.btn').removeClass('btn btn-primary');
        $('#promo_code_list_id').addClass('btn btn-primary');
        T.ajaxLoad('/order_manage/ajax/load_order_detail', 'placeholder', {order_id:order_id,order_type:order_type}, function () {
        });
    }

    var ajax_order_list_page = function(page){
        T.ajaxLoad('/order_manage/ajax/load_order_list?page='+page, 'placeholder', {}, function () {
        });
    }
    //Ajax提交确认订单支付
    var submit_order_confirm = function (order_id) {
        T.restPost('/order_manage/ajax/order_confirm', {order_id:order_id}, orderConfirmSuccess, orderConfirmError)
    }
    var orderConfirmSuccess = function (data) {
        alert('操作成功');
        window.location.href = '/order_manage';
    }
    var orderConfirmError = function (data) {
        alert(data.msg);
    }



    return {
        'load_order_list': load_order_list,
        'load_order_detail': load_order_detail,
        'submit_order_confirm':submit_order_confirm,
        'ajax_order_list_page':ajax_order_list_page
    };
})()