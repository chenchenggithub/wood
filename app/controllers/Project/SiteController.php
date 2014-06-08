<?php
/**
 * @author Neeke.Gao
 * Date: 14-5-14 上午11:07
 */

class Project_SiteController extends BaseController
{

    public function SiteList()
    {
        $aSiteInfoList = SiteService::instance()->getSiteList();
        $this->view('project.site_list')->with(
            array(
                'aSiteInfoList' => $aSiteInfoList,
            )
        );
    }

    public function showBoard()
    {
        $domain_id = $this->getParam('domain_id');

        $this->view('project.site_board')->with(
            array(
                'tab'       => Request::segment(3),
                'domain_id' => $domain_id,
            )
        );
    }

    /**
     * 获取可添加的使用监测点
     */
    public function apiGetMonitorListCanUse()
    {
        $monitorList = PackageInstanceService::instance()->getPackageMonitor($this->getUserInfo()->account_id);
        $baseInfo    = SiteService::instance()->baseInfoGet(146);

        $monitorCanUse = array_diff($monitorList, $baseInfo->monitor_list_default);

        return $this->rest->success($monitorCanUse);
    }

    /**
     * 创建表单
     */
    public function showDomainCreate()
    {
        $this->view('project.site')->with(array(
            'create'      => TRUE,
            'form_action' => '/api/site/create',
        ));
    }

    /**
     * 修改表单
     */
    public function showDomainModify()
    {
        $iDomainId = (int)$this->getParam('domain_id');

        if ($iDomainId < 1) {
            throw new Exception('参数非法', ErrorCodeEnum::STATUS_ERROR_PARAMS_MUST);
        }

        $baseInfo = SiteService::instance()->baseInfoGet($iDomainId);

        if (!$baseInfo) {
            throw new Exception(NULL, ErrorCodeEnum::STATUS_SUCCESS_DO_ERROR_DB_NULL);
        }

        $serviceStatus = SiteService::instance()->getServicesByDomainId($iDomainId);
        $pageList      = PageService::instance()->pageList($iDomainId);

        $this->view('project.site')->with(array(
            'json_config'    => array(
                'app_id'      => $baseInfo->app_id,
                'domain_id'   => $baseInfo->domain_id,
                'site_name'   => $baseInfo->site_name,
                'site_domain' => $baseInfo->site_domain,
                'status'      => $baseInfo->status,
                'modify'      => TRUE,
            ),
            'form_action'    => '/api/site/modify',
            'baseInfo'       => $baseInfo,
            'service_status' => $serviceStatus,
            'page_list'      => $pageList,
        ));
    }

    /**
     * 创建接口
     */
    public function SiteCreateApi()
    {
        $this->rest->method('POST');

        $this->params['account_id'] = $this->getUserInfo()->account_id;
        $this->params['app_id']     = 1;

        $this->params['monitor_list_default'] = array_keys(PackageInstanceService::instance()->getPackageMonitor($this->getUserInfo()->account_id));

        $this->params = SiteService::instance()->setRequestSiteInfoParams($this->params);
        $result       = SiteService::instance()->baseInfoCreate();

        if (!$result) {
            $this->rest->error('创建失败', ErrorCodeEnum::STATUS_SUCCESS_DO_ERROR_DB);
        }
        $this->rest->success($result);
    }

    /**
     * 取得接口
     */
    public function SiteGetApi()
    {
        $this->rest->method('GET');

        $this->params['domain_id'] = Route::input('site_id');

        SiteService::instance()->setRequestSiteInfoParams($this->params);
        $result = SiteService::instance()->baseInfoGet();

        if (!$result) {
            $this->rest->error('获取失败', ErrorCodeEnum::STATUS_SUCCESS_DO_ERROR_DB_NULL);
        }

        if ($result->account_id != 2) {
            $this->rest->error('您没有权限', ErrorCodeEnum::STATUS_ERROR_API_VALIDE_AUTH);
        }

        if ($result->status == ProjectEnum::SITE_STATUS_OFFLINE) {
            $this->rest->error('网站已停用', ErrorCodeEnum::STATUS_SUCCESS_DO_ERROR_DB_NULL);
        }

        $this->rest->success($result);
    }

    /**
     * 更新接口
     */
    public function SiteModifyApi()
    {
        $this->rest->method('POST');


        SiteService::instance()->setRequestSiteInfoParams($this->params);
        $result = SiteService::instance()->baseInfoUpdate();

        if (!$result) {
            $this->rest->error('', ErrorCodeEnum::STATUS_ERROR_API_VALIDE_AUTH);
        }

        $this->rest->success($result);
    }
}