<?php
/**
 * Created by PhpStorm.
 * User: admin-chen
 * Date: 14-5-22
 * Time: 上午11:06
 * 优惠策略配置
 */

class PromoStrategyEnum {
    /**
     * 优惠码使用条件配置
     */
    const TIME_LIMIT = 'time_limit';
    const USE_COUNT = 'use_count'; //使用次数
    const CONSUMPTION_AMOUNT='consumption_amount'; //消费金额
    public static $promo_use_condition = array(
        self::TIME_LIMIT,
        self::USE_COUNT,
        self::CONSUMPTION_AMOUNT,
    );

    /**
     * 优惠模式配置
     */
    const DISCOUNT = 'discount'; //折扣
    const PROMO_AMOUNT = 'promo_amount'; //优惠金额
    static public $promo_patt = array(
        self::DISCOUNT,
        self::PROMO_AMOUNT,
    );

    /**
     * 优惠码使用条件对应的验证方法名
     */
    static public $check_method = array(
        self::TIME_LIMIT=> 'checkTimeLimit',
        self::USE_COUNT => 'checkUseCount', //验证使用次数
        self::CONSUMPTION_AMOUNT => 'checkConsumptionAmount', //验证消费金额
    );
} 