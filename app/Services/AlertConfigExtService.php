<?php
/**
 * @author Neeke.Gao
 * Date: 14-6-6 下午4:29
 */
class AlertConfigExtService extends BaseService
{
    /**
     * @var AlertConfigExtService
     */
    private static $self = NULL;

    /**
     * @static
     * @return AlertConfigExtService
     */
    public static function instance()
    {
        if (self::$self == NULL) {
            self::$self = new self;
        }
        return self::$self;
    }

    /**
     * 根据target_type\target_id\service_type取得告警任务详情
     * @param $app_id
     * @param $target_type
     * @param $target_id
     * @param $alert_type
     * @throws Exception
     * @return VO_Response_ServiceSchedulerConfigExt
     */
    public function getConfigByTargetIdAndAlterType($app_id, $target_type, $target_id, $alert_type)
    {
        if (is_null($app_id)) throw new Exception('', ErrorCodeEnum::STATUS_SUCCESS_DO_ERROR_DB_NULL);

        $this->mChedulerConfigExtModel->processTableName((int)$app_id);

        $where = array(
            'app_id'       => (int)$app_id,
            'target_type'  => (int)$target_type,
            'target_id'    => (int)$target_id,
            'service_type' => (int)$alert_type,
        );

        $result = $this->mChedulerConfigExtModel->fetchRow($where);
        if (is_null($result)) return NULL;

        $result->ext_value = json_decode($result->ext_value, TRUE);
        return $result;
    }

}