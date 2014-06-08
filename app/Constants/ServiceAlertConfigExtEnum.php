<?php
/**
 * @author Neeke.Gao
 * Date: 14-5-20 下午2:45
 */
class ServiceAlertConfigExtEnum
{
    const STATUS_NORMAL = 1; //正常
    const STATUS_OFFLINE = 2; //不可用
    const STATUS_STOP = 3; //暂停

    const DISPATCH_STATUS_WATTING = 1; //等待调度
    const DISPATCH_STATUS_DISPATHED = 2; //已调度

    const TARGET_TYPE_DOMAIN = 1; //网站项目
    const TARGET_TYPE_PAGE = 2; //网站页面
}