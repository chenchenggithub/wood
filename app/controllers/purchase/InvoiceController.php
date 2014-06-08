<?php
/**
 * Created by PhpStorm.
 * User: admin-chen
 * Date: 14-5-19
 * Time: 上午11:09
 */
class InvoiceController extends BaseController{
    /**
     * 展示发票管理的主页面
     */
    public function showInvoice(){
        $this->view('purchase.invoice')
             ->with('select_label',UserAdminMenuEnum::INVOICE_MANAGE)
             ->with(array(
                'leftLeafMenu' => UserMenuEnum::getLeftLeafMenu(),
                'menuGroup'    => UserMenuEnum::getMenuGroups(),
             ));
    }

    /**
     * 展示申请发票记录
     */
    public function ajaxLoadInvoiceRecords(){
        $user_info = UserService::instance()->getUserCache();
        $account_id = $user_info->account_id;
        $invoice_records = InvoiceService::instance()->getInvoiceApply($account_id);
        $this->viewAjax('purchase.ajaxTemplate.ajax_invoice_records')->with('invoice_records',$invoice_records);
    }

    /**
     * 申请发票
     */
    public function ajaxLoadApplyInvoice(){
        $user_info = UserService::instance()->getUserCache();
        $account_id = $user_info->account_id;
        $order_list = OrderService::instance()->getInvoiceOrder($account_id);
        $this->viewAjax('purchase.ajaxTemplate.ajax_invoice_apply')->with('order_list',$order_list);
    }

    /**
     * 处理发票申请
     */
    public  function disposeInvoiceApply(){
        $user_info = UserService::instance()->getUserCache();
        $this->params['account_id'] = $user_info->account_id;
        $this->params['user_id'] = $user_info->user_id;
        $this->params['invoice_amount'] = OrderService::instance()->calculateOrderSum($this->params['order_history_ids']);

        $request_info = InvoiceService::instance()->setRequestInvoiceParams($this->params);

        if(!InvoiceService::instance()->insertInvoice($request_info)){
            throw new Exception('申请发票失败',ErrorCodeEnum::STATUS_SUCCESS_DO_ERROR_DB);
        }
        return  Redirect::to('/invoice');
    }

    /**
     * 计算申请发票的金额
     */
    public function ajaxCalculateOrderSum(){
        $order_ids = explode(',',trim($this->params['order_ids'],','));
        $pay_sum = OrderService::instance()->calculateOrderSum($order_ids);
        $this->rest->success(array('pay_sum'=>$pay_sum));
    }
}