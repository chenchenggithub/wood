<?php
/**
 * @author Neeke.Gao
 * Date: 14-5-19 下午2:59
 */
class ServiceConfig_AlertKeysModel extends BaseModel
{
    protected $table = 'service_alert_config_keys';
    protected $primaryKey = 'keys_id';

    public function getConfigKeysByServiceType($iServiceType)
    {
        if ((int)$iServiceType < 1) return array();

        $where = array(
            'service_type = ?' => $iServiceType,
        );

        return self::fetchAll($where);
    }
}