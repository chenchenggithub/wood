<?php
/**
 * @author Neeke.Gao
 * Date: 14-5-19 下午3:41
 */
class ServiceConfigExtTableEnum
{
    const TABLE_MOD = 20;

    static private $scheduler_ext_table_pre = 'service_scheduler_config_extvalue_';
    static private $alert_ext_table_pre = 'service_alert_config_extvalue_';

    static private function _processTableId($iAppId)
    {
        if ((int)$iAppId < 1) throw new Exception('table can not exists', ErrorCodeEnum::STATUS_SUCCESS_DO_ERROR_DB_NULL);
        return ($iAppId % self::TABLE_MOD);
    }

    /**
     * 获取scheduler配置的资源表名
     * @param $iAppId
     * @throws Exception
     * @return string
     */
    static public function processSchedulerTableName($iAppId)
    {
        return self::$scheduler_ext_table_pre . self::_processTableId($iAppId);
    }

    /**
     * 获取alert配置的资源表名
     * @param $iAppId
     * @return string
     */
    static public function processAlertTableName($iAppId)
    {
        return self::$alert_ext_table_pre . self::_processTableId($iAppId);
    }
}