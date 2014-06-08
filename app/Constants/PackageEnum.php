<?php
class PackageEnum{
	const HOST = 1; //主机
	const HOST_FREQUENCY = 2; //主机频率
	const WEBSITE = 3; //网站监控
	const WEBSITE_FREQUENCY = 4; //网站监控频率
	const MOBILE_APP = 5; //移动监控
	const MOBILE_APP_FREQUENCY = 6; //移动监控的频率
	const MONITOR = 7; //监测点
	const PACKAGE_TIME = 8; //套餐时间

    const PACKAGE_TYR_TYPE = 1; //套餐试用类型
    const PACKAGE_PAY_TYPE = 2; //套餐付费类型
	
	static public $packageEnum = array(
			self::HOST => '主机监控',
			self::WEBSITE => '网站监控',
			self::MOBILE_APP => '移动监控',
			self::HOST_FREQUENCY => '主机监控频率',
			self::WEBSITE_FREQUENCY => '网站监控频率',
			self::MOBILE_APP_FREQUENCY => '移动监控频率',
			self::MONITOR => '监测点',
			self::PACKAGE_TIME => '套餐时间'
	);
}