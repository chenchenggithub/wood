<?php
use Whoops\Example\Exception;

class BuyPackageController extends BaseController
{
    /**
     * 购买页面的展示
     * @return bool
     */
    public function showBuy()
    {
        $user_info = UserService::instance()->getUserCache();

        //场景1：用户不存在套餐
        $account_id          = $user_info->account_id;
        $tsb_purchase_conf   = Config::get('tsb_purchase');
        $monitor_define_list = Config::get('tsb_monitor.monitor_define_list');

        $purchase_time     = $tsb_purchase_conf['purchase_time'];
        $handsel_time      = $tsb_purchase_conf['handsel_time'];
        $default_add_count = $tsb_purchase_conf['default_add_count'];

        $renewals_purchase_time = array();
        if (!PurchaseService::instance()->CheckIsExistsPackage($account_id)) {
            $is_has_package = FALSE;
            //获取基础套餐配置
            $basic_package          = $tsb_purchase_conf['basic_package'];
            $add_purchase_frequency = $tsb_purchase_conf['add_purchase_frequency'];
            //默认给的监测点
            $select_monitor = array_only($monitor_define_list, $basic_package['monitor']);

            //默认监测点的云豆数
            $basic_yundou_count = 0;
            foreach ($select_monitor as $v) {
                $basic_yundou_count += $v[2];
            }
            //格式化增购购买时限
            $add_purchase_time = $this->FormatPurchaseTime($purchase_time, $handsel_time);
            //增购次数
            $add_purchase_count = 0;
            //续费单价
            $renewals_unit_price = 0;
        } //场景2：用户已经存在套餐
        else {
            $is_has_package = TRUE;
            $basic_package  = PurchaseService::instance()->GetPackageInfo($account_id);
            //增购购买时限
            $add_purchase_time = PurchaseService::instance()->GetAddPurchaseTime($account_id);
            //续费购买时间
            $renewals_purchase_time = $this->FormatPurchaseTime($purchase_time, $handsel_time);
            //增购允许选择的频率
            $add_purchase_frequency = $this->GetAllowAddFrequency($basic_package);
            //已有的监测点
            $select_monitor = array_only($monitor_define_list, $basic_package['monitor']);

            //增购次数
            $package_instance_model = new Package_PackageInstanceModel();
            if (!$package_instance = $package_instance_model->GetPacakageInstance($account_id)) return FALSE;
            $add_purchase_count = $package_instance->add_purchase_count;
            //续费单价
            $renewals_unit_price = $package_instance->unit_price;
            //监测点的云豆数
            $basic_yundou_count = 0;
            foreach ($select_monitor as $v) {
                $basic_yundou_count += $v[2];
            }
        }
        //默认的云豆数
        $basic_yundou_count = 0;
        foreach ($select_monitor as $v) {
            $basic_yundou_count += $v[2];
        }

        $this->view('purchase.buy')
             ->with('package', $basic_package)
             ->with('is_has_package', $is_has_package)
             ->with('add_purchase_frequency', $add_purchase_frequency)
             ->with('basic_yundou_count', $basic_yundou_count)
             ->with('renewals_purchase_time', $renewals_purchase_time)
             ->with('add_purchase_count', $add_purchase_count)
             ->with('default_add_count', $default_add_count)
             ->with('renewals_unit_price', $renewals_unit_price)
             ->with('add_purchase_time', $add_purchase_time)
             ->with(array(
                'leftLeafMenu' => UserMenuEnum::getLeftLeafMenu(),
                'menuGroup'    => UserMenuEnum::getMenuGroups(),
            ));
    }

    /**
     * 加载查看的监测点
     */
    public function ajaxLoadShowMonitor(){
        $user_info = UserService::instance()->getUserCache();
        $account_id          = $user_info->account_id;
        $monitor = PurchaseService::instance()->getBuyMonitor($account_id);
        $yundou_count = 0;
        $select_monitor_count = 0;
        foreach ($monitor['select_monitor'] as $v) {
            $yundou_count += $v[2];
            $select_monitor_count++;
        }

        $this->viewAjax('purchase.ajaxTemplate.ajax_buy_show_monitor')
             ->with('monitor',json_encode($monitor))
             ->with('select_monitor_count',$select_monitor_count)
             ->with('page_num',10)//分页数是10
             ->with('yundou_count',$yundou_count);
    }

    /**
     * 加载设置的监测点
     */
    public function ajaxLoadSettingMonitor(){
        $user_info = UserService::instance()->getUserCache();
        $account_id          = $user_info->account_id;
        $monitor = PurchaseService::instance()->getBuyMonitor($account_id);
        $yundou_count = 0;
        $select_monitor_count = 0;
        foreach ($monitor['select_monitor'] as $v) {
            $yundou_count += $v[2];
            $select_monitor_count++;
        }
        $this->viewAjax('purchase.ajaxTemplate.ajax_buy_setting_monitor')
             ->with('monitor',json_encode($monitor))
             ->with('select_monitor_count',$select_monitor_count)
             ->with('page_num',10)//分页数是10
             ->with('yundou_count',$yundou_count);
    }


    /**
     * AjaxPost方式获取增购套餐的价格
     * @param void
     * @return void
     */
    public function ajaxGetPackagePrice()//AjaxgetPackagePrice
    {
        $user_info = UserService::instance()->getUserCache();
        $account_id           = $user_info->account_id;
        $input                = $this->params;
        $input['add_monitor'] = trim($input['add_monitor'], ',');
        $returnData           = PurchaseService::instance()->CalculatePackage($input, $account_id);
        if (!$returnData) {
            RESTService::instance()->error('获取续费单价失败!', ErrorCodeEnum::STATUS_SUCCESS_DO_ERROR_DB);
            exit();
        }
        $this->rest->success($returnData);
    }

    /**
     * AjaxPost方式获取续费套餐的价格
     * @param void
     * @return void
     */
    public function AjaxGetRenewalsPrice()
    {
        $user_info = UserService::instance()->getUserCache();
        $input      = Input::all();
        $account_id = $user_info->account_id;
        $returnData = PurchaseService::instance()->GetRenewalsPrice($account_id, $input);
        if (!$returnData) {
            RESTService::instance()->error('获取续费单价失败!', ErrorCodeEnum::STATUS_SUCCESS_DO_ERROR_DB);
            exit();
        }
        $this->rest->success($returnData);
    }

    /**
     * 格式化购买时间
     * @param array $purchase_time
     * @param array $handsel_time
     * @return array $returnData
     */
    private function FormatPurchaseTime($purchase_time, $handsel_time)
    {
        $returnData   = array();
        $show_content = '';
        foreach ($purchase_time as $v) {
            if ($v < 12) {
                $show_content = $v . '个月';
                if (isset($handsel_time[$v])) $show_content = $v . '个月(送' . $handsel_time[$v] . '个月)';
            } else {
                $show_content = ($v / 12) . '年';
                if (isset($handsel_time[$v])) $show_content = ($v / 12) . '年（送' . $handsel_time[$v] . '个月)';
            }
            $returnData[$v] = $show_content;
        }
        return $returnData;
    }

    /**
     * 获取允许增购的频率
     * @param array $basic_package
     * @return multitype:NULL
     */
    private function GetAllowAddFrequency(array $basic_package)
    {
        $add_purchase_frequency         = array();
        $default_add_frequency          = Config::get('tsb_purchase.add_purchase_frequency');
        $temp_host                      = array_flip($default_add_frequency['host']);
        $host_length                    = $temp_host[$basic_package['host']['frequency']] + 1;
        $add_purchase_frequency['host'] = array_slice($default_add_frequency['host'], 0, $host_length);

        $temp_website                      = array_flip($default_add_frequency['website']);
        $website_length                    = $temp_website[$basic_package['website']['frequency']] + 1;
        $add_purchase_frequency['website'] = array_slice($default_add_frequency['website'], 0, $website_length);

        $temp_mobileapp                      = array_flip($default_add_frequency['mobileapp']);
        $mobileapp_length                    = $temp_mobileapp[$basic_package['mobile_app']['frequency']] + 1;
        $add_purchase_frequency['mobileapp'] = array_slice($default_add_frequency['mobileapp'], 0, $mobileapp_length);

        return $add_purchase_frequency;
    }


}