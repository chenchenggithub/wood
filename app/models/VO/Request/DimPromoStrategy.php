<?php
/**
 * Created by PhpStorm.
 * User: admin-chen
 * Date: 14-5-22
 * Time: 上午11:47
 */

class DimPromoStrategy extends VO_Common{
    /**
     *
     */
    public $create_user_id;

    /**
     * 优惠策略名称
     */
    public $name;

    /**
     * 策略备注
     */
    public $remark;

    /**
     * 策略使用条件备注
     */
    public $use_condition_conf;

    /**
     * 使用模式
     */
    public $patt_conf;

} 