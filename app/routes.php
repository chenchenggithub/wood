<?php
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function () {
    return View::make('hello');
});
//用户激活
Route::get('/user_activate', 'User_UserController@UserActivate');
//用户登录
Route::get('/signin', 'User_UserController@showLogin');
Route::post('/signin', array('before' => 'csrf', 'uses' => 'User_UserController@disposeLogin'));
Route::group(array('before' => 'user'), function () {
    Route::get('/dashboard', 'User_UserController@Dashboard');
    Route::get('/app', 'User_UserController@Application');
    Route::get('/site', 'User_UserController@SiteMonitor');
    Route::get('/mobile', 'User_UserController@MobileTerminal');
    Route::get('/alert', 'User_UserController@Alert');
    Route::get('/report', 'User_UserController@Report');
    Route::get('/monitor', 'User_UserController@MonitorClient');

    /*********** 用户管理 ************/
    Route::get('/system', 'User_UserController@System');
    Route::get('/user/basic_info','User_UserController@UserBasicInfo');
    Route::get('/user/user_list','User_UserController@UserList');
    Route::get('/ajax/get_groups','User_UserController@AjaxGetGroups');
    Route::post('/ajax/create_group','User_UserController@AjaxCreateGroup');
    Route::post('/ajax/modify_group','User_UserController@AjaxModifyGroup');
    Route::post('/ajax/user/create','User_UserController@AjaxCreateUser');
    Route::post('/ajax/get_group_users','User_UserController@AjaxGetGroupUsers');
    Route::post('/ajax/user/modify_status','User_UserController@AjaxModifyUserStatus');
    Route::post('/ajax/user/modify_group','User_UserController@AjaxModifyUserGroup');

    /*********** 用户中心 ************/
    Route::get('/signin_out', 'User_UserCenterController@LoginOut');
    Route::get('/user/center','User_UserCenterController@UserCenterIndex');
    Route::post('/user/modify_info','User_UserCenterController@ModifyUserInfo');
    Route::post('/user/modify_pass','User_UserCenterController@ModifyPassword');
    Route::get('/ajax/user/new_email','User_UserCenterController@LoadModifyEmail');
    Route::post('/ajax/user/email_code','User_UserCenterController@SendEmailCode');
    Route::post('/ajax/user/modify_email','User_UserCenterController@ModifyEmail');

    Route::get('/user/user_log','User_UserController@UserLogs');

    /**
     * 创建项目相关
     */
    Route::get('/site/list', 'Project_SiteController@SiteList');
    Route::get('/site/board/overview/{domain_id}', 'Project_SiteController@showBoard');
    Route::get('/site/board/net/{domain_id}', 'Project_SiteController@showBoard');
    Route::get('/site/board/page/{domain_id}', 'Project_SiteController@showBoard');
    Route::get('/site/board/alert/{domain_id}', 'Project_SiteController@showBoard');
    Route::get('/site/board/report/{domain_id}', 'Project_SiteController@showBoard');
    Route::get('/site/board/setting/{domain_id}', 'Project_SiteController@showBoard');

    Route::get('/site/create', 'Project_SiteController@showDomainCreate');
    Route::get('/site/modify/{domain_id}', 'Project_SiteController@showDomainModify');
    Route::get('/api/site/{site_id}', 'Project_SiteController@apiGet');
    Route::post('/api/site/create', array('before' => 'project_site_filter', 'uses' => 'Project_SiteController@SiteCreateApi'));

    Route::get('/site/team/{domain_id}', 'Project_SiteController@ShowSiteTeam');

    Route::get('/ajax/service/setting/monitor/{app_id}/{target_type}/{target_id}/{service_type}','Project_ServiceController@ShowServiceSetting');
    Route::get('/ajax/service/setting/other/{app_id}/{target_type}/{target_id}/{service_type}','Project_ServiceController@ShowServiceSetting');

    Route::post('/api/service/setting/modify','Project_ServiceController@ServiceSettingModifyApi');

    Route::post('/api/service/site/modify', 'Project_ServiceController@ServiceSiteModifyApi');
    Route::get('/api/service/site/get', 'Project_ServiceController@SiteGetApi');
    Route::post('/api/service/page/modify', 'Project_ServiceController@ServicePageModifyApi');
    Route::get('/api/service/page/get', 'Project_ServiceController@pageGet');

    Route::post('/api/page/create','Project_PageController@PageCreateApi');
    Route::post('/api/page/modify','Project_PageController@PageModifyApi');
    Route::post('/api/page/status/modify','Project_PageController@PageStatusModifyApi');

    /**
     * 告警策略与通道
     */
    Route::get('/alert/showconfig/site/{domain_id}', 'Project_AlertController@AlertConfigShow');
    Route::get('/alert/showconfig/net/{domain_id}', 'Project_AlertController@AlertConfigShow');
    Route::get('/alert/showconfig/page/{domain_id}', 'Project_AlertController@AlertConfigShow');
    Route::post('/api/alert/setting/modify', 'Project_AlertController@AlertConfigModify');

    Route::get('/alert/showchannel/{domain_id}', 'Project_AlertController@AlertChannelShow');
    Route::post('/api/alert/channel/modify', 'Project_AlertController@AlertChannelModify');

    //========购买套餐相关的路由=========
    Route::get('/buy', 'BuyPackageController@showBuy');
    Route::get('/buy/ajax/load_setting_monitor', 'BuyPackageController@ajaxLoadSettingMonitor');
    Route::get('/buy/ajax/load_show_monitor', 'BuyPackageController@ajaxLoadShowMonitor');
    Route::get('/orderSettlement/{type}/{order_id}', 'OrderSettlementController@SettlementInterface'); //订单结算
    Route::get('/order/history', 'OrderController@ShowOrderHistory');
    Route::post('/buy/get_package_price', 'BuyPackageController@ajaxGetPackagePrice');
    Route::post('/buy/get_renewals_price', 'BuyPackageController@AjaxGetRenewalsPrice');
    Route::get('/buy/ajax/dispose_add_purchase', array('before'=>array('csrf'),'uses'=>'OrderController@ajaxDisposeAddPurchase'));//处理增购并生成订单详情页
    Route::get('/buy/ajax/dispose_renewals', array('before'=>array('csrf'),'uses'=>'OrderController@ajaxDisposeRenewals'));//处理续费并生成订单详情页
    Route::post('/buy/ajax/load_order_settlement', 'OrderController@ajaxLoadOrderSettlementPage');//展示订单结算页面
    Route::get('/invoice', 'InvoiceController@showInvoice');
    Route::post('/invoice/apply', 'InvoiceController@ajaxLoadApplyInvoice');
    Route::post('/invoice/records', 'InvoiceController@ajaxLoadInvoiceRecords');
    Route::post('/invoice/dispose_apply', array('before' => array('csrf', 'invoice_apply_filter'), 'uses' => 'InvoiceController@disposeInvoiceApply'));
    Route::post('/invoice/calculate_order', 'InvoiceController@ajaxCalculateOrderSum');

});
Route::get('/signin', 'User_UserController@showLogin');
//申请
Route::get('/apply', 'User_UserRegisterController@showApply');
Route::post('/apply', array('before' => 'csrf', 'uses' => 'User_UserRegisterController@applyDispose'));

Route::get('/user/admin', 'User_UserAdminController@showBasicInfo');


/******* toushibao Admin root ******/
Route::group(array('domain' => 'admin.toushibao.com'), function () {
    Route::get('/login', 'Admin_AdminController@showLogin');
    Route::post('/login', array('before' => 'csrf', 'uses' => 'Admin_AdminController@loginDispose'));
    Route::get('/login_out', 'Admin_AdminController@loginOut');
    Route::group(array('before' => 'admin'), function () {
        Route::get('/admin_info','Admin_AdminController@getAdminInfo');
        Route::get('/user_list','Admin_AdminController@getRegisterUser');
        Route::get('/ent_list','Admin_AdminController@getEntUser');
        Route::get('/promo_code','Admin_PromoCodeController@showPromoPage');
        Route::get('/order_manage','Admin_OrderManageController@showOrderPage'); //展示订单管理
        Route::get('/invoice_manage','Admin_InvoiceManageController@showInvoiceMangePage'); //展示发票管理
        /***** ajax请求 *****/
        Route::post('/ajax/get_register_user','Admin_AdminController@ajaxLoadRegisterUser');
        Route::post('/ajax/dispose_register','User_UserRegisterController@ajaxDisposeRegister');
        Route::post('/order_manage/ajax/load_order_list','Admin_OrderManageController@ajaxShowOrderList'); //展示订单列表
        Route::post('/order_manage/ajax/load_order_detail','Admin_OrderManageController@ajaxShowOrderDetail'); //展示订单详情
        Route::post('/order_manage/ajax/order_confirm','Admin_OrderManageController@ajaxOrderConfirm'); //订单确认支付

        Route::post('/ajax/load_promo_code','Admin_PromoCodeController@ajaxPromoCodeList'); //展示优惠码列表
        Route::post('/ajax/load_promo_strategy','Admin_PromoCodeController@ajaxPromoStrategyList'); //展示优惠策略列表
        Route::post('/ajax/load_create_strategy','Admin_PromoCodeController@ajaxCreateStrategy'); //展示优惠策略创建页面
        Route::post('/ajax/load_update_strategy','Admin_PromoCodeController@ajaxUpdateStrategy'); //展示优惠策略修改页面
        Route::post('/ajax/create_promo_code','Admin_PromoCodeController@ajaxCreatePromoCode'); //生成优惠码
        Route::post('/promo_code/dispose_promo_strategy',array('before'=>array('promo_strategy_filter'),'uses'=>'Admin_PromoCodeController@ajaxCreatePromoStrategy')); //处理创建优惠策略
        Route::post('/promo_code/dispose_promo_strategy_update',array('before'=>array('promo_strategy_filter'),'uses'=>'Admin_PromoCodeController@ajaxUpdatePromoStrategy'));
        Route::post('/invoice_manage/ajax/load_invoice_list','Admin_InvoiceManageController@ajaxInvoiceList');
        Route::post('/invoice_manage/ajax/invoice_audit','Admin_InvoiceManageController@ajaxLoadInvoiceAuditPage');//发票申请审核页面
        Route::post('/invoice_manage/ajax/invoice_invoicing','Admin_InvoiceManageController@ajaxLoadInvoiceInvocingPage');//开发票处理页面
        Route::post('/invoice_manage/ajax/invoice_mail','Admin_InvoiceManageController@ajaxLoadInvoiceMailPage');//发票邮寄页面
        Route::post('/invoice_manage/ajax/dispose_invoice_audit','Admin_InvoiceManageController@ajaxDisposeInvoiceAudit');//发票申请审核处理接口
        Route::post('/invoice_manage/ajax/dispose_invoice_invoicing','Admin_InvoiceManageController@ajaxDisposeInvoiceInvoicing');//开发票处理接口
        Route::post('/invoice_manage/ajax/dispose_invoice_mail','Admin_InvoiceManageController@ajaxDisposeInvoiceMail');//发票邮寄处理接口
    });


});








