<?php
/**
 * Created by PhpStorm.
 * User: admin-chen
 * Date: 14-5-19
 * Time: 下午4:43
 */

class InvoiceEnum
{
    const INVOICE_PROCESSING = 1; //发票处理中
    const INVOICE_CHECK_SUCCESS = 2; //发票审核成功
    const INVOICE_CHECK_FAIL = 3; //发票审核失败
    const INVOICE_WAIT_MAIL = 4; //发票等待邮寄
    const INVOICE_MAILED = 5; //发票已经邮寄

    const INVOICE_PAGE_COUNT = 10;//发票申请分页数

    static public $status_msg = array(
        self::INVOICE_PROCESSING    => '等待审核',
        self::INVOICE_CHECK_FAIL    => '审核失败',
        self::INVOICE_CHECK_SUCCESS => '审核成功',
        self::INVOICE_WAIT_MAIL     => '等待邮寄',
        self::INVOICE_MAILED        => '已经邮寄'
    );
} 