var admin_promo = (function () {
    var load_promo_list = function (thisObj) {
        $("#promo_strategy_id").find('.btn').removeClass('btn btn-primary');
        $(thisObj).addClass('btn btn-primary');
        T.ajaxLoad('/ajax/load_promo_code?page=1', 'placeholder', {}, function () {
        });
    }
    var load_pormo_strategy = function (thisObj) {
        $("#promo_strategy_id").find('.btn').removeClass('btn btn-primary');
        $(thisObj).addClass('btn btn-primary');
        T.ajaxLoad('/ajax/load_promo_strategy?page=1', 'placeholder', {}, function () {
        });
    }
    var load_create_strategy = function (thisObj) {
        $("#promo_strategy_id").find('.btn').removeClass('btn btn-primary');
        $(thisObj).addClass('btn btn-primary');
        T.ajaxLoad('/ajax/load_create_strategy', 'placeholder', {}, function () {
        });
    }

    //优惠策略列表的分页
    var strategy_list_page = function(page){
        T.ajaxLoad('/ajax/load_promo_strategy?page='+page, 'placeholder', {}, function () {
        });
    }

    //优惠码列表的分页
    var promo_code_list_page = function(page){
        T.ajaxLoad('/ajax/load_promo_code?page='+page, 'placeholder', {}, function () {
        });
    }

    //Ajax提交优惠策略创建数据
    var submit_promo_strategy = function (submit_data) {
        T.restPost('/promo_code/dispose_promo_strategy', submit_data, promoStrategySuccess, promoStrategyError)
    }
    var promoStrategySuccess = function (data) {
        window.location.href = '/promo_code';
    }
    var promoStrategyError = function (data) {
        alert(data.msg);
    }

    //Ajax创建生成优惠码
    var create_promo_code = function (strategy_id) {
        T.restPost('/ajax/create_promo_code', {strategy_id:strategy_id}, createPromoCodeSuccess, createPromoCodeError);
    }
    var createPromoCodeSuccess = function(){
        $("#promo_strategy_id").find('.btn').removeClass('btn btn-primary');
        $("#promo_code_list_id").addClass('btn btn-primary');
        T.ajaxLoad('/ajax/load_promo_code', 'placeholder', {}, function () {
        });
    }

    var createPromoCodeError = function(data){
        alert(data.msg);
    }

    //Ajax方式修改优惠策略
    var update_promo_strategy = function (strategy_id) {
        $("#promo_strategy_id").find('.btn').removeClass('btn btn-primary');
        $("#create_strategy_id").addClass('btn btn-primary');
        T.ajaxLoad('/ajax/load_update_strategy', 'placeholder', {strategy_id:strategy_id}, function () {
        });
    }

    //Ajax提交优惠策略创建数据
    var submit_promo_strategy_update = function (submit_data) {
        T.restPost('/promo_code/dispose_promo_strategy_update', submit_data, promoStrategyUpdateSuccess, promoStrategyUpdateError)
    }
    var promoStrategyUpdateSuccess = function (data) {
        window.location.href = '/promo_code';
    }
    var promoStrategyUpdateError = function (data) {
        alert(data.msg);
    }

    return {
        'load_promo_list': load_promo_list,
        'load_pormo_strategy': load_pormo_strategy,
        'load_create_strategy': load_create_strategy,
        'submit_promo_strategy': submit_promo_strategy,
        'create_promo_code': create_promo_code,
        'update_promo_strategy':update_promo_strategy,
        'submit_promo_strategy_update':submit_promo_strategy_update,
        'strategy_list_page':strategy_list_page,
        'promo_code_list_page':promo_code_list_page
    };
})()