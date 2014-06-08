<?php
/**
 * @author Neeke.Gao
 * Date: 14-5-30 下午6:14
 */
class MonitorEnum
{
    static public $monitors;

    const GROUP_NC = 1; //华北
    const GROUP_EC = 2; //华东
    const GROUP_CSC = 3; //华中南
    const GROUP_WNC = 4; //华西北
    const GROUP_WSC = 5; //华西南
    const GROUP_ENC = 6; //华东北

    static public $monitorGroupsArea = array(
        self::GROUP_NC  => '华北地区',
        self::GROUP_EC  => '华东地区',
        self::GROUP_CSC => '中南地区',
        self::GROUP_WNC => '西北地区',
        self::GROUP_WSC => '西南地区',
        self::GROUP_ENC => '东北地区',
    );

    static public $monitorsByGroupArea = array(
        self::GROUP_NC  => array(1,2,13,14,15,16),
        self::GROUP_EC  => array(11,31,51,52),
        self::GROUP_CSC => array(101,102,103,104,105),
        self::GROUP_WNC => array(110,111,112,113,114,115),
        self::GROUP_WSC => array(116,117,118,119,129),
        self::GROUP_ENC => array(120,121,122,123,124,125,126,127,128,),
    );

    /**
     * @return mixed
     */
    static public function getMonitors()
    {
        if (is_null(self::$monitors)) self::$monitors = Config::get('tsb_monitor.monitor_define_list');

        return self::$monitors;
    }
}