<?php
/**
 * 网站相关
 *
 * @author Neeke.Gao
 * Date: 14-5-13 下午6:07
 */

class SiteService extends BaseService
{
    private static $self = NULL;

    /**
     *
     * @return SiteService
     */
    static public function instance()
    {
        if (self::$self == NULL) {
            self::$self = new self;
        }

        return self::$self;
    }

    /**
     * @var VO_Request_DimSite
     */
    private $oSiteInfo = NULL;

    /**
     * @var VO_Request_RsServiceDomain
     */
    private $oRsServiceDomain = NULL;

    /**
     * @var VO_Response_DimSite;
     */
    private $oDimSiteInfoOld = NULL;

    /**
     * @var Project_SiteBaseInfoModel
     */
    private $mSiteBaseInfo = NULL;

    /**
     * @var Project_ReServiceDomainModel
     */
    private $mReServiceDomain = NULL;

    private function __construct()
    {
        $this->mSiteBaseInfo    = new Project_SiteBaseInfoModel();
        $this->mReServiceDomain = new Project_ReServiceDomainModel();
    }

    /**
     * @param $aParams
     * @return VO_Request_DimSite
     */
    public function setRequestSiteInfoParams($aParams)
    {
        $this->oSiteInfo = VO_Bound::Bound($aParams, NEW VO_Request_DimSite());
        return $this->oSiteInfo;
    }

    /**
     * @param $aParams
     * @return VO_Request_RsServiceDomain
     */
    public function setRequestRsServiceParams($aParams)
    {
        $this->oRsServiceDomain = VO_Bound::Bound($aParams, NEW VO_Request_RsServiceDomain());
        return $this->oRsServiceDomain;
    }

    public function getSiteList()
    {
        $aWhere = array(
            'account_id' => 1,
            'status'     => ProjectEnum::SITE_STATUS_NORMAL,
        );
        return $this->mSiteBaseInfo->fetchAll($aWhere);
    }

    /**
     * @return int
     */
    public function baseInfoCreate()
    {
        $insert = $this->mSiteBaseInfo->mkInfoForInsert($this->oSiteInfo);
        $result = $this->mSiteBaseInfo->insert($insert);

        if ($result) {
            self::serviceTypeProcess($result);
        }

        return $result;
    }

    /**
     * @internal param $iSiteId
     * @param null $domain_id
     * @throws Exception
     * @return VO_Response_DimSite
     */
    public function baseInfoGet($domain_id = NULL)
    {
        $domain_id = !is_null($domain_id) ? $domain_id : $this->oSiteInfo->domain_id;

        if ($domain_id < 1) throw new Exception('domain_id can not empty', ErrorCodeEnum::STATUS_SUCCESS_DO_ERROR_DB_RFALSE);

        $result = $this->mSiteBaseInfo->fetchRow($domain_id);

        if (!is_array($result) || count($result) < 1) return $result;

        $monitorList          = PackageInstanceService::instance()->getPackageMonitor(UserService::getUserCache()->account_id);
        $monitor_result       = array();
        $monitor_list_default = json_decode($result->monitor_list_default, TRUE);
        foreach ($monitor_list_default as $monitor_id) {
            if (array_key_exists($monitor_id, $monitorList)) {
                $monitor_result[$monitor_id] = $monitorList[$monitor_id];
            }
        }

        $result->monitor_list_default = $monitor_result;

        return $result;
    }

    public function baseInfoUpdate()
    {
        if (!is_null($this->oSiteInfo->domain_id)) {
            $this->oDimSiteInfoOld = self::baseInfoGet($this->oSiteInfo->domain_id);
            if ($this->oDimSiteInfoOld->account_id != UserService::getUserCache()->account_id) {
                throw new Exception('', ErrorCodeEnum::STATUS_ERROR_API_VALIDE_AUTH);
            }
        }

        $insert = $this->mSiteBaseInfo->mkInfoForUpdate($this->oSiteInfo);
        $result = $this->mSiteBaseInfo->update($insert, $this->oSiteInfo->domain_id);
        return $result;
    }

    /**
     * 初始化站点配置
     * @param $iSiteId
     */
    public function serviceTypeProcess($iSiteId)
    {
        $domainTypeDefault = ServiceTypeEnum::getTypeForDomainDefault();

        foreach ($domainTypeDefault as $serviceType) {
            $data = array(
                'app_id'       => 1,
                'account_id'   => UserService::instance()->getUserCache()->account_id,
                'service_type' => $serviceType,
                'domain_id'    => $iSiteId,
                'status'       => ServiceTypeEnum::TYPE_STATUS_NORMAL,
                'target_id'    => $iSiteId,
                'target_type'  => ServiceSchedulerConfigExtEnum::TARGET_TYPE_DOMAIN,
                'monitor_list' => array_keys(PackageInstanceService::instance()->getPackageMonitor(UserService::getUserCache()->account_id)),
                'frequency'    => ProjectEnum::PAGE_FREQUENCY_DEFAULT,
            );
            SchedulerConfigExtService::instance()->setRequestRsServiceParams($data);
            SchedulerConfigExtService::instance()->setConfigExtRequest($data);
            SchedulerConfigExtService::instance()->configExtModify();
        }
    }

    /**
     * @throws Exception
     * @return int
     */
    public function ckIfServiceCanModify()
    {
        $iDomainId = $this->oRsServiceDomain->domain_id;

        if (!is_null($iDomainId)) {
            $this->oDimSiteInfoOld = self::baseInfoGet($iDomainId);
            if ($this->oDimSiteInfoOld->account_id != UserService::getUserCache()->account_id) {
                throw new Exception('', ErrorCodeEnum::STATUS_ERROR_API_VALIDE_AUTH);
            }
        }

        return TRUE;

    }

    /**
     * 取得网站目前的服务状态
     * @param $iDomainId
     * @return array
     */
    public function getServicesByDomainId($iDomainId = NULL)
    {
        $iDomainId = !is_null($iDomainId) ? $iDomainId : $this->oRsServiceDomain->domain_id;

        $aWhere = array(
            'domain_id' => (int)$iDomainId,
        );

        $this->mReServiceDomain->setSelect(array('id','domain_id','service_type','status'));

        $fetchResult = $this->mReServiceDomain->fetchAll($aWhere);

        $result = array();
        if (!is_array($fetchResult) || count($fetchResult) < 1) return $result;

        foreach($fetchResult as $_rs_info) {
            $result[$_rs_info->service_type] = $_rs_info;
        }

        return $result;
    }

}