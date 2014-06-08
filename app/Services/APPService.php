<?php
/**
 * 应用相关
 *
 * @author Neeke.Gao
 * Date: 14-5-13 下午6:07
 */

class APPService extends BaseService
{
    private static $self = NULL;

    /**
     *
     * @return APPService
     */
    static public function instance()
    {
        if (self::$self == NULL) {
            self::$self = new self;
        }

        return self::$self;
    }

    /**
     * @var VO_Request_DimApp
     */
    private $oRequestApp;

    /**
     * @var Project_AppModel
     */
    private $mAppModel;

    public function __construct()
    {
        $this->mAppModel = new Project_AppModel();
    }

    /**
     * @param $aParams
     * @return VO_Request_DimApp
     */
    public function setRequestAppInfo($aParams)
    {
        return $this->oRequestApp = VO_Bound::Bound($aParams, new VO_Request_DimApp());
    }

    /**
     * 为某account生成初始app
     * @param $iAccountId
     * @return bool
     */
    public function processDefaultApp($iAccountId)
    {
        $aWhere = array(
            'created_by' => ProjectEnum::APP_CREATED_BY_SYSTEM,
            'account_id' => $iAccountId,
        );

        if ($this->mAppModel->exists($aWhere)) return FALSE;

        $aInsertRaw = array(
            'account_id' => $iAccountId,
            'app_name'   => ProjectEnum::APP_DEFAULT_NAME,
        );

        self::setRequestAppInfo($aInsertRaw);
        $aInsert = $this->mAppModel->mkInfoForInsert($this->oRequestApp);

        return $this->mAppModel->insert($aInsert);
    }

    /**
     * 取得当前用户的默认app_id
     * @return mixed
     */
    public function getDefaultAppId()
    {
        $aWhere = array(
            'created_by' => ProjectEnum::APP_CREATED_BY_SYSTEM,
            'account_id' => UserService::getUserCache()->account_id,
        );

        $result = $this->mAppModel->getAppIdByWhere($aWhere);
        return $result->app_id;
    }
}