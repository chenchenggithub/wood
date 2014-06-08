<?php
/**
 * @author Neeke.Gao
 * Date: 14-5-20 下午3:07
 */
class SchedulerConfigExtService extends BaseService
{
    /**
     * @var SchedulerConfigExtService
     */
    private static $self = NULL;

    /**
     * @static
     * @return SchedulerConfigExtService
     */
    public static function instance()
    {
        if (self::$self == NULL) {
            self::$self = new self;
        }
        return self::$self;
    }

    /**
     * @var VO_Request_RsServiceDomain
     */
    private $oRsServiceDomain = NULL;

    /**
     * @var VO_Request_RsServicePage
     */
    private $oRsServicePage = NULL;

    /**
     * @var VO_Request_ServiceSchedulerConfigExt
     */
    private $oSchedulerConfigExt = NULL;

    /**
     * @var VO_Response_ServiceSchedulerConfigExt
     */
    private $oSchedulerConfigExtOld = NULL;

    /**
     * @var Project_ReServiceDomainModel
     */
    private $mReServiceDomain = NULL;

    /**
     * @var Project_ReServicePagesModel
     */
    private $mReServicePages = NULL;

    /**
     * @var ServiceConfig_SchedulerKeysModel
     */
    private $mSchedulerKeysModel;

    /**
     * @var ServiceConfig_SchedulerExtModel
     */
    private $mChedulerConfigExtModel;

    public function __construct()
    {
        $this->mReServiceDomain        = new Project_ReServiceDomainModel();
        $this->mReServicePages         = new Project_ReServicePagesModel();
        $this->mSchedulerKeysModel     = new ServiceConfig_SchedulerKeysModel();
        $this->mChedulerConfigExtModel = new ServiceConfig_SchedulerExtModel();
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

    /**
     * @param $aParams
     * @return VO_Request_RsServicePage
     */
    public function setRequestRsServicePageParams($aParams)
    {
        $this->oRsServicePage = VO_Bound::Bound($aParams, NEW VO_Request_RsServicePage());
        return $this->oRsServicePage;
    }

    /**
     * @param $aParams
     * @return VO_Request_ServiceSchedulerConfigExt
     */
    public function setConfigExtRequest($aParams)
    {
        $this->oSchedulerConfigExt = VO_Bound::Bound($aParams, NEW VO_Request_ServiceSchedulerConfigExt);
        return $this->oSchedulerConfigExt;
    }

    /**
     * 根据target_type\target_id\service_type取得调度任务详情
     * @param $app_id
     * @param $target_type
     * @param $target_id
     * @param $service_type
     * @throws Exception
     * @return VO_Response_ServiceSchedulerConfigExt
     */
    public function getConfigByTargetIdAndServiceType($app_id, $target_type, $target_id, $service_type)
    {
        if (is_null($app_id)) throw new Exception('', ErrorCodeEnum::STATUS_SUCCESS_DO_ERROR_DB_NULL);

        $this->mChedulerConfigExtModel->processTableName((int)$app_id);

        $where = array(
            'app_id'       => (int)$app_id,
            'target_type'  => (int)$target_type,
            'target_id'    => (int)$target_id,
            'service_type' => (int)$service_type,
        );

        $result = $this->mChedulerConfigExtModel->fetchRow($where);
        if (is_null($result)) return NULL;

        $result->ext_value = json_decode($result->ext_value, TRUE);
        return $result;
    }

    /**
     * 计算取得对应扩展值
     */
    private function processExtValue()
    {
        $aConfigKeys = $this->mSchedulerKeysModel->getConfigKeysByServiceType($this->oSchedulerConfigExt->service_type);

        $aExtValue = array();

        if (is_null($this->oSchedulerConfigExtOld)) {
            if (is_null($this->oSchedulerConfigExt->ext_value)) {

                foreach ($aConfigKeys as $aConfig) {
                    $_tmp = $this->oSchedulerConfigExt->{$aConfig->key_name};
                    if (!is_null($_tmp)) {
                        $aExtValue[$aConfig->key_name] = $_tmp;
                    }
                }

                $this->oSchedulerConfigExt->ext_value = $aExtValue;
            }
        } else {
            $aExtValueOld = json_decode($this->oSchedulerConfigExtOld->ext_value, TRUE);

            foreach ($aConfigKeys as $aConfig) {
                $_tmp = $this->oSchedulerConfigExt->{$aConfig->key_name};
                if (!is_null($_tmp)) {
                    $aExtValue[$aConfig->key_name] = $_tmp;
                } else {
                    $aExtValue[$aConfig->key_name] =
                        array_key_exists($aConfig->key_name, $aExtValueOld)
                            ? $aExtValue[$aConfig->key_name] = $aExtValueOld[$aConfig->key_name]
                            : '';
                }
            }

            $this->oSchedulerConfigExt->ext_value = $aExtValue;
        }

    }

    /**
     * 创建与更新
     * @return bool|int
     * @throws Exception
     */
    public function configExtModify()
    {
        BaseModel::transStart();
        try {

            $this->mChedulerConfigExtModel->processTableName($this->oSchedulerConfigExt->app_id);
            $aUpdateWhere                 = $this->mChedulerConfigExtModel->mkWhereForUpdateExtValue($this->oSchedulerConfigExt);
            $this->oSchedulerConfigExtOld = $this->mChedulerConfigExtModel->fetchRow($aUpdateWhere);

            self::processExtValue();

            if ($this->oSchedulerConfigExt->target_type == ServiceSchedulerConfigExtEnum::TARGET_TYPE_DOMAIN) {
                $this->mReServiceDomain->modify($this->oRsServiceDomain);
                $is_null_id = is_null($this->oRsServiceDomain->id);
            } else {
                $this->mReServicePages->modify($this->oRsServicePage);
                $is_null_id = is_null($this->oRsServicePage->id);
            }

            if ($is_null_id && is_null($this->oSchedulerConfigExtOld)) {
                $aInsertData = $this->mChedulerConfigExtModel->mkInfoForInsert($this->oSchedulerConfigExt);
                $result      = $this->mChedulerConfigExtModel->insert($aInsertData);
            } else {
                $aUpdateData = $this->mChedulerConfigExtModel->mkInfoForUpdateExtValue($this->oSchedulerConfigExt);

                $result = $this->mChedulerConfigExtModel->update($aUpdateData, $aUpdateWhere);
            }

            BaseModel::transCommit();
        } catch (Exception $e) {
            BaseModel::transRollBack();
            throw $e;
        }

        return $result;
    }

    /**
     * 创建一个调度任务
     * @return int
     */
    public function configExtCreate()
    {
        return 1;
    }

    /**
     * 更新一个调度任务
     * @return bool
     */
    public function configExtUpdate()
    {
        return TRUE;
    }

    /**
     * 将调度任务置为不可用
     * @throws Exception
     * @return bool
     */
    public function configExtOffline()
    {
        $this->oSchedulerConfigExt->status = ProjectEnum::SCHEDULER_STATUS_OFFLINE;

        return self::configExtStatusUpdate();
    }

    /**
     * 停用一个调度任务
     * @throws Exception
     * @return bool
     */
    public function configExtStop()
    {
        $this->oSchedulerConfigExt->status = ProjectEnum::SCHEDULER_STATUS_STOP;

        return self::configExtStatusUpdate();
    }

    private function configExtStatusUpdate()
    {
        $this->mChedulerConfigExtModel->processTableName($this->oSchedulerConfigExt->app_id);

        $aUpdateWhere = $this->mChedulerConfigExtModel->mkWhereForUpdateExtValue($this->oSchedulerConfigExt);

        if (is_null($this->oRsServiceDomain->id) && !$this->mChedulerConfigExtModel->exists($aUpdateWhere)) {
            throw new Exception('', ErrorCodeEnum::STATUS_SUCCESS_DO_ERROR_DB_NULL);
        }

        $aUpdateData = $this->mChedulerConfigExtModel->mkInfoForUpdateStatus($this->oSchedulerConfigExt);
        $result      = $this->mChedulerConfigExtModel->update($aUpdateData, !is_null($this->oRsServiceDomain->id) ? $this->oRsServiceDomain->id : $aUpdateWhere);

        return $result;
    }
}