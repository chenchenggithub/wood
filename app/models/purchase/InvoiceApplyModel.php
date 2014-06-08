<?php
/**
 * Created by PhpStorm.
 * User: admin-chen
 * Date: 14-5-19
 * Time: 下午5:04
 */

class InvoiceApplyModel extends BaseModel{
    protected $table = 'invoice_apply';
    protected $primaryKey = 'invoice_apply_id';
    /**
     * 发票申请信息
     */
    public function oInsertInvoice($request){
        return array(
            'order_history_ids' => implode(',',$request->order_history_ids),
            'apply_time' => time(),
            'account_id' => $request->account_id,
            'user_id' => $request->user_id,
            'invoice_header' => $request->invoice_header,
            'contact' => $request->contact,
            'telephone' => $request->telephone,
            'invoice_amount' => $request->invoice_amount,
            'address' => $request->address,
            'remark' => $request->remark,
            'status' => InvoiceEnum::INVOICE_PROCESSING,
            'zip_code' => $request->zip_code,
        );
    }

    /**
     * 获取发票申请
     */
    public function getInvoiceList($status){
       return DB::table($this->table)
            ->select('invoice_apply.invoice_apply_id','invoice_apply.user_id','user_info.user_email','invoice_apply.status','invoice_apply.audit_time','invoice_apply.invoice_time','invoice_apply.mail_time','invoice_apply.mail_time','invoice_apply.invoice_amount','invoice_apply.apply_time','invoice_apply.order_history_ids')
            ->leftJoin('user_info', 'invoice_apply.user_id', '=', 'user_info.user_id')
            ->where('status',$status)
            ->paginate(InvoiceEnum::INVOICE_PAGE_COUNT);
    }
} 