<?php
/**
 * 用户模块权限控制
 * Created by PhpStorm.
 * User: dengchao
 * Date: 14-5-23
 * Time: 下午3:52
 */
class UserMenuEnum extends MenuEnum
{
    private static $TsbLeftMenu = array(); //当前获取的左导航

    private static $TsbUserMenus = array(
        'Dashboard'                   => array(
            self::TYPE   => self::MENU_TYPE_LEFT,
            self::PARENT => 0,
            self::LABEL  => '工作台',
            self::URL    => '/dashboard',
        ),
        'Application'                 => array(
            self::TYPE   => self::MENU_TYPE_LEFT,
            self::PARENT => 0,
            self::LABEL  => '应用',
            self::URL    => '/app',
        ),
        'SiteList'                    => array(
            self::TYPE   => self::MENU_TYPE_LEFT,
            self::PARENT => 0,
            self::LABEL  => '网站',
            self::URL    => '/site/list',
        ),
        'SiteCreateApi'               => array(
            self::TYPE  => self::MENU_TYPE_AJAX,
            self::LABEL => '创建网站监控',
        ),
        'SiteModifyApi'               => array(
            self::TYPE  => self::MENU_TYPE_AJAX,
            self::LABEL => '修改网站监控',
        ),
        'ServiceSiteModifyApi'        => array(
            self::TYPE  => self::MENU_TYPE_AJAX,
            self::LABEL => '启用暂停网站的服务',
        ),
        'ServicePageModifyApi'        => array(
            self::TYPE  => self::MENU_TYPE_AJAX,
            self::LABEL => '启用暂停页面的服务',
        ),
        'SiteGetApi'                  => array(
            self::TYPE  => self::MENU_TYPE_AJAX,
            self::LABEL => '取得网站监控基本信息',
        ),
        'PageCreateApi'               => array(
            self::TYPE  => self::MENU_TYPE_AJAX,
            self::LABEL => '创建page',
        ),
        'PageModifyApi'               => array(
            self::TYPE  => self::MENU_TYPE_AJAX,
            self::LABEL => '修改page',
        ),
        'PageStatusModifyApi'         => array(
            self::TYPE  => self::MENU_TYPE_AJAX,
            self::LABEL => '修改page状态',
        ),
        'ShowServiceSetting'          => array(
            self::TYPE  => self::MENU_TYPE_AJAX,
            self::LABEL => '加载不同服务的设置项',
        ),
        'ServiceSettingModifyApi'     => array(
            self::TYPE  => self::MENU_TYPE_AJAX,
            self::LABEL => '修改调度服务的配置项',
        ),
        'showBoard'                   => array(
            self::TYPE   => self::MENU_TYPE_LEFT,
            self::PARENT => 'SiteList',
            self::LABEL  => '网站概述',
            self::URL    => '/site/board',
        ),
        'MobileTerminal'              => array(
            self::TYPE   => self::MENU_TYPE_LEFT,
            self::PARENT => 0,
            self::LABEL  => '移动',
            self::URL    => '/mobile',
        ),
        'Alert'                       => array(
            self::TYPE   => self::MENU_TYPE_LEFT,
            self::PARENT => 0,
            self::LABEL  => '告警',
            self::URL    => '/alert',
        ),
        'Report'                      => array(
            self::TYPE   => self::MENU_TYPE_LEFT,
            self::PARENT => 0,
            self::LABEL  => '报告',
            self::URL    => '/report',
        ),
        'MonitorClient'               => array(
            self::TYPE   => self::MENU_TYPE_LEFT,
            self::PARENT => 0,
            self::LABEL  => '监控端',
            self::URL    => '/monitor',
        ),

        'System'                      => array(
            self::TYPE   => self::MENU_TYPE_LEFT,
            self::PARENT => 0,
            self::LABEL  => '系统',
            self::URL    => '/system',
        ),
        'UserBasicInfo'               => array(
            self::TYPE   => self::MENU_TYPE_LEFT,
            self::PARENT => 'System',
            self::LABEL  => '基本信息',
            self::URL    => '/user/basic_info',
            self::GROUP  => self::MENU_GROUP_ACCOUNT,
        ),
        'UserList'                    => array(
            self::TYPE   => self::MENU_TYPE_LEFT,
            self::PARENT => 'System',
            self::LABEL  => '用户管理',
            self::URL    => '/user/user_list',
            self::GROUP  => self::MENU_GROUP_ACCOUNT,
        ),
        'AjaxGetGroups'               => array(
            self::TYPE   => self::MENU_TYPE_AJAX,
            self::PARENT => 'UserList',
            self::URL    => '/ajax/get_groups',
        ),
        'AjaxCreateGroup'             => array(
            self::TYPE   => self::MENU_TYPE_AJAX,
            self::PARENT => 'UserList',
            self::URL    => '/ajax/create_group',
        ),
        'AjaxModifyGroup'             => array(
            self::TYPE   => self::MENU_TYPE_AJAX,
            self::PARENT => 'UserList',
            self::URL    => '/ajax/modify_group',
        ),
        'AjaxGetGroupUsers'           => array(
            self::TYPE   => self::MENU_TYPE_AJAX,
            self::PARENT => 'UserList',
            self::URL    => '/ajax/get_group_users',
        ),
        'AjaxCreateUser'              => array(
            self::TYPE   => self::MENU_TYPE_AJAX,
            self::PARENT => 'UserList',
            self::URL    => '/ajax/user/create',
        ),
        'AjaxModifyUserStatus'        => array(
            self::TYPE   => self::MENU_TYPE_AJAX,
            self::PARENT => 'UserList',
            self::URL    => '/ajax/user/modify_status',
        ),
        'AjaxModifyUserGroup'         => array(
            self::TYPE   => self::MENU_TYPE_AJAX,
            self::PARENT => 'UserList',
            self::URL    => '/ajax/user/modify_group',
        ),

        'UserLogs'                    => array(
            self::TYPE   => self::MENU_TYPE_LEFT,
            self::PARENT => 'System',
            self::LABEL  => '操作日志',
            self::URL    => '/user/user_log',
            self::GROUP  => self::MENU_GROUP_ACCOUNT,
        ),

        'UserCenterIndex'             => array(
            self::TYPE   => self::MENU_TYPE_BUTTON,
            self::PARENT => '0',
            self::LABEL  => '用户中心',
            self::URL    => '/user/center',
        ),
        'ModifyPassword'              => array(
            self::TYPE   => self::MENU_TYPE_AJAX,
            self::PARENT => 'UserCenterIndex',
            self::LABEL  => '修改密码',
            self::URL    => '/user/modify_pass',
        ),
        'ModifyUserInfo'              => array(
            self::TYPE   => self::MENU_TYPE_AJAX,
            self::PARENT => 'UserCenterIndex',
            self::LABEL  => '修改信息',
            self::URL    => '/user/modify_info',
        ),
        'LoadModifyEmail'             => array(
            self::TYPE   => self::MENU_TYPE_AJAX,
            self::PARENT => 'UserCenterIndex',
            self::LABEL  => '设置新的邮箱',
            self::URL    => '/ajax/user/new_email',
        ),
        'SendEmailCode'               => array(
            self::TYPE   => self::MENU_TYPE_AJAX,
            self::PARENT => 'UserCenterIndex',
            self::LABEL  => '发送邮箱验证码',
            self::URL    => '/ajax/user/email_code',
        ),
        'ModifyEmail'                 => array(
            self::TYPE   => self::MENU_TYPE_AJAX,
            self::PARENT => 'UserCenterIndex',
            self::LABEL  => '修改邮箱',
            self::URL    => '/ajax/user/modify_email',
        ),

        'LoginOut'                    => array(
            self::TYPE   => self::MENU_TYPE_BUTTON,
            self::PARENT => 0,
            self::LABEL  => '退出',
            self::URL    => '/signin_out',
        ),
        'showDomainCreate'            => array(
            self::TYPE   => self::MENU_TYPE_BUTTON,
            self::PARENT => 0,
            self::LABEL  => '网站创建',
            self::URL    => '/site/create',
        ),
        'showDomainModify'            => array(
            self::TYPE  => self::MENU_TYPE_BUTTON,
            self::LABEL => '网站创建',
            self::URL   => '/site/modify',
        ),
        'showBuy'                     => array(
            self::TYPE   => self::MENU_TYPE_LEFT,
            self::PARENT => 'System',
            self::LABEL  => '购买&续费',
            self::URL    => '/buy',
            self::GROUP  => self::MENU_GROUP_BUY,
        ),
        'ajaxDisposeAddPurchase'      => array(
            self::TYPE   => self::MENU_TYPE_BUTTON,
            self::PARENT => 0,
            self::LABEL  => '购买&增购订单详情',
            self::URL    => '/buy/ajax/dispose_add_purchase',
        ),
        'ajaxDisposeRenewals'         => array(
            self::TYPE   => self::MENU_TYPE_BUTTON,
            self::PARENT => 0,
            self::LABEL  => '续费订单详情',
            self::URL    => '/buy/ajax/dispose_renewals',
        ),
        'ajaxLoadOrderSettlementPage' => array(
            self::TYPE   => self::MENU_TYPE_BUTTON,
            self::PARENT => 0,
            self::LABEL  => '订单结算页面',
            self::URL    => '/buy/ajax/load_order_settlement',
        ),
        'SettlementInterface'         => array(
            self::TYPE   => self::MENU_TYPE_BUTTON,
            self::PARENT => 0,
            self::LABEL  => '结算接口',
            self::URL    => '/orderSettlement/{type}/{order_type}/{order_id}',
        ),
        'ShowOrderHistory'            => array(
            self::TYPE   => self::MENU_TYPE_LEFT,
            self::PARENT => 'System',
            self::LABEL  => '历史订单',
            self::URL    => '/order/history',
            self::GROUP  => self::MENU_GROUP_BUY,
        ),
        'ajaxGetPackagePrice'         => array(
            self::TYPE   => self::MENU_TYPE_AJAX,
            self::PARENT => 0,
            self::LABEL  => '获取价格',
            self::URL    => '/buy/get_package_price',
        ),
        'AjaxGetRenewalsPrice'        => array(
            self::TYPE   => self::MENU_TYPE_AJAX,
            self::PARENT => 0,
            self::LABEL  => '获取价格',
            self::URL    => '/buy/get_renewals_price',
        ),
        'showInvoice'                 => array(
            self::TYPE   => self::MENU_TYPE_LEFT,
            self::PARENT => 'System',
            self::LABEL  => '发票管理',
            self::URL    => '/invoice',
            self::GROUP  => self::MENU_GROUP_BUY,
        ),
        'ajaxLoadApplyInvoice'        => array(
            self::TYPE   => self::MENU_TYPE_AJAX,
            self::PARENT => 'System',
            self::LABEL  => '发票申请',
            self::URL    => '/invoice/apply',
            self::GROUP  => self::MENU_GROUP_BUY,
        ),
        'ajaxLoadInvoiceRecords'      => array(
            self::TYPE   => self::MENU_TYPE_AJAX,
            self::PARENT => 0,
            self::LABEL  => '发票记录',
            self::URL    => '/invoice/records',
        ),
        'disposeInvoiceApply'         => array(
            self::TYPE   => self::MENU_TYPE_BUTTON,
            self::PARENT => 'System',
            self::LABEL  => '发票记录',
            self::URL    => '/invoice/dispose_apply',
            self::GROUP  => self::MENU_GROUP_BUY,
        ),
        'ajaxCalculateOrderSum'       => array(
            self::TYPE   => self::MENU_TYPE_BUTTON,
            self::PARENT => 0,
            self::LABEL  => '计算发票价格',
            self::URL    => '/invoice/calculate_order',
        ),
        'AlertConfigShow'             => array(
            self::TYPE   => self::MENU_TYPE_TOP,
            self::PARENT => 0,
            self::LABEL  => '告警策略',
            self::URL    => '/alert/showconfig',
        ),
        'AlertConfigModify'           => array(
            self::TYPE   => self::MENU_TYPE_TOP,
            self::PARENT => 0,
            self::LABEL  => '更新告警策略',
            self::URL    => '/alert/modifyconfig',
        ),
        'AlertChannelShow'            => array(
            self::TYPE   => self::MENU_TYPE_TOP,
            self::PARENT => 0,
            self::LABEL  => '报警通道',
            self::URL    => '/alert/showchannel',
        ),
        'AlertChannelModify'          => array(
            self::TYPE   => self::MENU_TYPE_TOP,
            self::PARENT => 0,
            self::LABEL  => '更新报警通道',
            self::URL    => '/alert/modifychannel',
        ),
        'ajaxLoadSettingMonitor'      => array(
            self::TYPE   => self::MENU_TYPE_AJAX,
            self::PARENT => 0,
            self::LABEL  => '设置监测点',
            self::URL    => '/buy/ajax/load_setting_monitor',
        ),
        'ajaxLoadShowMonitor'         => array(
            self::TYPE   => self::MENU_TYPE_AJAX,
            self::PARENT => 0,
            self::LABEL  => '查看监测点',
            self::URL    => '/buy/ajax/load_show_monitor',
        ),
    );

    private static $userMenus = array(
        UserEnum::USER_ROLE_ADMIN    => array(
            'Dashboard',
            'Application',

            'SiteList',
            'SiteCreateApi',
            'SiteModifyApi',
            'ServiceSiteModifyApi',
            'ServicePageModifyApi',
            'SiteGetApi',
            'showBoard',
            'showDomainCreate',
            'showDomainModify',

            'ShowServiceSetting',
            'ServiceSettingModifyApi',

            'PageCreateApi',
            'PageModifyApi',
            'PageStatusModifyApi',

            'AlertConfigShow',
            'AlertConfigModify',
            'AlertChannelShow',
            'AlertChannelModify',

            'MobileTerminal',
            'Alert',
            'Report',
            'MonitorClient',

            'System',
            'UserBasicInfo',
            'UserList',
            'AjaxGetGroups',
            'AjaxCreateGroup',
            'AjaxModifyGroup',
            'AjaxGetGroupUsers',
            'AjaxCreateUser',
            'AjaxModifyUserStatus',
            'AjaxModifyUserGroup',
            'UserLogs',

            'showDomainModify',
            'showBuy',
            'ajaxLoadSettingMonitor',
            'ajaxLoadShowMonitor',
            'ajaxDisposeAddPurchase',
            'ajaxDisposeRenewals',
            'ajaxLoadOrderSettlementPage',
            'SettlementInterface',
            'ShowOrderHistory',
            'ajaxGetPackagePrice',
            'AjaxGetRenewalsPrice',
            'showInvoice',
            'ajaxLoadApplyInvoice',
            'ajaxLoadInvoiceRecords',
            'disposeInvoiceApply',
            'ajaxCalculateOrderSum',
            'LoginOut',
            'UserCenterIndex',
            'ModifyPassword',
            'ModifyUserInfo',
            'LoadModifyEmail',
            'SendEmailCode',
            'ModifyEmail',
        ),
        UserEnum::USER_ROLE_ADVANCED => array(
            'Dashboard',
            'Application',

            'SiteList',
            'SiteCreateApi',
            'SiteModifyApi',
            'SiteGetApi',
            'showBoard',

            'AlertConfigShow',
            'AlertConfigModify',
            'AlertChannelShow',
            'AlertChannelModify',

            'MobileTerminal',
            'Alert',
            'Report',
            'MonitorClient',

            'LoginOut',
        ),
        UserEnum::User_ROLE_READONLY => array(),
    );

    public static function getTsbMenus()
    {
        return self::$TsbUserMenus;
    }

    public static function getUserMenus($right)
    {
        return self::$userMenus[$right];
    }

    public static function getLeftMenu($right)
    {
        self::mkNewMenus(self::getTsbMenus());
        $rightMenus = self::getUserMenus($right);
        $aLeftMenus = array();
        foreach ($rightMenus as $menu) {
            if (self::$TsbUserMenus[$menu][self::TYPE] == self::MENU_TYPE_LEFT)
                $aLeftMenus[] = $menu;
        }
        self::$TsbLeftMenu = self::setMenus($aLeftMenus);
        return self::$TsbLeftMenu;
    }

    public static function getLeftLeafMenu()
    {
        $action = self::getCurrentAction();
        self::getRootParent($action);
        $aLeftMenu = self::$TsbLeftMenu[self::$rootParent];
        $aLeafMenu = array();
        if (array_key_exists(self::LEAF, $aLeftMenu)) {
            foreach ($aLeftMenu[self::LEAF] as $leaf) {
                $aLeafMenu[$leaf[self::GROUP]][] = $leaf;
            }
        }
        return $aLeafMenu;
    }

    public static function getRightMenu($right)
    {
        self::mkNewMenus(self::getTsbMenus());
        $rightMenus  = self::getUserMenus($right);
        $aRightMenus = array();
        foreach ($rightMenus as $menu) {
            if (self::$TsbUserMenus[$menu][self::TYPE] == self::MENU_TYPE_RIGHT)
                $aRightMenus[] = $menu;
        }
        return self::setMenus($aRightMenus);
    }

    public static function getTopMenu($right)
    {
        self::mkNewMenus(self::getTsbMenus());
        $rightMenus = self::getUserMenus($right);
        $aTopMenus  = array();
        foreach ($rightMenus as $menu) {
            if (self::$TsbUserMenus[$menu][self::TYPE] == self::MENU_TYPE_TOP)
                $aTopMenus[] = $menu;
        }
        return self::setMenus($aTopMenus);
    }

    public static function getButtonMenu($right)
    {
        self::mkNewMenus(self::getTsbMenus());
        $rightMenus = self::getUserMenus($right);
        $aButMenus  = array();
        foreach ($rightMenus as $menu) {
            if (self::$TsbUserMenus[$menu][self::TYPE] == self::MENU_TYPE_BUTTON)
                $aButMenus[] = $menu;
        }
        return self::setMenus($aButMenus);
    }
}