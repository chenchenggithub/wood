<?php
/**
 * @author Neeke.Gao
 * Date: 14-6-6 下午12:44
 */
class AlertTypeTplConfigEnum
{

    /**
     * 网站性能指数 事后告警 最近多久
     * @var array
     */
    static public $optionAfterWardsLatlyHourPerformaceIndex = array(
        '1小时' => '3600',
        '2小时' => '7200',
        '3小时' => '10800',
        '4小时' => '14400',
        '5小时' => '18000',
        '6小时' => '21600',
    );

    /**
     * 网站性能指数 趋势告警 最近多久
     * @var array
     */
    static public $optionTrendLatlyHourPerformaceIndex = array(
        '1小时' => '3600',
        '2小时' => '7200',
        '3小时' => '10800',
        '4小时' => '14400',
        '5小时' => '18000',
        '6小时' => '21600',
    );

    /**
     * 网站性能指数 趋势告警 最近多久
     * @var array
     */
    static public $optionTrendDepartedDayPerformaceIndex = array(
        '1天' => '86400',
        '2天' => '172800',
        '3天' => '259200',
    );
}