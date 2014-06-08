<?php
/**
 * 订单的结算处理
 * @author admin-chen
 *
 */
class OrderSettlementController extends BaseController{
    /**
	 * 订单结算入口
	 * @param void
	 * @return bool TRUE or FALSE
	 */
	public function SettlementInterface(){
        $user_info = UserService::instance()->getUserCache();
		$account_id = $user_info->account_id;
		$type = Route::input('type');
		$order_id = Route::input('order_id');

		//1.余额结算
		if($type == OrderEnum::SETTLEMENT_BALANCE){
			if($this->BalanceSettlement($account_id,$order_id)){
				$result = '余额--支付成功！';
			}else{
				$result = '余额--支付失败！';
			}
			
		}
		//2.支付宝结算
		if($type == OrderEnum::SETTLEMENT_PAYPAL){
			if($this->PaypalSettlement($account_id,$order_id)){
				$result = '支付宝--支付成功！';
			}else{
				$result = '支付宝--支付失败！';
			}
		}
		
		$this->view('purchase.settlement_result')->with('result',$result);
	}

    /**
     * 余额结算
     * @param     $account_id
     * @param int $order_id
     * @internal param $order_type
     * @return bool TRUE OR FALSE
     */
	private function BalanceSettlement($account_id,$order_id){
		$base_model = new BaseModel();
		//开启事物
		$base_model->transStart();
		if(!PurchaseService::instance()->BalanceSettlement($account_id, $order_id)) {
			$base_model->transRollBack();
			return FALSE;
		}
		if(!PurchaseService::instance()->OrderPutPackage($account_id, $order_id)){
			$base_model->transRollBack();
			return FALSE;
		}
		//事物提交
		$base_model->transCommit();
		return TRUE;
	}

    /**
     * 支付宝结算
     * @param     $account_id
     * @param int $order_id
     * @internal param $order_type
     * @return bool TRUE OR FALSE
     */
	private function PaypalSettlement($account_id,$order_id){
		return FALSE;
	}
}