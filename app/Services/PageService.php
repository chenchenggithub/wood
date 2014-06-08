<?php
/**
 * 页面相关
 *
 * @author Neeke.Gao
 * Date: 14-5-13 下午6:08
 */

class PageService extends BaseService
{
    private static $self = NULL;

    /**
     *
     * @return PageService
     */
    static public function instance()
    {
        if (self::$self == NULL) {
            self::$self = new self;
        }

        return self::$self;
    }

    /**
     * @var Project_PageInfoModel
     */
    private $mPageInfo;

    /**
     * @var Project_ReServicePagesModel
     */
    private $mReServicePage;

    private function __construct()
    {
        $this->mPageInfo      = new Project_PageInfoModel();
        $this->mReServicePage = new Project_ReServicePagesModel();
    }

    /**
     * @var VO_Request_DimPage
     */
    private $oPageInfo;

    /**
     * @var VO_Response_DimPage
     */
    private $oDimPageInfoOld;

    /**
     * @param $aParams
     * @return VO_Request_DimPage
     */
    public function setRequestPageParams($aParams)
    {
        $this->oPageInfo = VO_Bound::Bound($aParams, NEW VO_Request_DimPage());
        return $this->oPageInfo;
    }

    /**
     *
     * @param null $iPageId
     * @return VO_Response_DimPage
     * @throws Exception
     */
    public function pageInfoGet($iPageId = NULL)
    {
        $iPageId = !is_null($iPageId) ? $iPageId : $this->oPageInfo->domain_id;
        if ($iPageId < 1) throw new Exception('page_id can not empty', ErrorCodeEnum::STATUS_SUCCESS_DO_ERROR_DB_RFALSE);

        $result = $this->mPageInfo->fetchRow($iPageId);
        return $result;
    }

    /**
     * 创建页面
     * @return int
     */
    public function pageCreate()
    {
        $aDataInert = $this->mPageInfo->mkInfoForInsert($this->oPageInfo);
        return $this->mPageInfo->insert($aDataInert);
    }

    /**
     * 获取某个网站下的所有页面
     * @param $iSiteId
     * @return array
     */
    public function pageList($iSiteId = NULL)
    {
        $iSiteId = !is_null($iSiteId) ? $iSiteId : $this->oPageInfo->domain_id;
        $aWhere  = array(
            'domain_id' => $iSiteId,
            'status'    => ProjectEnum::PAGE_STATUS_NORMAL,
        );

        return $this->mPageInfo->fetchAll($aWhere);
    }

    /**
     * 更新某个页面
     * @return bool
     * @throws Exception
     */
    public function pageUpdate()
    {
        if (is_null($this->oPageInfo->page_id)) {
            throw new Exception('', ErrorCodeEnum::STATUS_SUCCESS_DO_ERROR_DB_NULL);
        }

        $aDataUpdate = $this->mPageInfo->mkInfoForUpdate($this->oPageInfo);
        return $this->mPageInfo->update($aDataUpdate, $this->oPageInfo->page_id);
    }

    /**
     * 更新页面状态
     * @return bool
     * @throws Exception
     */
    public function pageStatusUpdate()
    {
        if (is_null($this->oPageInfo->page_id)) {
            throw new Exception('', ErrorCodeEnum::STATUS_SUCCESS_DO_ERROR_DB_NULL);
        }

        if (is_null($this->oPageInfo->status)) {
            throw new Exception('', ErrorCodeEnum::STATUS_ERROR_PARAMS_MUST);
        }

        $aDataUpdate = $this->mPageInfo->mkInfoForUpdateStatus($this->oPageInfo);
        return $this->mPageInfo->update($aDataUpdate, $this->oPageInfo->page_id);
    }

    public function serviceTypeProccess($iPageId, $iSiteId)
    {

    }

    /**
     * @throws Exception
     * @return int
     */
    public function ckIfServiceCanModify()
    {
        $page_id = $this->oPageInfo->page_id;

        $this->oDimPageInfoOld = self::pageInfoGet($page_id);
        if (empty($this->oDimPageInfoOld) ||
            $this->oDimPageInfoOld->account_id != UserService::getUserCache()->account_id
        ) {
            throw new Exception('您没有权限操作', ErrorCodeEnum::STATUS_ERROR_API_VALIDE_AUTH);
        }

        return TRUE;
    }

    public function serviceTypeUpdate($iPageId, $iServiceType, $status, $aConfig)
    {

    }

}