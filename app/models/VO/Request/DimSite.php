<?php
/**
 * @author Neeke.Gao
 * Date: 14-5-14 上午10:07
 */
class VO_Request_DimSite extends VO_Common
{
    /**
     * @var
     */
    public $domain_id;

    /**
     * @var 对应account
     */
    public $account_id;

    /**
     * @var 对应app
     */
    public $app_id;

    /**
     * @var 网站名称
     */
    public $site_name;

    /**
     * @var 域名或ip
     */
    public $site_domain;

    /**
     * @var 默认监测点
     */
    public $monitor_list_default;

    /**
     * @var 默认监测频率
     */
    public $page_frequency_default;
}