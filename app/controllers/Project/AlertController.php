<?php
/**
 * @author Neeke.Gao
 * Date: 14-5-27 上午10:01
 */
class Project_AlertController extends BaseController
{

    private $siteBaseInfo;

    private function getSiteBaseInfo()
    {
        $iDomainId = (int)$this->getParam('domain_id');

        if ($iDomainId < 1) {
            throw new Exception('参数非法', ErrorCodeEnum::STATUS_ERROR_PARAMS_MUST);
        }

        $this->siteBaseInfo = SiteService::instance()->baseInfoGet($iDomainId);

        if (!$this->siteBaseInfo) {
            throw new Exception(NULL, ErrorCodeEnum::STATUS_SUCCESS_DO_ERROR_DB_NULL);
        }
    }

    private function getConfigInfo()
    {

    }

    /**
     * 告警策略
     */
    public function AlertConfigShow()
    {
        $modleName = Request::segment(3);

        $this->getSiteBaseInfo();

        $this->view('project.alert_site')->with(
            array(
                'baseInfo' => $this->siteBaseInfo,
            )
        );
    }


    /**
     * 更新告警策略
     */
    public function AlertConfigModify()
    {
        $this->getSiteBaseInfo();
    }

    /**
     * 报警通道
     */
    public function AlertChannelShow()
    {

    }


    /**
     * 更新报警通道
     */
    public function AlertChannelModify()
    {

    }
}