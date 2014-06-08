<?php
/**
 * Created by PhpStorm.
 * User: admin-chen
 * Date: 14-5-26
 * Time: 下午4:53
 */

class Admin_InvoiceManageController extends BaseController{
    /**
     * 展示发票管理页面
     */
    public function showInvoiceMangePage(){
        $this->viewAdmin('admin.invoice_manage');
    }

    /**
     * 加载发票申请列表页
     */
    public function ajaxInvoiceList(){
        $status = $this->params['status'];
        $invoice_list = InvoiceService::instance()->getInvoiceApplyByAdmin($status);
        $invoice_list->{AjaxPageEnum::AJAX_PAGE_FUNC} = 'admin_invoice_manage.page_func'; //ajax分页函数名
        $this->viewAjax('admin.ajaxTemplate.ajax_invoice_list')->with('invoice_list',$invoice_list);
    }

    /**
     * 发票申请审核页面
     */
    public function ajaxLoadInvoiceAuditPage(){
        $invoice_apply_id = $this->params['invoice_apply_id'];
        $invoice_audit_info = InvoiceService::instance()->getInvoiceAuditInfoById($invoice_apply_id);
        $this->viewAjax('admin.ajaxTemplate.ajax_invoice_audit_page')->with('invoice_audit_info',$invoice_audit_info);
    }

    /**
     * 发票申请审核处理接口
     */
    public function ajaxDisposeInvoiceAudit(){
        $data['invoice_apply_id'] = $this->params['invoice_apply_id'];
        $data['invoice_amount'] = $this->params['invoice_amount'];
        $data['audit_remark'] = $this->params['audit_remark'];
        $data['sign'] = $this->params['sign'];

        if(!InvoiceService::instance()->disposeInvoiceAudit($data)){
            $this->rest->error('操作失败',ErrorCodeEnum::STATUS_SUCCESS_DO_ERROR);
        }
        $this->rest->success();
    }

    /**
     * 开发票处理页面
     */
    public function ajaxLoadInvoiceInvocingPage(){
        $invoice_apply_id = $this->params['invoice_apply_id'];
        $invoice_invoicing_info = InvoiceService::instance()->getInvoiceInvoicingInfoById($invoice_apply_id);
        $this->viewAjax('admin.ajaxTemplate.ajax_invoice_invoicing_page')->with('invoice_invoicing_info',$invoice_invoicing_info);
    }

    /**
     *  开发票处理接口
     */
    public function ajaxDisposeInvoiceInvoicing(){
        $data['invoice_apply_id'] = $this->params['invoice_apply_id'];
        $data['invoice_code'] = $this->params['invoice_code'];
        if(!InvoiceService::instance()->disposeInvoiceInvoicing($data)){
            $this->rest->error('操作失败',ErrorCodeEnum::STATUS_SUCCESS_DO_ERROR);
        }
        $this->rest->success(array('status'=>InvoiceEnum::INVOICE_CHECK_SUCCESS));
    }

    /**
     * 发票邮寄页面
     */
    public function ajaxLoadInvoiceMailPage(){
        $invoice_apply_id = $this->params['invoice_apply_id'];
        $invoice_mail_info = InvoiceService::instance()->getInvoiceMailInfoById($invoice_apply_id);
        $this->viewAjax('admin.ajaxTemplate.ajax_invoice_mail_page')->with('invoice_mail_info',$invoice_mail_info);
    }

    /**
     * 发票邮寄处理接口
     */
    public function ajaxDisposeInvoiceMail(){
        $data['invoice_apply_id'] = $this->params['invoice_apply_id'];
        $data['express_code'] = $this->params['express_code'];
        $data['express_company'] = $this->params['express_company'];
        $data['mail_remark'] = $this->params['mail_remark'];
        if(!InvoiceService::instance()->disposeInvoiceMail($data)){
            $this->rest->error('操作失败',ErrorCodeEnum::STATUS_SUCCESS_DO_ERROR);
        }
        $this->rest->success(array('status'=>InvoiceEnum::INVOICE_WAIT_MAIL));
    }

} 