<?php
/**
 * Created by PhpStorm.
 * User: admin-chen
 * Date: 14-5-30
 * Time: 下午3:00
 *
 *TSB自定义验证规则使用说明：
 *1.mobilephone 验证手机号格式
 *
 *
 */

class CustomValidator extends Illuminate\Validation\Validator {
    /**
     *注意验证规则方法名的书写格式：
     * 必须以validate开头，并且后面跟的"规则名"首字母必须大写
     */

    // 验证手机号格式
    public function validateMobilephone($attribute, $value, $parameters)
    {
        return preg_match("/^13[0-9]{1}[0-9]{8}$|15[0-9]{1}[0-9]{8}$|18[0-9]{1}[0-9]{8}$/",$value);
    }
}