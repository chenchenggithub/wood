<?php
/**
 * Created by PhpStorm.
 * User: admin-chen
 * Date: 14-5-24
 * Time: 上午11:00
 */

class Admin_OrderManageController extends BaseController{
    /**
     * 展示订单管理页面
     */
    public function showOrderPage(){
        //$admin_info = Session::get(AdminMenuEnum::ADMIN_SESSION_KEY);
        $this->viewAdmin('admin.order_manage');
    }

    /**
     * 确认订单支付
     */
    public function ajaxOrderConfirm(){
        $order_id = $this->params['order_id'];
        if(!OrderService::instance()->adminUserOpenOrder($order_id)){
            $this->rest->error('操作失败',ErrorCodeEnum::STATUS_ERROR);
        }
        $this->rest->success();
    }

    /**
     * 展示订单列表页面
     */
    public function ajaxShowOrderList(){
        $order_list = OrderService::instance()->getAllOrderHistory();
        $this->viewAjax('admin.ajaxTemplate.ajax_order_list')->with('order_list',$order_list);
    }

    /**
     * 订单详细信息
     */
    public function ajaxShowOrderDetail(){
        $order_id = $this->params['order_id'];
        $order_type = $this->params['order_type'];

        //套餐购买或增购
        if($order_type == OrderEnum::ORDER_TYPE_BASIC || $order_type == OrderEnum::ORDER_TYPE_BASIC_ADD || $order_type == OrderEnum::ORDER_TYPE_ADD)
        {
            $this->PackageBuy($order_id,$order_type);
            return;
        }

        //套餐续费
        if($order_type == OrderEnum::ORDER_TYPE_RENEWALS){
            $this->PackageRenewals($order_id,$order_type);
            return;
        }
    }

    /**
     * 套餐购买或增购
     * @param $order_id
     * @param $order_type
     * @throws Exception
     * @return void
     */
    private function PackageBuy($order_id,$order_type){
        $order_details = PurchaseService::instance()->GetOrderDetails($order_id);
        if(!$order_details){
            throw new Exception(ErrorCodeEnum::$status_msgs[ErrorCodeEnum::STATUS_SUCCESS_DO_ERROR_DB],ErrorCodeEnum::STATUS_SUCCESS_DO_ERROR_DB);
        }
        $this->viewAjax('admin.ajaxTemplate.ajax_order_detail')
            ->with('order',$order_details['order'])
            ->with('commodity',$order_details['commodity'])
            ->with('is_renewals',false)
            ->with('order_type',$order_type)
            ->with('order_id',$order_id);
    }

    /**
     * 套餐续费
     * @param $order_id
     * @param $order_type
     * @throws Exception
     * @return void
     */
    private function PackageRenewals($order_id,$order_type){
        if(!$renewals_order = PurchaseService::instance()->GetRenewalsOrderDetails($order_id)){
            throw new Exception(ErrorCodeEnum::$status_msgs[ErrorCodeEnum::STATUS_SUCCESS_DO_ERROR_DB],ErrorCodeEnum::STATUS_SUCCESS_DO_ERROR_DB);
        }
        $this->viewAjax('admin.ajaxTemplate.ajax_order_detail')->with('order',$renewals_order)
            ->with('is_renewals',true)
            ->with('order_type',$order_type)
            ->with('order_id',$order_id);
    }

} 