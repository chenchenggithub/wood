<?php
/**
 * 服务维护相关
 *
 * @author Neeke.Gao
 * Date: 14-5-15 下午7:01
 */
class Project_ServiceController extends BaseController
{

    /**
     * 网站服务项目添加更新
     */
    public function ServiceSiteModifyApi()
    {
        $this->params['app_id']       = 1;
        $this->params['account_id']   = $this->getUserInfo()->account_id;
        $this->params['target_id']    = $this->params['domain_id'];
        $this->params['target_type']  = ServiceSchedulerConfigExtEnum::TARGET_TYPE_DOMAIN;
        $this->params['frequency']    = 2;
        $this->params['monitor_list'] = array_keys(PackageInstanceService::instance()->getPackageMonitor($this->getUserInfo()->account_id));

        SiteService::instance()->setRequestRsServiceParams($this->params);
        SiteService::instance()->ckIfServiceCanModify();

        SchedulerConfigExtService::instance()->setRequestRsServiceParams($this->params);
        SchedulerConfigExtService::instance()->setConfigExtRequest($this->params);
        $result = SchedulerConfigExtService::instance()->configExtModify();
        $this->rest->success($result);
    }

    public function siteGet()
    {

    }

    /**
     * 网站页面服务项目添加更新
     */
    public function ServicePageModifyApi()
    {
        $this->params['app_id']       = 1;
        $this->params['account_id']   = $this->getUserInfo()->account_id;
        $this->params['target_id']    = $this->params['page_id'];
        $this->params['target_type']  = ServiceSchedulerConfigExtEnum::TARGET_TYPE_PAGE;
        $this->params['frequency']    = 2;
        $this->params['monitor_list'] = array_keys(PackageInstanceService::instance()->getPackageMonitor($this->getUserInfo()->account_id));

        PageService::instance()->setRequestPageParams($this->params);
        PageService::instance()->ckIfServiceCanModify();

        SchedulerConfigExtService::instance()->setRequestRsServicePageParams($this->params);
        SchedulerConfigExtService::instance()->setConfigExtRequest($this->params);
        $result = SchedulerConfigExtService::instance()->configExtModify();
        $this->rest->success($result);
    }

    public function pageGet()
    {

    }

    /**
     * 获取服务项目配置表单
     */
    public function ShowServiceSetting()
    {
        $app_id       = $this->getParam('app_id');
        $target_type  = $this->getParam('target_type');
        $target_id    = $this->getParam('target_id');
        $service_type = $this->getParam('service_type');

        $configExt = SchedulerConfigExtService::instance()->getConfigByTargetIdAndServiceType($app_id, $target_type, $target_id, $service_type);

        $data = array(
            'monitor_list'       => array(),
            'monitor_list_count' => 0,
            'frequency'          => ProjectEnum::PAGE_FREQUENCY_DEFAULT,
        );

        if (!is_null($configExt) && is_array($configExt->ext_value) && array_key_exists('monitor_list', $configExt->ext_value)) {
            $data['monitor_list']       =
                is_array($configExt->ext_value['monitor_list'])
                    ? $configExt->ext_value['monitor_list']
                    : json_decode($configExt->ext_value['monitor_list'], TRUE);
            $data['monitor_list_count'] = count($data['monitor_list']);
            $data['frequency']          = $configExt->ext_value['frequency'];
        }

        $data['monitor_list_default']       = array_keys(PackageInstanceService::instance()->getPackageMonitor($this->getUserInfo()->account_id));
        $data['monitor_list_default_count'] = count($data['monitor_list_default']);
        $data['frequency_default']          = ProjectEnum::PAGE_FREQUENCY_DEFAULT;

        return $this->view('project.serviceSetting.monitor_modal')->with(
            array(
                'app_id'       => $app_id,
                'target_type'  => $target_type,
                'target_id'    => $target_id,
                'service_type' => $service_type,
                'data'         => $data,
            )
        );
    }

    /**
     * 更新服务项目调度配置
     */
    public function ServiceSettingModifyApi()
    {
        $this->params['account_id'] = $this->getUserInfo()->account_id;

        if ($this->getParam('target_type') == ServiceSchedulerConfigExtEnum::TARGET_TYPE_DOMAIN) {
            $this->params['domain_id'] = $this->getParam('target_id');

            SiteService::instance()->setRequestRsServiceParams($this->params);
            SiteService::instance()->ckIfServiceCanModify();

            SchedulerConfigExtService::instance()->setRequestRsServiceParams($this->params);
            SchedulerConfigExtService::instance()->setConfigExtRequest($this->params);
            $result = SchedulerConfigExtService::instance()->configExtModify();

        } else {
            $this->params['page_id'] = $this->getParam('target_id');

            PageService::instance()->setRequestPageParams($this->params);
            PageService::instance()->ckIfServiceCanModify();

            SchedulerConfigExtService::instance()->setRequestRsServicePageParams($this->params);
            SchedulerConfigExtService::instance()->setConfigExtRequest($this->params);
            $result = SchedulerConfigExtService::instance()->configExtModify();
        }

        $this->rest->success($result);
    }
}