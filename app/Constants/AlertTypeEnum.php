<?php
/**
 * 告警
 *
 * @author Neeke.Gao
 * Date: 14-5-26 下午1:52
 */
class AlertTypeEnum
{
    const SITE_PERFORMACE_INDEX = 1; //网站性能指数

    static public $AlertTypeRSServiceType = array(
        self::SITE_PERFORMACE_INDEX => ServiceTypeEnum::TYPE_SPECIAL,
    );
}