<?php
/**
 * @author Neeke.Gao
 * Date: 14-5-19 下午3:03
 */
class ServiceConfig_AlertExtModel extends BaseModel
{
    protected $primaryKey = 'ext_id';

    public function processTableName($app_id)
    {
        $tableName = ServiceConfigExtTableEnum::processAlertTableName($app_id);
        self::setTableName($tableName);
    }

    private function setTableName($tableName)
    {
        $this->table = $tableName;
    }

    public function mkInfoForInsert(VO_Request_ServiceAlertConfigExt $request)
    {
        return array(
            'app_id'          => $request->app_id,
            'target_id'       => $request->target_id,
            'target_type'     => $request->target_type,
            'service_type'    => $request->service_type,
            'alert_type'      => $request->alert_type,
            'ext_value'       => is_array($request->ext_value) ? json_encode($request->ext_value) : json_encode(array($request->ext_value)),
            'status'          => ServiceAlertConfigExtEnum::STATUS_OFFLINE,
            'dispatch_status' => ServiceAlertConfigExtEnum::DISPATCH_STATUS_WATTING,
            'update_time'     => time(),
        );
    }

    public function mkWhereForUpdateExtValue(VO_Request_ServiceAlertConfigExt $request)
    {
        return array(
            'app_id = ?'      => $request->app_id,
            'target_id = ?'   => $request->target_id,
            'target_type = ?' => $request->target_type,
            'alert_type = ?'  => $request->alert_type,
        );
    }

    public function mkInfoForUpdateExtValue(VO_Request_ServiceAlertConfigExt $request)
    {
        $aReturn = array(
            'update_time' => time(),
        );

        if (is_array($request->ext_value) && count($request->ext_value) > 0) {
            $aReturn['ext_value'] = json_encode($request->ext_value);
        }

        return $aReturn;
    }

    public function mkInfoForUpdateStatus(VO_Request_ServiceAlertConfigExt $request)
    {
        return array(
            'status'      => $request->status,
            'update_time' => time(),
        );
    }

}