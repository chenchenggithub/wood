<?php
/**
 * Created by PhpStorm.
 * User: dengchao
 * Date: 14-6-5
 * Time: 下午4:49
 */

class ToolKit
{
    /**
     * 生成随机验证码
     * @param int $length
     * @return string
     */
    public static function mkValidatorCode( $length = 6)
    {
        $string = "aAbBcCdDeEfFgGhHiIjJkKlLmMnNoOpPqQrRsStTxXyYzZ0123456789";
        $key = '';
        for($i=0;$i<$length;$i++)
        {
            $key .= $string{mt_rand(0,strlen($string)-1)};//生成php随机数
        }
        return $key;
    }

    /**
     * 生成随机密码
     * @param int $length
     * @return string
     */
    public static  function mkPassword($length = 6)
    {
        $pattern = '1234567890@#$%^&*abcdefghijklmnopqrstuvwxyz';
        $key = '';
        for($i=0;$i<$length;$i++)
        {
            $key .= $pattern{mt_rand(0,strlen($pattern)-1)};//生成php随机数
        }
        return $key;
    }
}