<?php
use Whoops\Example\Exception;

class OrderController extends BaseController{
    /**
     * 展示历史订单
     */
    public function ShowOrderHistory(){
        $user_info = UserService::instance()->getUserCache();
        $account_id = $user_info->account_id;
        $order_list = OrderService::instance()->GetOrderHistory($account_id);
        $this->view('purchase.order_history')
             ->with('order_list',$order_list)
             ->with(array(
                 'leftLeafMenu' => UserMenuEnum::getLeftLeafMenu(),
                 'menuGroup'    => UserMenuEnum::getMenuGroups(),
             ));
    }

    /**
     * 展示订单结算页面
     */
    public function ajaxLoadOrderSettlementPage(){
        $order_id = $this->params['order_id'];
        $order_history_model = new OrderHistory();
        $order = $order_history_model->GetOrderHistoryById($order_id);
        $this->viewAjax('purchase.ajaxTemplate.ajax_order_settlement')->with('order',$order);
    }

    /**
     * 处理用户增购商品并生成用户订单
     */
    public function ajaxDisposeAddPurchase(){
        $user_info = UserService::instance()->getUserCache();
        $account_id           = $user_info->account_id;
        $user_id              = $user_info->user_id;
        $input                = Input::all();
        $input['add_monitor'] = trim($input['add_monitor'], ',');

        //1.生成购买或增购订单
      if(!$order_arr = OrderService::instance()->createAddPurchaseOrder($input,$account_id,$user_id)){
           $this->rest->error('生成订单失败!');
       }
        $order_other = $this->formatOrderOther($order_arr,$account_id,$input['purchase_time'],$input['promo_code']);

        //2.展示订单详情
        $order_details = PurchaseService::instance()->GetOrderDetailsView($order_other['order_id']);
        if(!$order_details){
            throw new Exception(ErrorCodeEnum::$status_msgs[ErrorCodeEnum::STATUS_SUCCESS_DO_ERROR_DB],ErrorCodeEnum::STATUS_SUCCESS_DO_ERROR_DB);
        }

        $this->viewAjax('purchase.ajaxTemplate.ajax_order_add_purchase')->with('order',$order_details['order'])
             ->with('commodity',$order_details['commodity'])
             ->with('order_add_monitor',json_encode($order_details['commodity'][PackageEnum::MONITOR]['select_monitor']))
             ->with('page_num',10) //每页的记录数
             ->with('order_other',$order_other);
    }

    /**
     * 处理续费并生成订单详情页
     */
    public function ajaxDisposeRenewals(){
        $user_info = UserService::instance()->getUserCache();
        $input = Input::all();
        $order_data                  = array();
        $order_data['account_id']    = $user_info->account_id;
        $order_data['user_id']       = $user_info->user_id;
        $order_data['renewals_time'] = $input['renewals_time'];

        //1.生成购买或增购订单
        if(!$order_arr = OrderService::instance()->createRenewalsOrder($input,$order_data)){
            $this->rest->error('生成订单失败!');
        }

        $order_other = $this->formatOrderOther($order_arr,$order_data['account_id'],$input['renewals_time'],$input['promo_code']);
        //2.展示订单详情
        $order_details = PurchaseService::instance()->GetRenewalsOrderDetails($order_other['order_id']);
        $commodity = PurchaseService::instance()->GetRenewalsPackageDetails($order_data['account_id']);

        $this->viewAjax('purchase.ajaxTemplate.ajax_order_renewals')
             ->with('order',$order_details)
             ->with('commodity',$commodity)
             ->with('order_renewal_monitor',json_encode($commodity[PackageEnum::MONITOR]['select_monitor']))
             ->with('page_num',10) //每页的记录数
             ->with('order_other',$order_other);
    }

    private function formatOrderOther($order_arr,$account_id,$purchase_time,$promo_code){
        $order_other = array();
        $order_other['order_id'] = $order_arr['order_id'];
        $order_other['order_type'] = $order_arr['order_type'];
        $order_other['package_price'] = $order_arr['package_price'];
        $order_other['promo_code'] = $promo_code;
        $handsel_time      = Config::get('tsb_purchase.handsel_time'); //计算赠送的时间
        $order_other['purchase_time'] = isset($handsel_time[$purchase_time]) ? $purchase_time.'个月（送'.$handsel_time[$purchase_time].'个月)' : $purchase_time.'个月';
        $order_other['is_has_package'] = true;
        if (!PurchaseService::instance()->CheckIsExistsPackage($account_id))  {
            $order_other['is_has_package'] = FALSE;
            $order_other['add_purchase_count'] = 0;
        }else{
            //增购次数
            $package_instance_model = new Package_PackageInstanceModel();
            if (!$package_instance = $package_instance_model->GetPacakageInstance($account_id)) return FALSE;
            $order_other['add_purchase_count'] = $package_instance->add_purchase_count;
        }
        $order_other['package_type'] = OrderEnum::$order_type[$order_other['order_type']];
        return $order_other;
    }
}

