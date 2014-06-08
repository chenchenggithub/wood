<?php
/**
 * @author Neeke.Gao
 * Date: 14-5-15 下午7:26
 */
class Project_ReServicePagesModel extends BaseModel
{
    protected $table = 'relationship_service_pages';
    protected $primaryKey = 'id';


    /**
     * @param VO_Request_RsServicePage $request
     * @return array
     */
    public function mkInfoForInsert(VO_Request_RsServicePage $request)
    {
        return array(
            'account_id'   => $request->account_id,
            'domain_id'    => $request->domain_id,
            'page_id'      => $request->page_id,
            'service_type' => $request->service_type,
            'status'       => is_null($request->status) ? ProjectEnum::APP_STATUS_NORMAL : (int)$request->status,
            'created_time' => time(),
            'updated_time' => time(),
        );
    }

    /**
     * @param VO_Request_RsServicePage $request
     * @return array
     */
    public function mkInfoForUpdate(VO_Request_RsServicePage $request)
    {
        $aUpdate = array(
            'updated_time' => time(),
        );

        if (!is_null($request->status)) {
            $aUpdate['status'] = (int)$request->status;
        }

        return $aUpdate;
    }

    public function mkWhereForUpdate(VO_Request_RsServicePage $request)
    {
        return array(
            'account_id'   => $request->account_id,
            'domain_id'    => $request->domain_id,
            'page_id'      => $request->page_id,
            'service_type' => $request->service_type,
        );
    }

    /**
     * 存在则更新(状态)，否则新增
     * @param VO_Request_RsServicePage $request
     * @return bool|int
     */
    public function modify(VO_Request_RsServicePage $request)
    {
        $aWhere = self::mkWhereForUpdate($request);

        if (is_null($request->id) && !self::exists($aWhere)) {
            $result = self::insert(self::mkInfoForInsert($request));
        } else {
            $result = self::update(self::mkInfoForUpdate($request), !is_null($request->id) ? $request->id : $aWhere);
        }
        return $result;
    }
}