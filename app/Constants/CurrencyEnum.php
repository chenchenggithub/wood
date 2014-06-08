<?php 
/**
 * 国际化货币标示符
 * @author admin-chen
 *
 */
class CurrencyEnum{
	const RENMINBIN = 1; //人民币
	const DOLLAR = 2; //美元
	const EURO = 3; //欧元
	
	static public $CurrencyFormat = array(
					self::RENMINBIN => '￥',
					self::DOLLAR => '$',
					self::EURO => '€'
				);
}