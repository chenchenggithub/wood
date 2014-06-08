<?php 
use Boris\Config;

class OrderHistory extends BaseModel{
    protected $table = 'order_history';
    protected $primaryKey = 'order_id';
    /**
     * 根据order_id获取单条订单的详细记录
     * @prama int $order_id
     * @param $order_id
     * @return object $result
     */
public function GetOrderHistoryById($order_id)
{
	$result = DB::table('order_history')
			 ->where('order_id',$order_id)
			 ->select('order_id','user_id','account_id','order_time','payment_amount','order_status','currency_type','order_type','package_unit_price')
			 ->first();
	return $result;
}

    /**
     * 根据account_id获取订单的记录
     * @prama int $account_id
     * @param $account_id
     * @return object $result
     */
public function GetOrderHistoryByAccountId($account_id)
{
	$result = DB::table('order_history')->where('account_id',$account_id)->get();
	return $result;
}

/**
 * 创建一条新的数据
 * @param array $data
 * @return int id or false
 */
public function InsertOrderHistory($data){
  return  array(
        'user_id' => $data->user_id,
        'account_id' => $data->account_id,
        'order_type' => $data->order_type,
        'currency_type' => $data->currency_type,
        'order_status' => OrderEnum::ORDER_WAIT_PAYMENT_STATUS,
        'payment_amount' => $data->payment_amount,
        'order_time' => $data->order_time,
        'expired_time' => $data->expired_time,
        'code_id' => $data->code_id,
        'package_unit_price' => $data->package_unit_price
    );
}

/**
 * 更新订单中的数据
 * @param int $account_id
 * @param int $order_id
 * @param array $data
 * @return bool
 */
public function UpdateOrderHistory($account_id,$order_id,$data){
	return DB::table('order_history')->where('account_id',$account_id)
                                     ->where('order_id',$order_id)
									 ->update($data);
}

    /**
     * 获取账户下的历史订单
     * @param $account_id
     * @return array
     */
    public function GetOrderHistory($account_id){
        return DB::table($this->table)
                    ->select('order_id','order_time','payment_amount','currency_type','order_type','order_status')
                    ->paginate(15);
        //$this->setSelect(array('order_id','order_time','payment_amount','currency_type','order_type','order_status'));
        //return $this->fetchAll(array('account_id in ?'=>$account_id));
    }

    /**
     * 获取账户下符合发票申请的订单
     * @param $account_id
     * @param $order_invoice_time
     * @return array
     */
    public function getInvoiceOrder($account_id,$order_invoice_time){

        $this->setSelect(array('order_id','order_time','payment_amount','currency_type'));
        $aWhere = array('account_id = ?'=>$account_id,
                        'pay_type in ?'=>OrderEnum::SETTLEMENT_PAYPAL_TYPE.','.OrderEnum::SETTLEMENT_CUSTOMER_SERVICE_TYPE,
                        'order_status = ?'=> OrderEnum::ORDER_PAYMENT_STATUS,
                        'is_apply_invoice = ?'=> OrderEnum::ORDER_APPLY_INVOICE_NO,
                        'pay_time >= ?'=>(time() - $order_invoice_time)
                        );
        return $this->fetchAll($aWhere);
    }

    /**
     * 获取订单的支付金额
     * @param array $order_ids
     */
    public function getOrderPaySum(array $order_ids){
        return DB::table($this->table)
            ->select(DB::raw('sum(payment_amount) as pay_sum'))
            ->whereIn('order_id', $order_ids)
            ->first();
    }
}