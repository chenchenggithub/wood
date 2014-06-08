<?php
/**
 *
 * Class PackageInstanceService
 */
class PackageInstanceService extends BaseService
{
    private static $self = NULL;

    /**
     *
     * @return PackageInstanceService
     */
    static public function instance()
    {
        if (self::$self == NULL) {
            self::$self = new self;
        }

        return self::$self;
    }

    /**
     * @var Package_PackageInstanceModel
     */
    private $mPackgeInstance = NULL;

    private function __construct()
    {
        $this->mPackgeInstance = new Package_PackageInstanceModel();
    }

    /**
     * 计算套餐已过期的account列表
     * @return array
     */
    public function processOfflineAccount()
    {
        $aWhere = array('expired_date <= ?' => time(),);

        $this->mPackgeInstance->setSelect(array('account_id'));

        $list = $this->mPackgeInstance->fetchAll($aWhere);

        $result = array();

        foreach ($list as $items) {
            $result[] = $items->account_id;
        }
        return $result;
    }

    /**
     * 检测account是否试用套餐
     * @param $iAccountId
     * @throws Exception
     * @return bool
     */
    public function processIfTrialByAccountId($iAccountId)
    {
        $aWhere = array(
            'account_id' => $iAccountId,
        );

        $result = $this->mPackgeInstance->fetchRow($aWhere);
        if (!$result || empty($result)) throw new Exception('不存在该用户的套餐', ErrorCodeEnum::STATUS_SUCCESS_DO_ERROR_DB_RFALSE);

        if ($result->package_type == PackageEnum::PACKAGE_TYR_TYPE) return TRUE;
        return FALSE;
    }

    /**
     * 导入试用套餐
     * @param $account_id
     * @return bool
     */
    public function insertTryPackage($account_id)
    {
        $trial_package                    = Config::get('tsb_purchase.trial_package');
        $monitor                          = json_encode($trial_package['monitor']);
        $package_instance_model           = new Package_PackageInstanceModel();
        $package_instance['account_id']   = $account_id;
        $package_instance['price']        = 0;
        $package_instance['expired_date'] = time() + $trial_package['expired_time'] * 24 * 3600;
        $package_instance['create_time']  = time();
        $package_instance['package_type'] = PackageEnum::PACKAGE_TYR_TYPE;

        if (!$package_instance_id = $package_instance_model->InsertPackageInstance($package_instance)) return FALSE;
        $insert_datas = array();
        foreach ($trial_package as $k => $v) {
            if ($k == 'host') {
                array_push($insert_datas, array('package_instance_id' => $package_instance_id, 'package_conf_id' => PackageEnum::HOST,
                                                'value'               => $v['count'], 'monitor_value' => ''));
                array_push($insert_datas, array('package_instance_id' => $package_instance_id, 'package_conf_id' => PackageEnum::HOST_FREQUENCY,
                                                'value'               => $v['frequency'], 'monitor_value' => ''));
            }
            if ($k == 'website') {
                array_push($insert_datas, array('package_instance_id' => $package_instance_id, 'package_conf_id' => PackageEnum::WEBSITE,
                                                'value'               => $v['count'], 'monitor_value' => ''));
                array_push($insert_datas, array('package_instance_id' => $package_instance_id, 'package_conf_id' => PackageEnum::WEBSITE_FREQUENCY,
                                                'value'               => $v['frequency'], 'monitor_value' => ''));
            }
            if ($k == 'mobile_app') {
                array_push($insert_datas, array('package_instance_id' => $package_instance_id, 'package_conf_id' => PackageEnum::MOBILE_APP,
                                                'value'               => $v['count'], 'monitor_value' => ''));
                array_push($insert_datas, array('package_instance_id' => $package_instance_id, 'package_conf_id' => PackageEnum::MOBILE_APP_FREQUENCY,
                                                'value'               => $v['frequency'], 'monitor_value' => ''));
            }
            if ($k == 'monitor') {
                array_push($insert_datas, array('package_instance_id' => $package_instance_id, 'package_conf_id' => PackageEnum::MOBILE_APP,
                                                'value'               => '', 'monitor_value' => $monitor));
            }
        }
        $package_instance_items_model = new Package_PackageInstanceItemsModel();
        if (!$package_instance_items_model->InsertPackageInstanceItems($insert_datas)) return FALSE;
        return $package_instance_id;
    }

    /**
     * 获取套餐的监测点
     * @param $account_id
     * @return array
     */
    public function getPackageMonitor($account_id)
    {
        if (self::processIfTrialByAccountId($account_id)) {

            $trial_package = Config::get('tsb_purchase.trial_package');
            $monitor       = $trial_package['monitor'];

        } else {
            $instance_model = new Package_PackageInstanceModel();
            $instance_info  = $instance_model->GetPacakageInstance($account_id);
            if (empty($instance_info)) return FALSE;
            $instance_items_modle = new Package_PackageInstanceItemsModel();
            $instance_items_info  = $instance_items_modle->getPackageMonitor($instance_info->package_instance_id);
            $monitor              = json_decode($instance_items_info->monitor_value, TRUE);
        }


        if (!is_array($monitor) || count($monitor) < 1) return array();

        $monitorResult       = array();
        $monitor_define_list = Config::get('tsb_monitor.monitor_define_list');
        foreach ($monitor as $monitor_id) {
            $monitorResult[$monitor_id] = $monitor_define_list[$monitor_id];
        }

        return $monitorResult;
    }

    /**
     * 存在试用套餐时，将订单中的项目更新至套餐中
     */
    public function orderInsertToPackage($account_id, $order_id)
    {
        $now_time              = time();
        $order_commodity_model = new OrderCommodity();
        //获取套餐时间
        $package_time        = $order_commodity_model->GetOneCommodity($order_id, PackageEnum::PACKAGE_TIME);
        $order_history_model = new OrderHistory();
        $order_history_info  = $order_history_model->GetOrderHistoryById($order_id);
        $handsel_time      = Config::get('tsb_purchase.handsel_time'); //计算赠送的时间
        $real_package_time = isset($handsel_time[$package_time->value]) ?($handsel_time[$package_time->value] + $package_time->value) : $package_time->value;

        //创建套餐
        $package_instance_model           = new Package_PackageInstanceModel();
        $package_instance['price']        = $order_history_info->payment_amount;
        $package_instance['expired_date'] = $now_time + $real_package_time * 24 * 30 * 3600;
        $package_instance['create_time']  = $now_time;
        $package_instance['package_type'] = PackageEnum::PACKAGE_PAY_TYPE;
        $package_instance['unit_price']   = $order_history_info->package_unit_price;
        if (-1 == $package_instance_model->UpdatePackageInstance($account_id, $package_instance)) return FALSE;
        $instance_info       = $package_instance_model->GetPacakageInstance($account_id);
        $package_instance_id = $instance_info->package_instance_id;

        //为套餐填充项目
        $commodity              = $order_commodity_model->GetCommodityByOrderId($order_id);
        $package_instance_items = array();
        foreach ($commodity as $v) {
            $temp                        = array();
            $temp['package_instance_id'] = $package_instance_id;
            $temp['package_conf_id']     = $v->package_conf_id;
            $temp['value']               = $v->value;
            $temp['monitor_value']       = $v->monitor_value;
            array_push($package_instance_items, $temp);
        }
        $package_instance_items_model = new Package_PackageInstanceItemsModel();
        $package_instance_items_model->delPackageItems($package_instance_id);
        if (!$package_instance_items_model->InsertPackageInstanceItems($package_instance_items)) return FALSE;
        return TRUE;
    }


}