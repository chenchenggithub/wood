<?php
/**
 * Created by PhpStorm.
 * User: admin-chen
 * Date: 14-5-19
 * Time: 下午4:19
 */

class InvoiceService extends BaseService{
    private static $slef = NULL;
    private $oInvoiceInfo;
    private $invoice_model;
    static public function instance(){
        if(is_null(self::$slef)){
            self::$slef = new self();
        }
        return self::$slef;
    }

    public function __construct(){
        $this->invoice_model = new InvoiceApplyModel();
    }
    /**
     * @param $aParams
     * @return VO_Request_DimInvoice
     */
    public function setRequestInvoiceParams($aParams){
        $this->oInvoiceInfo = VO_Bound::Bound($aParams,new VO_Request_DimInvoice());
        return $this->oInvoiceInfo;
    }

    /**
     * 创建一个新的发票申请，并更改订单的状态
     */
    public function insertInvoice($request_info){
        $insert_info = $this->invoice_model->oInsertInvoice($request_info);
        if(!$invoice_apply_id = $this->invoice_model->insert($insert_info)) return false;

        //将订单改成已申请发票的订单
        $order_history_model = new OrderHistory();
        $aWhere = array('order_id in ?'=>$request_info->order_history_ids);
        $updateData = array('is_apply_invoice'=>OrderEnum::ORDER_APPLY_INVOICE_YES);
        if(-1 == $order_history_model->update($updateData,$aWhere)) return false;
        return $invoice_apply_id;
    }

    /**
     * 获取账户下的发票申请
     * @param $account_id
     * @return array
     */
    public function getInvoiceApply($account_id){
        $this->invoice_model->setSelect(array('order_history_ids','apply_time','invoice_header','invoice_amount','status'));
        $invoice_info = $this->invoice_model->fetchAll(array('account_id = ?'=>$account_id));

        foreach($invoice_info as $v){
            $order_history_ids_arr = explode(',',$v->order_history_ids);
            $v->order_ids = '';
            foreach($order_history_ids_arr as $order_id){
                $v->order_ids .= '#'.$order_id.',';
            }

            $v->order_ids = trim($v->order_ids,',');
            $v->apply_time = FormatTimeSpall::YmdHis($v->apply_time);
            $v->invoice_amount = '￥'.$v->invoice_amount;
            $v->status = InvoiceEnum::$status_msg[$v->status];
        }

        return $invoice_info;
    }

    /**
     * 后台管理获取发票列表
     */
    public function getInvoiceApplyByAdmin($status){
        $invoice_list = $this->invoice_model->getInvoiceList($status);

        foreach($invoice_list as $v){
            $v->status_msg = InvoiceEnum::$status_msg[$v->status];
            $v->audit_time = ($v->audit_time == '') ? '-':FormatTimeSpall::YmdHi($v->audit_time);
            $v->invoice_time = ($v->invoice_time == '') ? '-':FormatTimeSpall::YmdHi($v->invoice_time);
            $v->mail_time = ($v->mail_time == '') ? '-':FormatTimeSpall::YmdHi($v->mail_time);
            $v->invoice_amount = '￥'.$v->invoice_amount;
            $v->apply_time = ($v->apply_time == '') ? '-':FormatTimeSpall::YmdHi($v->apply_time);
            $v->order_num_arr = explode(',',$v->order_history_ids);
        }
        return $invoice_list;
    }

    /**
     * 依据invoice_apply_id获取发票审核信息
     * @param $invoice_apply_id
     * @return mixed
     */
    public function getInvoiceAuditInfoById($invoice_apply_id){
        $invoice_audit_info = $this->invoice_model->fetchRow($invoice_apply_id);
        $invoice_audit_info->order_num_arr = explode(',',$invoice_audit_info->order_history_ids);
        $invoice_audit_info->apply_time = FormatTimeSpall::YmdHi($invoice_audit_info->apply_time);
        $invoice_audit_info->invoice_code = empty($invoice_audit_info->invoice_code) ? '-' : $invoice_audit_info->invoice_code;
        $invoice_audit_info->invoice_header = empty($invoice_audit_info->invoice_header) ? '-' : $invoice_audit_info->invoice_header;
        $invoice_audit_info->contact = empty($invoice_audit_info->contact) ? '-' : $invoice_audit_info->contact;
        $invoice_audit_info->telephone = empty($invoice_audit_info->telephone) ? '-' : $invoice_audit_info->telephone;
        $invoice_audit_info->address = empty($invoice_audit_info->address) ? '-' : $invoice_audit_info->address;
        $invoice_audit_info->remark = empty($invoice_audit_info->remark) ? '-' : $invoice_audit_info->remark;
        return $invoice_audit_info;
    }

    /**
     * @param $invoice_apply_id
     * @return array
     */
    public function getInvoiceInvoicingInfoById($invoice_apply_id){
        $invoice_invoicing_info = $this->invoice_model->fetchRow($invoice_apply_id);
        $invoice_invoicing_info->audit_time = FormatTimeSpall::YmdHi($invoice_invoicing_info->audit_time);
        return $invoice_invoicing_info;
    }

    /**
     * 依据invoice_apply_id获取发票邮寄信息
     * @param $invoice_apply_id
     * @return mixed
     */
    public function getInvoiceMailInfoById($invoice_apply_id){
        $invoice_mail_info = $this->invoice_model->fetchRow($invoice_apply_id);
        $invoice_mail_info->order_num_arr = explode(',',$invoice_mail_info->order_history_ids);
        $invoice_mail_info->apply_time = FormatTimeSpall::YmdHi($invoice_mail_info->apply_time);
        $invoice_mail_info->invoice_code = empty($invoice_mail_info->invoice_code) ? '-' : $invoice_mail_info->invoice_code;
        $invoice_mail_info->invoice_header = empty($invoice_mail_info->invoice_header) ? '-' : $invoice_mail_info->invoice_header;
        $invoice_mail_info->contact = empty($invoice_mail_info->contact) ? '-' : $invoice_mail_info->contact;
        $invoice_mail_info->telephone = empty($invoice_mail_info->telephone) ? '-' : $invoice_mail_info->telephone;
        $invoice_mail_info->address = empty($invoice_mail_info->address) ? '-' : $invoice_mail_info->address;
        $invoice_mail_info->remark = empty($invoice_mail_info->remark) ? '-' : $invoice_mail_info->remark;
        return $invoice_mail_info;
    }

    /**
     * 后台管理审核发票申请
     * @param array $data
     * @return bool
     */
    public function disposeInvoiceAudit(array $data){
        $updateData['invoice_amount'] = $data['invoice_amount'];
        $updateData['audit_remark'] = $data['audit_remark'];
        $updateData['audit_time'] = time();
        if($data['sign'] == InvoiceEnum::INVOICE_CHECK_SUCCESS) $updateData['status'] = InvoiceEnum::INVOICE_CHECK_SUCCESS;
        if($data['sign'] == InvoiceEnum::INVOICE_CHECK_FAIL) $updateData['status'] = InvoiceEnum::INVOICE_CHECK_FAIL;
        $aWhere['invoice_apply_id'] = $data['invoice_apply_id'];
        if(-1 == $this->invoice_model->update($updateData,$aWhere)) return false;
        return true;
    }

    /**
     * 后台管理开发票处理
     * @param array $data
     * @return bool
     */
    public function disposeInvoiceInvoicing(array $data){
        $updateData['invoice_code'] = $data['invoice_code'];
        $updateData['invoice_time'] = time();
        $updateData['status'] = InvoiceEnum::INVOICE_WAIT_MAIL;
        $aWhere['invoice_apply_id'] = $data['invoice_apply_id'];
        if(-1 == $this->invoice_model->update($updateData,$aWhere)) return false;
        return true;
    }

    /**
     * 后台管理发票邮寄出
     * @param array $data
     * @return bool
     */
    public function disposeInvoiceMail(array $data){
        $updateData['express_company'] = $data['express_company'];
        $updateData['express_code'] = $data['express_code'];
        $updateData['mail_remark'] = $data['mail_remark'];
        $updateData['mail_time'] = time();
        $updateData['status'] = InvoiceEnum::INVOICE_MAILED;
        $aWhere['invoice_apply_id'] = $data['invoice_apply_id'];
        if(-1 == $this->invoice_model->update($updateData,$aWhere)) return false;
        return true;
    }
} 