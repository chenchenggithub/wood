<?php
class OrderEnum{
	const ORDER_WAIT_PAYMENT_STATUS = 0; //订单等待支付状态
	const ORDER_PAYMENT_STATUS = 1; //订单已支付状态
	const ORDER_EXPIRED_STATUS = 2; //订单已经过期
	
	const ORDER_TYPE_BASIC = 1; //订单类型“基本套餐”
	const ORDER_TYPE_BASIC_ADD = 2; //订单类型“基本套餐+增购”
	const ORDER_TYPE_ADD = 3; //订单类型“增购”
	const ORDER_TYPE_RENEWALS = 4; //订单类型“续费”
	const ORDER_TYPE_RECHARGE = 5; //订单类型“余额充值”
	
	const SETTLEMENT_BALANCE = 'balance'; //余额结算
	const SETTLEMENT_PAYPAL = 'paypal'; //支付宝结算

    const SETTLEMENT_BALANCE_TYPE = 1; //订单余额支付类型
    const SETTLEMENT_PAYPAL_TYPE = 2; //订单支付宝支付类型
    const SETTLEMENT_CUSTOMER_SERVICE_TYPE = 3; //订单客服开通类型

    const ORDER_APPLY_INVOICE_NO = 0; //该订单未申请发票
    const ORDER_APPLY_INVOICE_YES = 1; //该订单已申请发票
	
	//订单状态转换
	static public $order_status = array(
				self::ORDER_WAIT_PAYMENT_STATUS => '等待支付',
				self::ORDER_PAYMENT_STATUS => '已支付',
				self::ORDER_EXPIRED_STATUS => '已过期',
			);
    //订单类型转换
    static public $order_type = array(
        self::ORDER_TYPE_BASIC => '基本套餐',
        self::ORDER_TYPE_BASIC_ADD => '基本套餐+增购',
        self::ORDER_TYPE_ADD => '增购',
        self::ORDER_TYPE_RENEWALS => '续费',
        self::ORDER_TYPE_RECHARGE => '余额充值',
    );
}