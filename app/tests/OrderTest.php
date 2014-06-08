<?php
/**
 * Created by PhpStorm.
 * User: admin-chen
 * Date: 14-5-16
 * Time: 下午2:11
 */
class OrderTest extends TestCase{
    /**
     * 订单测试入口
     */
    public function testInstance(){
        $this->getInvoiceOrder();
    }

    /**
     * 获取账户下符合发票申请的订单
     */
    private function getInvoiceOrder(){
        $account_id = 1;
        OrderService::instance()->getInvoiceOrder($account_id);
    }
}