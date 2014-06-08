<?php
class PurchaseService extends BaseService
{
    private static $self = NULL;

    /**
     * @var VO_Request_OrderHistory
     */
    private $oOrderHistoryInfo;

    /**
     * @return PurchaseService
     */
    static public function instance()
    {
        if (is_null(self::$self)) {
            self::$self = new self;
        }
        return self::$self;
    }

    public function __construct()
    {

    }

    /**
     * @param $aParams
     * @return VO_Request_OrderHistory
     */
    public function setRequestOrderHistoryParams($aParams)
    {
        $this->oOrderHistoryInfo = VO_Bound::Bound($aParams, new VO_Request_OrderHistory());
        return $this->oOrderHistoryInfo;
    }

    /**
     * 验证用户是否存在付费套餐
     * @param int $account_id
     * @return bool TRUE or FALSE
     */
    public function CheckIsExistsPackage($account_id)
    {
        static $return_data = NULL;
        if(is_null($return_data)){
            $package_instance_model = new Package_PackageInstanceModel();
            $instance_info = $package_instance_model->GetPacakageInstance($account_id);
            if(empty($instance_info)) $return_data = false;
            if($instance_info->package_type == PackageEnum::PACKAGE_TYR_TYPE) $return_data = false;
            if($instance_info->package_type == PackageEnum::PACKAGE_PAY_TYPE) $return_data = true;
        }
        return $return_data;
    }

    /**
     * 获取购买中相关的监测点信息
     * @param $account_id
     * @return mixed
     */
    public function getBuyMonitor($account_id){
        $monitor_define_list = Config::get('tsb_monitor.monitor_define_list');
        if (!PurchaseService::instance()->CheckIsExistsPackage($account_id)) {
            $basic_package = Config::get('tsb_purchase.basic_package');
        }else{
            $basic_package  = PurchaseService::instance()->GetPackageInfo($account_id);
        }

        foreach($monitor_define_list as $monitor_num=>$v){
            $monitor_define_list[$monitor_num]['area'] = 0;
            $monitor_define_list[$monitor_num]['area_name'] = '无';
            if(in_array($monitor_num,$basic_package['monitor'])) {
                $monitor_define_list[$monitor_num]['is_buy'] = '已购买';
            }else{
                $monitor_define_list[$monitor_num]['is_buy'] = '可选';
            }
            foreach(MonitorEnum::$monitorsByGroupArea as $area=>$group){
                if(in_array($monitor_num,$group)) {
                    $monitor_define_list[$monitor_num]['area'] = $area;
                    $monitor_define_list[$monitor_num]['area_name'] = MonitorEnum::$monitorGroupsArea[$area];
                    break;
                }
            }
        }
        //已有的监测点
        $monitor['select_monitor'] = array_only($monitor_define_list, $basic_package['monitor']);
        //可以增购的监测点
        $monitor['unselected_monitor'] = array_only($monitor_define_list, array_diff(array_keys($monitor_define_list), $basic_package['monitor']));
        $monitor['all_monitor'] = $monitor_define_list;
        return $monitor;
    }

    /**
     * 获取货币类型
     * @return int
     */
    public function getCurrencyType()
    {
        /**
         * 获取当前货币类型的逻辑代码
         */
        //默认返回人民币
        return CurrencyEnum::RENMINBIN;
    }

    /**
     * 计算增购套餐的价格
     * @param array $prama
     * @param int   $account_id
     * @return array $returnData
     */
    public function CalculatePackage($prama, $account_id)
    {
        $returnData              = array();
        $add_host_count          = $prama['add_host_count'];
        $add_website_count       = $prama['add_website_count'];
        $add_mobileapp_count     = $prama['add_mobileapp_count'];
        $add_yundou_count        = $prama['add_yundou_count'];
        $add_host_frequency      = $prama['add_host_frequency'];
        $add_website_frequency   = $prama['add_website_frequency'];
        $add_mobileapp_frequency = $prama['add_mobileapp_frequency'];
        $purchase_time           = $prama['purchase_time'];
        $promo_code              = trim($prama['promo_code']);
        $add_monitor             = explode(',', $prama['add_monitor']);
        $host_price              = $website_price = $mobileapp_price = 0;

        //读取配置
        $host_frequency_price = Config::get('tsb_purchase.host_frequency_price');
        $translate_price      = Config::get('tsb_purchase.translate_price');
        $monitor_define_list  = Config::get('tsb_monitor.monitor_define_list');

        //获取基础套餐价格
        if (!self::instance()->CheckIsExistsPackage($account_id)) {
            $basic_package       = Config::get('tsb_purchase.basic_package');
            $basic_package_price = $basic_package['package_price'];
        } //获取已有套餐的价格
        else {
            $basic_package       = self::instance()->GetPackageInfo($account_id);
            $basic_package_price = 0;
        }
        //获取没增购前的监测点云豆数
        $select_monitor     = array_only($monitor_define_list, $basic_package['monitor']);
        $basic_yundou_count = 0;
        foreach ($select_monitor as $v) {
            $basic_yundou_count += $v[2];
        }

        //获取增购后的监测点云豆数
        $select_add_monitor = array_only($monitor_define_list, $add_monitor);
        $add_yundou_count   = 0;
        foreach ($select_add_monitor as $v) {
            $add_yundou_count += $v[2];
        }
        $all_yundou_count = (int)$basic_yundou_count + (int)$add_yundou_count;

        //增购前套餐总的每个月云豆数
        $basic_website_yundou   = $basic_package['website']['count'] * (60 / $basic_package['website']['frequency']) * 24 * 30 * $basic_yundou_count;
        $basic_mobileapp_yundou = $basic_package['mobile_app']['count'] * (60 / $basic_package['mobile_app']['frequency']) * 24 * 30 * $basic_yundou_count;
        $basic_all_yundou       = $basic_website_yundou + $basic_mobileapp_yundou;
        //增购后套餐总的每个月云豆数
        $all_website_yundou   = ($basic_package['website']['count'] + $add_website_count) * (60 / $add_website_frequency) * 24 * 30 * $all_yundou_count;
        $all_mobileapp_yundou = ($basic_package['mobile_app']['count'] + $add_mobileapp_count) * (60 / $add_mobileapp_frequency) * 24 * 30 * $all_yundou_count;
        $all_yundou           = $all_website_yundou + $all_mobileapp_yundou;

        //获取增购的每个月单价
        $returnData['add_total_price'] = round(($all_yundou - $basic_all_yundou) / $translate_price[1], 2) + $add_host_count * $host_frequency_price[$add_host_frequency];

        //总的增购单价
        $returnData['basic_package_price'] = $basic_package_price;
        $returnData['unit_price']          = $returnData['basic_package_price'] + $returnData['add_total_price'];
        $returnData['total_price']         = $returnData['unit_price'] * $purchase_time;
        $returnData['real_total_price']    = $returnData['total_price'];
        $returnData['status_code'] = ProfessionErrorCodeEnum::PROMO_CODE_NO_USED; //没有使用优惠码
        $returnData['purchase_time'] = $purchase_time;
        //使用优惠码
        if(!empty($promo_code))
        {
            $promo_result = PromoStrategyService::instance()->analyzePromoCode($account_id, $promo_code, $returnData['total_price']);
            $returnData['status_code'] = $promo_result['error_code'];
            if($promo_result['error_code'] == ProfessionErrorCodeEnum::PROMO_STRATEGY_SUCCESS)
            {
                $returnData['real_total_price'] = $promo_result['return_amount'];
                $returnData['promo_strategy'] = $promo_result['promo_strategy'];//优惠策略
                $returnData['promo_value'] = $promo_result['promo_value'];//优惠值
            }else{
                $returnData['promo_error_msg'] = $promo_result['error_msg'];
            }
        }
        return $returnData;
    }

    /**
     * 计算续费套餐的价格
     * @param int   $account_id
     * @param array $input
     * @return array|bool
     */
    public function GetRenewalsPrice($account_id, array $input)
    {
        $package_instance_model = new Package_PackageInstanceModel();
        if (!$package_instance = $package_instance_model->GetPacakageInstance($account_id)) return FALSE;
        //续费单价
        $returnData['renewals_unit_price'] = $package_instance->unit_price; //续费单价
        $returnData['total_price']         = $package_instance->unit_price * $input['renewals_time']; //续费总计
        $returnData['real_total_price']    = $returnData['total_price']; //实际续费总计
        $returnData['status_code'] = ProfessionErrorCodeEnum::PROMO_CODE_NO_USED; //没有使用优惠码
        $returnData['renewals_time'] = $input['renewals_time'];
        $promo_code = trim($input['promo_code']);
        //使用优惠码
        if(!empty($promo_code))
        {
            $promo_result = PromoStrategyService::instance()->analyzePromoCode($account_id, $promo_code, $returnData['total_price']);
            $returnData['status_code'] = $promo_result['error_code'];
            if($promo_result['error_code'] == ProfessionErrorCodeEnum::PROMO_STRATEGY_SUCCESS)
            {
                $returnData['real_total_price'] = $promo_result['return_amount'];
                $returnData['promo_strategy'] = $promo_result['promo_strategy'];//优惠策略
                $returnData['promo_value'] = $promo_result['promo_value'];//优惠值
            }else{
                $returnData['promo_error_msg'] = $promo_result['error_msg'];
            }$promo_result = PromoStrategyService::instance()->analyzePromoCode($account_id, $promo_code, $returnData['total_price']);
            $returnData['status_code'] = $promo_result['error_code'];
            if($promo_result['error_code'] == ProfessionErrorCodeEnum::PROMO_STRATEGY_SUCCESS)
            {
                $returnData['real_total_price'] = $promo_result['return_amount'];
                $returnData['promo_strategy'] = $promo_result['promo_strategy'];//优惠策略
                $returnData['promo_value'] = $promo_result['promo_value'];//优惠值
            }else{
                $returnData['promo_error_msg'] = $promo_result['error_msg'];
            }
        }
        return $returnData;
    }

    /**
     * 把已有的套餐格式化成套餐配置的格式
     * @param int $account_id
     * @return array $package
     */
    public function GetPackageInfo($account_id)
    {
        $package_instance_model = new Package_PackageInstanceModel();
        if (!$package_instance = $package_instance_model->GetPacakageInstance($account_id)) return FALSE;
        $package_instance_id          = $package_instance->package_instance_id;
        $package_instance_items_model = new Package_PackageInstanceItemsModel();
        if (!$package = $package_instance_items_model->GetPackageItems($package_instance_id)) return FALSE;

        foreach ($package as $v) {
            if ($v->package_conf_id == PackageEnum::HOST) $host_count = $v->value;
            if ($v->package_conf_id == PackageEnum::HOST_FREQUENCY) $host_frequency = $v->value;
            if ($v->package_conf_id == PackageEnum::WEBSITE) $website_count = $v->value;
            if ($v->package_conf_id == PackageEnum::WEBSITE_FREQUENCY) $website_frequency = $v->value;
            if ($v->package_conf_id == PackageEnum::MOBILE_APP) $mobileapp_count = $v->value;
            if ($v->package_conf_id == PackageEnum::MOBILE_APP_FREQUENCY) $mobileapp_frequency = $v->value;
            if ($v->package_conf_id == PackageEnum::MONITOR) $monitor = implode(',', json_decode($v->monitor_value, TRUE));
        }

        return array('host'          => array('count' => $host_count, 'frequency' => $host_frequency), //主机
                     'website'       => array('count' => $website_count, 'frequency' => $website_frequency), //网站
                     'mobile_app'    => array('count' => $mobileapp_count, 'frequency' => $mobileapp_frequency), //移动应用
                     'monitor'       => explode(',', $monitor), //默认监测点
                     'package_price' => 0,);

    }

    /**
     * 获取已有套餐的增购时限
     * @param int $account_id
     * @return mixed
     */
    public function GetAddPurchaseTime($account_id)
    {
        $package_instance_model = new Package_PackageInstanceModel();
        if (!$package_instance = $package_instance_model->GetPacakageInstance($account_id)) return FALSE;
        $diff_time = ((int)$package_instance->expired_date - time()) / (24 * 3600 * 30);
        $flag_time = $diff_time - (int)$diff_time;
        if ($flag_time <= 0.5) {
            return floor($diff_time);
        } else {
            return ceil($diff_time);
        }
    }

    /**
     * 生成套餐购买增购订单
     * @param array $package
     * @param       $package_price
     * @param       $order_type
     * @param int   $account_id
     * @param       $user_id
     * @return int $order_id or false
     */
    public function CreateOrder($package, $package_price, $order_type, $account_id, $user_id)
    {
        $submit_package = array();
        $now_time       = time();
        $expired_time   = $now_time + Config::get('tsb_purchase.order_expired_time') * 24 * 3600;
        if (!self::instance()->CheckIsExistsPackage($account_id)) {
            $basic_package                         = Config::get('tsb_purchase.basic_package');
            $submit_package['host_count']          = $basic_package['host']['count'] + $package['add_host_count'];
            $submit_package['host_frequency']      = $package['add_host_count'] ? $package['add_host_frequency'] : $basic_package['host']['frequency'];
            $submit_package['website_count']       = $basic_package['website']['count'] + $package['add_website_count'];
            $submit_package['website_frequency']   = $package['add_website_count'] ? $package['add_website_frequency'] : $basic_package['website']['frequency'];
            $submit_package['mobileapp_count']     = $basic_package['mobile_app']['count'] + $package['add_mobileapp_count'];
            $submit_package['mobileapp_frequency'] = $package['add_mobileapp_count'] ? $package['add_mobileapp_frequency'] : $basic_package['mobile_app']['frequency'];
            $add_monitor                           = empty($package['add_monitor']) ? array() : explode(',', $package['add_monitor']);
            $submit_package['monitor']             = json_encode(array_merge($basic_package['monitor'], $add_monitor));
            $handsel_time                          = Config::get('tsb_purchase.handsel_time');
            //赠送的时间
            $add_time = 0;
            if (array_key_exists((int)$package['purchase_time'], $handsel_time)) $add_time = $handsel_time[$package['purchase_time']];
            $submit_package['package_time'] = $package['purchase_time'] + $add_time;
        } else {
           // $basic_package                         = self::GetPackageInfo($account_id);
            $submit_package['host_count']          = $package['add_host_count'];
            $submit_package['host_frequency']      = $package['add_host_frequency'];
            $submit_package['website_count']       = $package['add_website_count'];
            $submit_package['website_frequency']   = $package['add_website_frequency'];
            $submit_package['mobileapp_count']     = $package['add_mobileapp_count'];
            $submit_package['mobileapp_frequency'] = $package['add_mobileapp_frequency'];
            $add_monitor                           = empty($package['add_monitor']) ? array() : explode(',', $package['add_monitor']);
            $submit_package['monitor']             = json_encode($add_monitor);
            $submit_package['package_time']        = $package['purchase_time'];
        }

        //开启事物
        $base_model = new BaseModel();
        $base_model->transStart();

        //1.生成订单 return order_history_id
        $order['account_id']         = $account_id;
        $order['user_id']            = $user_id;
        $order['code_id']            = empty($package['code_id']) ? 0 : $package['code_id'];
        $order['payment_amount']     = $package_price['real_total_price'];
        $order['order_type']         = $order_type;
        $order['order_time']         = $now_time;
        $order['expired_time']       = $expired_time;
        $order['currency_type']      = PurchaseService::instance()->getCurrencyType();
        $order['package_unit_price'] = $package_price['unit_price'];
        $order_history_model         = new OrderHistory();
        PurchaseService::instance()->setRequestOrderHistoryParams($order);
        $insert_order = $order_history_model->InsertOrderHistory($this->oOrderHistoryInfo);

        if (!$order_history_id = $order_history_model->insert($insert_order)) {
            $base_model->transRollBack();
            return FALSE;
        }

        //2.对应订单中的商品
        $all_commodity = array();
        foreach ($submit_package as $key => $value) {
            $commodity                     = array();
            $commodity['order_history_id'] = $order_history_id;
            if ($key == 'host_count') {
                $commodity['package_conf_id'] = PackageEnum::HOST;
            } elseif ($key == 'host_frequency') {
                $commodity['package_conf_id'] = PackageEnum::HOST_FREQUENCY;
            } elseif ($key == 'website_count') {
                $commodity['package_conf_id'] = PackageEnum::WEBSITE;
            } elseif ($key == 'website_frequency') {
                $commodity['package_conf_id'] = PackageEnum::WEBSITE_FREQUENCY;
            } elseif ($key == 'mobileapp_count') {
                $commodity['package_conf_id'] = PackageEnum::MOBILE_APP;
            } elseif ($key == 'mobileapp_frequency') {
                $commodity['package_conf_id'] = PackageEnum::MOBILE_APP_FREQUENCY;
            } elseif ($key == 'package_time') {
                $commodity['package_conf_id'] = PackageEnum::PACKAGE_TIME;
            }
            $commodity['value']         = $value;
            $commodity['monitor_value'] = '';
            if ($key == 'monitor') {
                $commodity['package_conf_id'] = PackageEnum::MONITOR;
                $commodity['value']           = '';
                $commodity['monitor_value']   = $value;
            }
            array_push($all_commodity, $commodity);
        }

        $OrderCommodity = new OrderCommodity();
        if (!$OrderCommodity->InsertOrderCommodity($all_commodity)) {
            $base_model->transRollBack();
            return FALSE;
        }

        //提交事物
        $base_model->transCommit();
        return $order_history_id;
    }

    /**
     * 生成套餐续费订单
     * @param $order_data
     * @return bool|int
     */
    public function CreateRenewalsOrder(array $order_data)
    {
        $now_time                    = time();
        $expired_time                = $now_time + Config::get('tsb_purchase.order_expired_time') * 24 * 3600;
        $order['account_id']         = $order_data['account_id'];
        $order['user_id']            = $order_data['user_id'];
        $order['code_id']            = empty($order_data['code_id']) ? 0 : $order_data['code_id'];
        $order['payment_amount']     = $order_data['real_total_price'];
        $order['order_type']         = OrderEnum::ORDER_TYPE_RENEWALS;
        $order['order_time']           = $now_time;
        $order['expired_time']       = $expired_time;
        $order['currency_type']      = PurchaseService::instance()->getCurrencyType();
        $order['package_unit_price'] = $order_data['renewals_unit_price'];

        $base_model = new BaseModel();
        //开启事物
        $base_model->transStart();
        $order_history_model         = new OrderHistory();
        PurchaseService::instance()->setRequestOrderHistoryParams($order);
        $insert_order = $order_history_model->InsertOrderHistory($this->oOrderHistoryInfo);
        if (!$order_history_id = $order_history_model->insert($insert_order)) {
            $base_model->transRollBack();
            return FALSE;
        }

        $OrderCommodity                = new OrderCommodity();
        $all_commodity                 = array();
        $commodity['order_history_id'] = $order_history_id;
        $commodity['package_conf_id']  = PackageEnum::PACKAGE_TIME;
        $commodity['value']            = $order_data['renewals_time'];
        $commodity['monitor_value']    = '';
        array_push($all_commodity, $commodity);
        if (!$OrderCommodity->InsertOrderCommodity($all_commodity)) {
            $base_model->transRollBack();
            return FALSE;
        }
        //提交事物
        $base_model->transCommit();
        return $order_history_id;
    }


    /**
     * 获取账号下的所有历史订单
     * @param int $account_id
     * @return object $order_history or FALSE
     */
    public function GetOrderHistoryList($account_id)
    {
        if (empty($account_id)) return FALSE;
        $order_history_model = new OrderHistory();
        $order_history       = $order_history_model->GetOrderHistoryByAccountId($account_id);
        if ($order_history) return $order_history;
        return FALSE;
    }

    /**
     * 获取套餐购买或增购订单详细内容
     * @param int $order_id
     * @return object $details
     */
    public function GetOrderDetails($order_id)
    {
        $details             = array();
        $order_history_model = new OrderHistory();
        if (!$order = $order_history_model->GetOrderHistoryById($order_id)) return FALSE;

        //订单中包含的项目
        $order_commodity_model = new OrderCommodity();
        if (!$commodity = $order_commodity_model->GetCommodityByOrderId($order_id)) return FALSE;

        $details['order']['order_number']   = $order->order_id;
        $details['order']['order_time']     = FormatTimeSpall::YmdHi($order->order_time);
        $details['order']['payment_amount'] = CurrencyEnum::$CurrencyFormat[$order->currency_type] . $order->payment_amount;
        $details['order']['order_status']   = OrderEnum::$order_status[$order->order_status];

        foreach ($commodity as $key => $value) {
            $temp_data = array();
            if ($value->package_conf_id != PackageEnum::MONITOR) {
                $temp_data['name']  = PackageEnum::$packageEnum[$value->package_conf_id];
                $temp_data['value'] = $value->value;
            }
            if ($value->package_conf_id == PackageEnum::MONITOR) {
                $temp_data['name']   = PackageEnum::$packageEnum[$value->package_conf_id];
                $monitor             = json_decode($value->monitor_value);
                $monitor_define_list = Config::get('tsb_monitor.monitor_define_list');
                $select_monitor      = array_only($monitor_define_list, $monitor);
                foreach ($select_monitor as $v) {
                    $temp_data['value'][] = $v[1];
                }

            }
            $details['commodity'][$value->package_conf_id] = $temp_data;
            unset($temp_data);
        }
        return $details;
    }

    /**
     * 获取套餐购买或增购订单详细内容
     * @param int $order_id
     * @return object $details
     */
    public function GetOrderDetailsView($order_id)
    {
        $details             = array();
        $order_history_model = new OrderHistory();
        if (!$order = $order_history_model->GetOrderHistoryById($order_id)) return FALSE;

        //订单中包含的项目
        $order_commodity_model = new OrderCommodity();
        if (!$commodity = $order_commodity_model->GetCommodityByOrderId($order_id)) return FALSE;

        $details['order']['order_number']   = $order->order_id;
        $details['order']['order_time']     = FormatTimeSpall::YmdHi($order->order_time);
        $details['order']['payment_amount'] = CurrencyEnum::$CurrencyFormat[$order->currency_type] . $order->payment_amount;
        $details['order']['order_status']   = OrderEnum::$order_status[$order->order_status];
        $temp_data = array();
        foreach ($commodity as $key => $value) {

            if ($value->package_conf_id != PackageEnum::MONITOR) {
                $temp_data[$value->package_conf_id]  = $value->value;
            }
            if ($value->package_conf_id == PackageEnum::MONITOR) {
                $monitor             = json_decode($value->monitor_value);
                $monitor_define_list = Config::get('tsb_monitor.monitor_define_list');
                $select_monitor      = array_only($monitor_define_list, $monitor);
                $temp_data[$value->package_conf_id]['yundou'] = 0;
                $temp_data[$value->package_conf_id]['monitor_count'] = 0;
                foreach ($select_monitor as $k=>$v) {
                    $temp_data[$value->package_conf_id]['yundou'] += $v[2];
                    $temp_data[$value->package_conf_id]['monitor_count'] += 1;
                    foreach(MonitorEnum::$monitorsByGroupArea as $k1=>$v1){
                       $select_monitor[$k]['area_name'] = '无';
                       if(in_array($k,$v1)) {
                           $select_monitor[$k]['area_name'] = MonitorEnum::$monitorGroupsArea[$k1];
                           break;
                       }
                    }
                }
                $temp_data[$value->package_conf_id]['select_monitor']  = $select_monitor;
            }
        }
        $details['commodity'] = $temp_data;
        return $details;
    }

    /**
     * 获取套餐续费订单的详情
     * @param $order_id
     * @return bool
     */
    public function GetRenewalsOrderDetails($order_id)
    {
        $order_history_model = new OrderHistory();
        if (!$order = $order_history_model->GetOrderHistoryById($order_id)) return FALSE;

        $details['order_number']   = $order->order_id;
        $details['order_time']     = FormatTimeSpall::YmdHi($order->order_time);
        $details['payment_amount'] = CurrencyEnum::$CurrencyFormat[$order->currency_type] . $order->payment_amount;
        $details['order_status']   = OrderEnum::$order_status[$order->order_status];
        return $details;
    }

    public function GetRenewalsPackageDetails($account_id){
        $package_instance_model = new Package_PackageInstanceModel();
        $instance_info = $package_instance_model->GetPacakageInstance($account_id);
        $package_instance_items_model = new Package_PackageInstanceItemsModel();
        $commodity = $package_instance_items_model->GetPackageItems($instance_info->package_instance_id);

        $return_data = array();
        foreach ($commodity as $key => $value) {

            if ($value->package_conf_id != PackageEnum::MONITOR) {
                $return_data[$value->package_conf_id]  = $value->value;
            }
            if ($value->package_conf_id == PackageEnum::MONITOR) {
                $monitor             = json_decode($value->monitor_value);
                $monitor_define_list = Config::get('tsb_monitor.monitor_define_list');
                $select_monitor      = array_only($monitor_define_list, $monitor);
                $return_data[$value->package_conf_id]['yundou'] = 0;
                $return_data[$value->package_conf_id]['monitor_count'] = 0;
                foreach ($select_monitor as $k=>$v) {
                    $return_data[$value->package_conf_id]['yundou'] += $v[2];
                    $return_data[$value->package_conf_id]['monitor_count'] += 1;
                    foreach(MonitorEnum::$monitorsByGroupArea as $k1=>$v1){
                        $select_monitor[$k]['area_name'] = '无';
                        if(in_array($k,$v1)) {
                            $select_monitor[$k]['area_name'] = MonitorEnum::$monitorGroupsArea[$k1];
                            break;
                        }
                    }
                }
                $return_data[$value->package_conf_id]['select_monitor']  = $select_monitor;
            }
        }
        return $return_data;
    }

    /**
     * 余额结算
     * @param int $order_id
     * @param int $account_id
     * @return bool TRUE OR FALSE
     */
    public function BalanceSettlement($account_id, $order_id)
    {
        $order_history_model   = new OrderHistory();
        $order_info            = $order_history_model->GetOrderHistoryById($order_id);
        $account_balance = UserService::instance()->getAccountBalance($account_id);

        //检查账户余额是否足够支付
        if ($account_balance->balance_value < $order_info->payment_amount) return FALSE;
        //1.从账户余额中扣除订单金额
        $balance_value  = $account_balance->balance_value - $order_info->payment_amount;
        if (!UserService::instance()->updateAccountBalance($account_id, $balance_value)) return FALSE;
        //2.修改订单的状态和支付时间
        $update_order = array('order_status' => OrderEnum::ORDER_PAYMENT_STATUS, 'pay_time' => time(),'pay_type'=>OrderEnum::SETTLEMENT_BALANCE_TYPE);
        if (!$order_history_model->UpdateOrderHistory($account_id, $order_id,$update_order)) return FALSE;
        return TRUE;
    }

    /**
     * 将用户订单内容更新至用户套餐中
     * @param int $order_id
     * @param int $account_id
     * @return bool TRUE OR FALSE
     */
    public function OrderPutPackage($account_id, $order_id)
    {
        $now_time              = time();
        $order_commodity_model = new OrderCommodity();
        //用户付费套餐不存在时
        if (!self::instance()->CheckIsExistsPackage($account_id)) {
             // 不存在试用套餐时，将订单中的项目更新至套餐中
            if(!PackageInstanceService::instance()->orderInsertToPackage($account_id,$order_id)) return false;

        } //用户付费套餐存在时
        else {
            $order_history_model = new OrderHistory();
            $order_history_info  = $order_history_model->GetOrderHistoryById($order_id);
            //增购
            if ($order_history_info->order_type == OrderEnum::ORDER_TYPE_ADD) {
                $package_instance_model                 = new Package_PackageInstanceModel();
                $package_instance_info                  = $package_instance_model->GetPacakageInstance($account_id);
                $package_instance_id                    = $package_instance_info->package_instance_id;
                $package_instance['price']              = $package_instance_info->price + $order_history_info->payment_amount;
                $package_instance['add_purchase_count'] = $package_instance_info->add_purchase_count + 1;
                $package_instance['unit_price']         = $package_instance_info->unit_price + $order_history_info->package_unit_price;
                if (!$package_instance_model->UpdatePackageInstance($account_id, $package_instance)) return FALSE;

                $package_instance_items_model = new Package_PackageInstanceItemsModel();
                $package_items                = $package_instance_items_model->GetPackageItems($package_instance_id);
                //更新套餐填充项目
                $commodity = $order_commodity_model->GetCommodityByOrderId($order_id);

                $package_instance_items = array();
                foreach ($commodity as $v) {
                    foreach ($package_items as $item) {
                        if ($v->package_conf_id == $item->package_conf_id) {
                            $temp                      = array();
                            $package_instance_items_id = $item->package_instance_items_id;
                            if ($v->package_conf_id == PackageEnum::HOST || $v->package_conf_id == PackageEnum::WEBSITE || $v->package_conf_id == PackageEnum::MOBILE_APP) {
                                $temp['value'] = (int)($item->value + $v->value);
                            }
                            if ($v->package_conf_id == PackageEnum::HOST_FREQUENCY || $v->package_conf_id == PackageEnum::WEBSITE_FREQUENCY || $v->package_conf_id == PackageEnum::MOBILE_APP_FREQUENCY) {
                                $temp['value'] = (int)$v->value;
                            }
                            if ($v->package_conf_id == PackageEnum::MONITOR) {
                                $temp['monitor_value'] = json_encode(array_merge(json_decode($item->monitor_value, TRUE), json_decode($v->monitor_value, TRUE)));
                            }
                            if ($v->package_conf_id == PackageEnum::PACKAGE_TIME) $temp['value'] = (int)$item->value;
                            if (-1 == $package_instance_items_model->UpdatePackageItems($package_instance_items_id, $temp)) return FALSE;
                            unset($temp);
                            break;
                        }
                    }
                }
            } //续费
            elseif ($order_history_info->order_type == OrderEnum::ORDER_TYPE_RENEWALS) {
                //获取套餐时间
                $package_time                     = $order_commodity_model->GetOneCommodity($order_id, PackageEnum::PACKAGE_TIME);
                $package_instance_model           = new Package_PackageInstanceModel();
                $package_instance_info            = $package_instance_model->GetPacakageInstance($account_id);
                $package_instance['expired_date'] = $package_instance_info->expired_date + $package_time->value * 24 * 30;
                if (!$package_instance_model->UpdatePackageInstance($account_id, $package_instance)) return FALSE;
            }

        }
        return TRUE;
    }
}