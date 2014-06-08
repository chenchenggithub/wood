<?php
return array(
/**
 * 基本套餐配置	
 * 监控频率的单位是“分钟”
 */
'basic_package'=>array(
			'host' => array('count'=>10,'frequency'=>3),//主机
			'website' => array('count'=>30,'frequency'=>3),//网站
			'mobile_app' => array('count'=>5,'frequency'=>3),//移动应用
			'monitor' => array(1,2,11,12,13,14,15,16),//默认监测点
			'package_price' => 1999, // 1999元/月
		),
		
/**
 * 主机频率对应主机单价
 * 格式：频率 => 单价
 */
'host_frequency_price' => array(1=>100,2=>110,3=>120,4=>130,5=>140),

/**
 * 货币和云豆的转换配置
 * 格式：货币数 => 云豆数
 */
'translate_price' => array(1=>500),

/**
 * 默认增购时可以选择的频率
 */
'add_purchase_frequency' => array(
			'host' => array(1,2,3,4,5),
			'website' => array(1,2,3,4,5),
			'mobileapp' => array(1,2,3,4,5),		
		),
		
/**
 * 默认用户可选择的购买时限
 * 单位是“月”
 */
'purchase_time' => array(1,2,3,4,5,6,7,8,9,10,11,12,18,24,36,48),

/**
 * 购买实现对应的赠送时间
 * 格式：购买时限 => 赠送时间
 * 单位是“月”
 */
'handsel_time' => array(6=>1,12=>2,18=>3,24=>4,36=>6,48=>10),

/**
 * 订单过期时间
 * 单位是“天”
 */
'order_expired_time' => 3,

);