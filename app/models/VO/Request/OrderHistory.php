<?php
/**
 * Created by PhpStorm.
 * User: admin-chen
 * Date: 14-5-15
 * Time: 下午1:10
 */

class VO_Request_OrderHistory extends VO_Common
{
    /**
     * @var user_id
     */
    public $user_id;

    /**
     * @var account_id
     */
    public $account_id;

    /**
     * @var 订单类型
     */
    public $order_type;

    /**
     * @var 优惠码id
     */
    public $code_id;

    /**
     * @var 订单的状态
     */
    public $order_status;

    /**
     * @var 货币类型
     */
    public $currency_type;

    /**
     * @var 订单支付价格
     */
    public $payment_amount;

    /**
     * @var 订单的单价
     */
    public $package_unit_price;

    /**
     * @var 过期时间
     */
    public $expired_time;

    /**
     * @var 支付时间
     */
    public $pay_time;

    /**
     * @var 下单时间
     */
    public $order_time;
}