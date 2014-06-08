<?php
/**
 * @author Neeke.Gao
 * Date: 14-5-22 下午3:28
 */
class Project_PageInfoModel extends BaseModel
{
    protected $table = 'dim_page';
    protected $primaryKey = 'page_id';

    public function mkInfoForInsert(VO_Request_DimPage $request)
    {
        return array(
            'app_id'       => $request->app_id,
            'account_id'   => $request->account_id,
            'domain_id'    => $request->domain_id,
            'page_url'     => $request->page_url,
            'created_time' => time(),
            'updated_time' => time(),
            'status'       => ProjectEnum::PAGE_STATUS_NORMAL,
        );
    }

    public function mkInfoForUpdate(VO_Request_DimPage $request)
    {
        return array(
            'page_url'     => $request->page_url,
            'updated_time' => time(),
        );
    }

    public function mkInfoForUpdateStatus(VO_Request_DimPage $request)
    {
        return array(
            'updated_time' => time(),
            'status'       => $request->status,
        );
    }

    public function mkWhereForUpdate(VO_Request_DimPage $request)
    {
        return array(
            'app_id = ?'    => $request->app_id,
            'domain_id = ?' => $request->domain_id,
        );
    }

}