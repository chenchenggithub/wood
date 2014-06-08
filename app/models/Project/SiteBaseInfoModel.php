<?php
/**
 * @author Neeke.Gao
 * Date: 14-5-14 上午10:29
 */

class Project_SiteBaseInfoModel extends BaseModel
{
    protected $table = 'dim_domain';
    protected $primaryKey = 'domain_id';

    public function mkInfoForInsert(VO_Request_DimSite $request)
    {
        return array(
            'app_id'                 => $request->app_id,
            'account_id'             => $request->account_id,
            'site_name'              => $request->site_name,
            'site_domain'            => $request->site_domain,
            'created_time'           => time(),
            'updated_time'           => time(),
            'status'                 => ProjectEnum::SITE_STATUS_NORMAL,
            'monitor_list_default'   => json_encode($request->monitor_list_default),
            'page_frequency_default' => is_null($request->page_frequency_default) ? ProjectEnum::PAGE_FREQUENCY_DEFAULT : (int)$request->page_frequency_default,
        );
    }

    public function mkInfoForUpdate(VO_Request_DimSite $request)
    {
        return array(
            'site_name'    => $request->site_name,
            'site_domain'  => $request->site_domain,
            'updated_time' => time(),
        );
    }

    public function mkInfoForDel(VO_Request_DimSite $request)
    {
        return array(
            'updated_time' => time(),
            'status'       => ProjectEnum::SITE_STATUS_OFFLINE,
        );
    }
}