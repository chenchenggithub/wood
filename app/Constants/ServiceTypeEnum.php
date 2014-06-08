<?php
/**
 * enum all types of the service
 *
 */
class ServiceTypeEnum
{
    const TYPE_LABEL_KEY           = 'label';
    const TYPE_SETTING_MONITOR_KEY = 'setting_monitor';
    const TYPE_SETTING_OTHER_KEY   = 'setting_other';

    const TYPE_STATUS_NORMAL  = 1;
    const TYPE_STATUS_OFFLINE = 0;

    const TYPE_SPECIAL = -1; //特例

    const TYPE_DNS = 1; //DNS监控
    const TYPE_PING = 2; //PING监控
    const TYPE_FTP = 3; //FTP监控
    const TYPE_SMTP = 4; //SMTP监控
    const TYPE_TCP = 5; //TCP监控
    const TYPE_TIMER = 6; //
    const TYPE_TRACEROUTE = 7; //TraceRoute监控
    const TYPE_UDP = 8; //UDP监控

    const TYPE_HTTP = 9; //页面可靠性监控
    const TYPE_SITE = 10; //页面全景（网页性能）监控

    /**
     * 网络监控
     * @return array
     */
    static public function getTypeForDomain()
    {
        return array(
            self::TYPE_FTP        => array(
                self::TYPE_LABEL_KEY => 'FTP监控',
                self::TYPE_SETTING_MONITOR_KEY,
                self::TYPE_SETTING_OTHER_KEY
            ),
            self::TYPE_PING       => array(
                self::TYPE_LABEL_KEY => 'PING监控',
                self::TYPE_SETTING_MONITOR_KEY
            ),
            self::TYPE_DNS        => array(
                self::TYPE_LABEL_KEY => 'DNS监控',
                self::TYPE_SETTING_MONITOR_KEY,
                self::TYPE_SETTING_OTHER_KEY,
            ),
            self::TYPE_UDP        => array(
                self::TYPE_LABEL_KEY => 'UDP监控',
                self::TYPE_SETTING_MONITOR_KEY,
                self::TYPE_SETTING_OTHER_KEY,
            ),
            self::TYPE_TCP        => array(
                self::TYPE_LABEL_KEY => 'TCP监控',
                self::TYPE_SETTING_MONITOR_KEY,
                self::TYPE_SETTING_OTHER_KEY,
            ),
            self::TYPE_SMTP       => array(
                self::TYPE_LABEL_KEY => 'SMTP监控',
                self::TYPE_SETTING_MONITOR_KEY,
                self::TYPE_SETTING_OTHER_KEY,
            ),
            self::TYPE_TRACEROUTE => array(
                self::TYPE_LABEL_KEY => 'TraceRoute',
                self::TYPE_SETTING_MONITOR_KEY
            ),
        );
    }

    /**
     * 网络监控默认开启的服务
     * @return array
     */
    static public function getTypeForDomainDefault()
    {
        return array(
            self::TYPE_PING,
            self::TYPE_TRACEROUTE,
        );
    }
}