<?php
/**
 * @author Neeke.Gao
 * Date: 14-5-27 下午1:57
 */
class Project_AppModel extends BaseModel
{
    protected $table = 'dim_app';
    protected $primaryKey = 'app_id';

    public function mkInfoForInsert(VO_Request_DimApp $request)
    {
        return array(
            'account_id'   => $request->account_id,
            'app_name'     => $request->app_name,
            'created_time' => time(),
            'created_by'   => $request->created_by,
        );
    }

    public function mkInfoForUpdate(VO_Request_DimApp $request)
    {
        return array(
            'app_name' => $request->app_name,
        );
    }

    public function mkInfoForWhere(VO_Request_DimApp $request)
    {
        if (!is_null($request->app_id)) return $request->app_id;

        return array(
            'account_id' => $request->account_id,
        );
    }

    /**
     * @param VO_Request_DimApp $request
     * @return VO_Response_DimApp
     */
    public function getInfoByAppId(VO_Request_DimApp $request)
    {
        return parent::fetchRow(self::mkInfoForWhere($request));
    }

    /**
     * @param $aWhere
     * @return VO_Response_DimApp
     */
    public function getAppIdByWhere($aWhere)
    {
        parent::setSelect(array('app_id'));
        return parent::fetchRow($aWhere);
    }
}