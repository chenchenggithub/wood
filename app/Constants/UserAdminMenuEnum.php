<?php
/**
 * Created by PhpStorm.
 * User: admin-chen
 * Date: 14-5-21
 * Time: 上午11:20
 */

class UserAdminMenuEnum {
    const ACCOUNT_INFO = 'account_info'; //账户信息
    const BASIC_INFO = 1; //基本信息
    const USER_MANAGE = 2; //用户管理
    const MANAGE_LOG = 3; //操作日志

    const BUY = 'buy'; // 购买
    const PURCHASE_AND_RENEWALS = 4; //购买&续费
    const BALANCE_RECHARGE = 5; //余额充值
    const BUY_HISTORY = 6; //购买历史
    const INVOICE_MANAGE = 7; //发票管理

    public static $left_menu_title = array(
        self::ACCOUNT_INFO => '账户信息',
        self::BUY => '购买'
    );

    public static $user_left_menu = array(
        self::ACCOUNT_INFO => array(
            self::BASIC_INFO => array(
                'url' => '/user/admin',
                'label' => '基本信息',
            ),
            self::USER_MANAGE => array(
                'url' => '',
                'label' => '用户管理'
            ),
            self::MANAGE_LOG => array(
                'url' => '',
                'label' => '操作日志'
            ),
        ),
        self::BUY => array(
            self::PURCHASE_AND_RENEWALS => array(
                'url' => '/buy',
                'label' => '购买&续费',
            ),
            self::BALANCE_RECHARGE => array(
                'url' => '',
                'label' => '余额充值'
            ),
            self::BUY_HISTORY => array(
                'url' => '/order/history',
                'label' => '购买历史'
            ),
            self::INVOICE_MANAGE => array(
                'url' => '/invoice',
                'label' => '发票管理'
            ),
        ),

    );
} 