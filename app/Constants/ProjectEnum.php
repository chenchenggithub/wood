<?php
/**
 * @author Neeke.Gao
 * Date: 14-5-14 下午6:40
 */

class ProjectEnum
{
    const APP_STATUS_NORMAL  = 1;
    const APP_STATUS_OFFLINE = 0;

    const SITE_STATUS_NORMAL  = 1;
    const SITE_STATUS_OFFLINE = 0;

    const PAGE_STATUS_NORMAL  = 1;
    const PAGE_STATUS_OFFLINE = 0;

    const APP_DEFAULT_NAME      = '默认应用';
    const APP_CREATED_BY_SYSTEM = 1; //默认应用由系统创建

    const PAGE_FREQUENCY_DEFAULT = 2; //默认监控频率

    /**
     * 调度
     */
    const SCHEDULER_STATUS_NORMAL = 1; //正常
    const SCHEDULER_STATUS_OFFLINE = 2; //不可用
    const SCHEDULER_STATUS_STOP = 3; //暂停

    /**
     * 预警
     */
    const ALERT_STATUS_NORMAL = 1; //正常
    const ALERT_STATUS_OFFLINE = 2; //不可用
    const ALERT_STATUS_STOP = 3; //暂停

    const MENU_KEY_SITE_MODIFY       = 'site/modify';
    const MENU_KEY_SITE_TEAM         = 'site/team';
    const MENU_KEY_ALERT_SHOWCONFIG  = 'alert/showconfig';
    const MENU_KEY_ALERT_SHOWCHANNEL = 'alert/showchannel';
    const MENU_KEY_SITE_REMOVE       = 'site/remove';

    const MENU_KEY_ALERT_SHOWCONFIG_SITE = 'alert/showconfig/site';
    const MENU_KEY_ALERT_SHOWCONFIG_NET  = 'alert/showconfig/net';
    const MENU_KEY_ALERT_SHOWCONFIG_PAGE = 'alert/showconfig/page';

    static public $siteMenu = array(
        self::MENU_KEY_SITE_MODIFY       => '基本信息',
        self::MENU_KEY_SITE_TEAM         => '团队成员',
        self::MENU_KEY_ALERT_SHOWCONFIG  => '告警策略',
        self::MENU_KEY_ALERT_SHOWCHANNEL => '报警通道',
        self::MENU_KEY_SITE_REMOVE       => '删除网站监控',
    );

    static public $alertMenu = array(
        self::MENU_KEY_ALERT_SHOWCONFIG_SITE => '网站整体告警设置',
        self::MENU_KEY_ALERT_SHOWCONFIG_NET  => '网络告警设置',
        self::MENU_KEY_ALERT_SHOWCONFIG_PAGE => '页面告警设置',
    );

}