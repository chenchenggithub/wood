<?php
/**
 * Created by PhpStorm.
 * User: admin-chen
 * Date: 14-5-19
 * Time: 下午4:23
 */

class VO_Request_DimInvoice extends VO_Common{
    /**
     * 开发票的订单
     */
    public $order_history_ids;

    /**
     * 申请时间
     */
    public $apply_time;

    public $account_id;

    public $user_id;

    /**
     * 发票抬头
     */
    public $invoice_header;

    /**
     * 联系人
     */
    public $contact;

    /**
     * 联系人电话
     */
    public $telephone;

    /**
     * 发票金额
     */
    public $invoice_amount;

    /**
     * 邮寄地址
     */
    public $address;

    /**
     * 备注
     */
    public $remark;

    /**
     *
     */
    public $status;

    /**
     * 邮编
     */
    public $zip_code;
} 