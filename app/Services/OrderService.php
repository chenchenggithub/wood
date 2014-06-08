<?php
/**
 * Created by PhpStorm.
 * User: admin-chen
 * Date: 14-5-15
 * Time: 下午4:28
 */
class OrderService extends BaseService
{
    private static $self = NULL;

    static public function instance()
    {
        if (is_null(self::$self)) {
            self::$self = new self();
        }
        return self::$self;
    }

    /**
     * 创建增购的订单
     * @param $input
     * @param $account_id
     * @param $user_id
     * @return array|bool
     */
    public function createAddPurchaseOrder($input,$account_id,$user_id){
        $promo_code = $input['promo_code'];
        //1.计算套餐价格
        $package_price = PurchaseService::instance()->CalculatePackage($input, $account_id);
        //增加优惠码被使用的次数
        $code_id = PromoStrategyService::instance()->addPromoCodeUsedCount($promo_code);
        $order_data['code_id'] = 0;
        if($package_price['status_code'] == ProfessionErrorCodeEnum::PROMO_STRATEGY_SUCCESS) $input['code_id'] = $code_id;
        //2.生成套餐购买或增购订单
        if (!PurchaseService::instance()->CheckIsExistsPackage($account_id)) {
            $order_type    = OrderEnum::ORDER_TYPE_BASIC;
            $basic_package = Config::get('tsb_purchase.basic_package');
            if (!empty($input['add_host_count']) || !empty($input['add_website_count']) || !empty($input['add_mobileapp_count']) || ($input['add_host_frequency'] != $basic_package['host']['frequency']) || ($input['add_website_frequency'] != $basic_package['website']['frequency']) || ($input['add_mobileapp_frequency'] != $basic_package['mobile_app']['frequency']) || !empty($input['add_monitor'])) {
                $order_type = OrderEnum::ORDER_TYPE_BASIC_ADD;
            }
        } else {
            $order_type = OrderEnum::ORDER_TYPE_ADD;
        }
        $order_id = PurchaseService::instance()->CreateOrder($input, $package_price, $order_type, $account_id, $user_id);
        if (!$order_id) {
            //throw new Exception('生成订单发生错误！', ErrorCodeEnum::STATUS_SUCCESS_DO_ERROR);
            return false;
        }
        return array('order_id'=>$order_id,'order_type'=>$order_type,'package_price'=>$package_price);
    }

    /**
     * 创建续费的订单
     * @param $input
     * @param $order_data
     * @return array
     */
    public function createRenewalsOrder($input,$order_data){
        $promo_code = $input['promo_code'];
        //计算续费金额
        $renewals = PurchaseService::instance()->GetRenewalsPrice($order_data['account_id'], $input);
        //增加优惠码被使用的次数
        $code_id = PromoStrategyService::instance()->addPromoCodeUsedCount($promo_code);
        $order_data['code_id'] = 0;
        if($renewals['status_code'] == ProfessionErrorCodeEnum::PROMO_STRATEGY_SUCCESS) $order_data['code_id'] = $code_id;
        //生成套餐续费订单
        $order_data['real_total_price']    = $renewals['real_total_price'];
        $order_data['renewals_unit_price'] = $renewals['renewals_unit_price'];
        $order_id                          = PurchaseService::instance()->CreateRenewalsOrder($order_data);
        if (!$order_id) return false;

        return array('order_id'=>$order_id,'order_type'=>OrderEnum::ORDER_TYPE_RENEWALS,'package_price'=>$renewals);
    }

    /**
     * 获取账户下面的历史订单
     * @param $account_id
     * @return array
     */
    public function GetOrderHistory($account_id)
    {
        $order_history_model = new OrderHistory();
        $order_info          = $order_history_model->GetOrderHistory($account_id);
        foreach ($order_info as $k => $v) {
            $v->order_id       = '#' . $v->order_id;
            $v->order_time     = FormatTimeSpall::YmdHis($v->order_time);
            $v->payment_amount = CurrencyEnum::$CurrencyFormat[$v->currency_type] . $v->payment_amount;
            $v->order_type     = OrderEnum::$order_type[$v->order_type];
            $v->order_status   = OrderEnum::$order_status[$v->order_status];
        }
        return $order_info;
    }

    /**
     * 获取账户下符合发票申请的订单
     * @param $account_id
     * @return array
     */
    public function getInvoiceOrder($account_id)
    {
        $order_invoice_time  = Config::get('tsb_purchase.order_invoice_time') * 24 * 3600;
        $order_history_model = new OrderHistory();
        $order_info          = $order_history_model->getInvoiceOrder($account_id, $order_invoice_time);

        foreach ($order_info as $k => $v) {
            $v->order_num      = '#' . $v->order_id;
            $v->order_time     = FormatTimeSpall::YmdHis($v->order_time);
            $v->payment_amount = CurrencyEnum::$CurrencyFormat[$v->currency_type] . $v->payment_amount;
        }
        return $order_info;
    }

    /**
     * 计算订单中的支付金额
     * @param  array $order_ids
     */
    public function calculateOrderSum(array $order_ids)
    {
        $order_history_model = new OrderHistory();
        $pay_sum             = $order_history_model->getOrderPaySum($order_ids);
        return $pay_sum->pay_sum;
    }

    /**
     * 用户管理，获取用户订单
     */
    public function getAllOrderHistory()
    {
        $order_list = DB::table('order_history')
            ->select('order_history.order_id', 'order_history.order_type', 'order_history.order_status', 'order_history.payment_amount', 'user_info.user_email', 'user_info.user_mobile')
            ->leftJoin('user_info', 'order_history.user_id', '=', 'user_info.user_id')
            ->where('order_history.order_status', OrderEnum::ORDER_WAIT_PAYMENT_STATUS)
            ->paginate(AjaxPageEnum::PROMO_STRATEGY_PAGE_NUM);
        $order_list->{AjaxPageEnum::AJAX_PAGE_FUNC} = 'admin_order_manage.ajax_order_list_page';
        foreach ($order_list as $v) {
            $v->order_num           = '#' . $v->order_id;
            $v->order_format_type   = OrderEnum::$order_type[$v->order_type];
            $v->order_format_status = OrderEnum::$order_status[$v->order_status];
        }
        return $order_list;
    }

    /**
     * 后台管理员，开通订单
     */
    public function adminUserOpenOrder($order_id)
    {
        $order_history_model = new OrderHistory();
        $order_info          = $order_history_model->GetOrderHistoryById($order_id);
        $order_type          = $order_info->order_type;
        $account_id          = $order_info->account_id;
        $user_id             = -$order_info->user_id;

        //修改订单状态确认支付
        $update_order = array('order_status' => OrderEnum::ORDER_PAYMENT_STATUS, 'pay_time' => time(),'pay_type'=>OrderEnum::SETTLEMENT_CUSTOMER_SERVICE_TYPE);
        if (!$order_history_model->UpdateOrderHistory($account_id, $order_id,$update_order)) return FALSE;

        //购买套餐或增购或续费订单处理
        if ($order_type == OrderEnum::ORDER_TYPE_BASIC || $order_type == OrderEnum::ORDER_TYPE_BASIC_ADD || $order_type == OrderEnum::ORDER_TYPE_ADD || $order_type == OrderEnum::ORDER_TYPE_RENEWALS) {
            if(!PurchaseService::instance()->OrderPutPackage($account_id, $order_id)) return false;
        }
        //余额订单处理
        if ($order_type == OrderEnum::ORDER_TYPE_RENEWALS) {

        }

        return true;
    }
}