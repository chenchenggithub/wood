<?php
/**
 * Created by PhpStorm.
 * User: dengchao
 * Date: 14-5-12
 * Time: 下午4:42
 */
class AdminMenuEnum extends MenuEnum
{
    //admin登录后设置session名
    const  ADMIN_SESSION_KEY = '__LOGIN_ADMIN_INFO';

    private static $admin_menus = array(

        'getAdminInfo'    => array(
            self::TYPE   => self::MENU_TYPE_LEFT,
            self::LABEL  => '我的信息',
            self::URL    => '/admin_info',
            self::PARENT => '0',
        ),
        'getRegisterUser' => array(
            self::TYPE   => self::MENU_TYPE_LEFT,
            self::LABEL  => '试用申请',
            self::URL    => '/user_list',
            self::PARENT => '0',
        ),
        'getEntUser'      => array(
            self::TYPE   => self::MENU_TYPE_LEFT,
            self::LABEL  => '企业用户',
            self::URL    => '/ent_list',
            self::PARENT => '0',
        ),
        'showPromoPage'   => array(
            self::TYPE   => self::MENU_TYPE_LEFT,
            self::LABEL  => '优惠码',
            self::URL    => '/promo_code',
            self::PARENT => '0',
        ),
        'showOrderPage'   => array(
            self::TYPE   => self::MENU_TYPE_LEFT,
            self::LABEL  => '订单管理',
            self::URL    => '/order_manage',
            self::PARENT => '0',
        ),
        'ajaxLoadRegisterUser' => array(
            self::TYPE   => self::MENU_TYPE_AJAX,
            self::LABEL  => '',
            self::URL    => '/ajax/get_register_user',
            self::PARENT => 'getRegisterUser',
        ),
        'ajaxDisposeRegister' => array(
            self::TYPE   => self::MENU_TYPE_AJAX,
            self::LABEL  => '',
            self::URL    => '/ajax/dispose_register',
            self::PARENT => 'getRegisterUser',
        ),
        'ajaxShowOrderList' => array(
            self::TYPE   => self::MENU_TYPE_AJAX,
            self::LABEL  => '',
            self::URL    => '/order_manage/ajax/load_order_list',
            self::PARENT => 'showOrderPage',
        ),
        'ajaxShowOrderDetail' => array(
            self::TYPE   => self::MENU_TYPE_AJAX,
            self::LABEL  => '',
            self::URL    => '/order_manage/ajax/load_order_detail',
            self::PARENT => 'showOrderPage',
        ),
        'ajaxOrderConfirm' => array(
            self::TYPE   => self::MENU_TYPE_AJAX,
            self::LABEL  => '',
            self::URL    => '/order_manage/ajax/order_confirm',
            self::PARENT => 'showOrderPage',
        ),
        'ajaxPromoCodeList' => array(
            self::TYPE   => self::MENU_TYPE_AJAX,
            self::LABEL  => '',
            self::URL    => '/ajax/load_promo_code',
            self::PARENT => 'showPromoPage',
        ),
        'ajaxPromoStrategyList' => array(
            self::TYPE   => self::MENU_TYPE_AJAX,
            self::LABEL  => '',
            self::URL    => '/ajax/load_promo_strategy',
            self::PARENT => 'showPromoPage',
        ),
        'ajaxCreateStrategy' => array(
            self::TYPE   => self::MENU_TYPE_AJAX,
            self::LABEL  => '',
            self::URL    => '/ajax/load_create_strategy',
            self::PARENT => 'showPromoPage',
        ),
        'ajaxUpdateStrategy' => array(
            self::TYPE   => self::MENU_TYPE_AJAX,
            self::LABEL  => '',
            self::URL    => '/ajax/load_update_strategy',
            self::PARENT => 'showPromoPage',
        ),
        'ajaxCreatePromoCode' => array(
            self::TYPE   => self::MENU_TYPE_AJAX,
            self::LABEL  => '',
            self::URL    => '/ajax/create_promo_code',
            self::PARENT => 'showPromoPage',
        ),
        'ajaxCreatePromoStrategy' => array(
            self::TYPE   => self::MENU_TYPE_AJAX,
            self::LABEL  => '',
            self::URL    => '/promo_code/dispose_promo_strategy',
            self::PARENT => 'showPromoPage',
        ),
        'ajaxUpdatePromoStrategy' => array(
            self::TYPE   => self::MENU_TYPE_AJAX,
            self::LABEL  => '',
            self::URL    => '/promo_code/dispose_promo_strategy_update',
            self::PARENT => 'showPromoPage',
        ),
        'showInvoiceMangePage' => array(
            self::TYPE   => self::MENU_TYPE_LEFT,
            self::LABEL  => '发票管理',
            self::URL    => '/invoice_manage',
            self::PARENT => 0,
        ),
        'ajaxInvoiceList' => array(
            self::TYPE   => self::MENU_TYPE_AJAX,
            self::LABEL  => '发票列表',
            self::URL    => '/invoice_manage',
            self::PARENT => 0,
        ),
        'ajaxLoadInvoiceAuditPage' => array(
            self::TYPE   => self::MENU_TYPE_AJAX,
            self::LABEL  => '发票审核页面',
            self::URL    => '/invoice_manage/ajax/invoice_audit',
            self::PARENT => 0,
        ),
        'ajaxLoadInvoiceInvocingPage' => array(
            self::TYPE   => self::MENU_TYPE_AJAX,
            self::LABEL  => '开发票处理页面',
            self::URL    => '/invoice_manage/ajax/invoice_invoicing',
            self::PARENT => 0,
        ),
        'ajaxLoadInvoiceMailPage' => array(
            self::TYPE   => self::MENU_TYPE_AJAX,
            self::LABEL  => '发票邮寄页面',
            self::URL    => '/invoice_manage/ajax/invoice_mail',
            self::PARENT => 0,
        ),
        'ajaxDisposeInvoiceAudit' => array(
            self::TYPE   => self::MENU_TYPE_AJAX,
            self::LABEL  => '发票申请审核处理接口',
            self::URL    => '/invoice_manage/ajax/dispose_invoice_audit',
            self::PARENT => 0,
        ),
        'ajaxDisposeInvoiceInvoicing' => array(
            self::TYPE   => self::MENU_TYPE_AJAX,
            self::LABEL  => '开发票处理接口',
            self::URL    => '/invoice_manage/ajax/dispose_invoice_invoicing',
            self::PARENT => 0,
        ),
        'ajaxDisposeInvoiceMail' => array(
            self::TYPE   => self::MENU_TYPE_AJAX,
            self::LABEL  => '发票邮寄处理接口',
            self::URL    => '/invoice_manage/ajax/dispose_invoice_mail',
            self::PARENT => 0,
        ),
    );

    private static $adminRightMenus = array(
        UserEnum::ADMIN_RIGHT_MANAGER    => array(
            'getAdminInfo',
            'getRegisterUser',
            'getEntUser',
            'showPromoPage',
            'showOrderPage',
            'ajaxCreatePromoCode',
            'ajaxLoadRegisterUser',
            'ajaxDisposeRegister',
            'ajaxShowOrderList',
            'ajaxShowOrderDetail',
            'ajaxOrderConfirm',
            'ajaxPromoCodeList',
            'ajaxPromoStrategyList',
            'ajaxCreateStrategy',
            'ajaxUpdateStrategy',
            'ajaxCreatePromoStrategy',
            'ajaxUpdatePromoStrategy',
            'showInvoiceMangePage',
            'ajaxInvoiceList',
            'ajaxLoadInvoiceAuditPage',
            'ajaxLoadInvoiceInvocingPage',
            'ajaxLoadInvoiceMailPage',
            'ajaxDisposeInvoiceAudit',
            'ajaxDisposeInvoiceInvoicing',
            'ajaxDisposeInvoiceMail',
        ),

        UserEnum::ADMIN_RIGHT_RD_MANAGER => array(),

        UserEnum::ADMIN_RIGHT_RD_COMMON  => array(),

        UserEnum::ADMIN_RIGHT_CS_MANAGER => array(),

        UserEnum::ADMIN_RIGHT_CS_COMMON  => array(),

    );

    public static function getMenu()
    {
        return self::$admin_menus;
    }

    public static function getRightMenu($right)
    {
        return self::$adminRightMenus[$right];
    }


    public static function getAdminLeftMenu($right)
    {
        self::mkNewMenus(self::getMenu());
        $rightMenus = self::getRightMenu($right);
        $aLeftMenus = array();
        foreach ($rightMenus as $menu) {
            if (self::$admin_menus[$menu][self::TYPE] == self::MENU_TYPE_LEFT)
                $aLeftMenus[] = $menu;
        }
        return self::setMenus($aLeftMenus);
    }
}

