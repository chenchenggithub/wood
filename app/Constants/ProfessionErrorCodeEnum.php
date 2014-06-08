<?php
/**
 * 业务处理错误提示
 * Created by PhpStorm.
 * User: dengchao
 * Date: 14-5-14
 * Time: 下午4:16
 */
class ProfessionErrorCodeEnum extends ErrorCodeEnum
{
    const ERROR_ACCOUNT_UNAVAILABLE = 1400; //账号不可用
    const ERROR_ACCOUNT_UNACTIVATED = 1401; //账号未激活
    const ERROR_EMAIL_EXISTED = 1402; //email已存在
    const ERROR_EMAIL_FAILURE = 1403; //email不合格
    const ERROR_EMAIL_NULL = 1404; //email为空
    const ERROR_PASSWORD_NULL             = 1405;
    const ERROR_PASSWORD_FAILURE          = 1406;
    const ERROR_PASSWORD_WRONG            = 1407;
    const ERROR_PASSWORD_DIFFERENT        = 1408;
    const ERROR_ACCOUNT_NOT_EXIST         = 1409;
    const ERROR_NO_ACCESS                 = 1410;
    const ERROR_USERNAME_NULL             = 1411;
    const ERROR_USERNAME_FAILURE          = 1412;
    const ERROR_ADMIN_ADD_SUCCESS         = 1413;
    const ERROR_ADMIN_ADD_FAIL            = 1414;
    const ERROR_USER_REGISTER_SUCCESS     = 1415;
    const ERROR_USER_REGISTER_FAIL        = 1416;
    const ERROR_USER_MOBILE_NULL          = 1417;
    const ERROR_USER_MOBILE_FAILURE       = 1418;
    const ERROR_COMPANY_NAME_NULL         = 1419;
    const ERROR_URL_WRONG                 = 1420;
    const ERROR_ACTIVATE_EXPIRED          = 1421;
    const SUCCESS_USER_ACTIVATED          = 1422;
    const ERROR_CREATE_ACCOUNT_FAIL       = 1423;
    const ERROR_CREATE_COMPANY_FAIL       = 1424;
    const ERROR_CREATE_ROLE_FAIL          = 1425;
    const ERROR_CREATE_GROUP_FAIL         = 1426;
    const ERROR_VERIFICATION_CODE_NULL    = 1427;
    const ERROR_VERIFICATION_CODE_WRONG   = 1428;
    const ERROR_VERIFICATION_CODE_EXPIRED = 1429;
    const ERROR_VERIFICATION_CODE_EXIST   = 1430;

    /**
     * 业务逻辑错误码 by chencheng
     */
    //优惠策略相关的错误码
    const ERROR_PROMO_CONDITION     = 1500;
    const ERROR_PROMO_PATT          = 1501;
    const ERROR_PROMO_DISCOUNT      = 1502;
    const ERROR_PROMO_CREATE_RESULT = 1503;
    const ERROR_PROMO_UPDATE_RESULT = 1504;
    const PROMO_STRATEGY_SUCCESS    = 1505; //优惠策略符合所有使用条件的返回码
    const ERROR_PROMO_CHECK_TIME = 1506; //优惠码使用时间范围不正确
    const ERROR_PROMO_CHECK_CONSUMPTION_AMOUNT = 1507; //消费金额不符
    const ERROR_PROMO_CHECK_USE_COUNT = 1508; //优惠码超过使用次数
    const ERROR_PROMO_CREATE_CODE_FIAL = 1509; //优惠码生成失败
    const ERROR_PROMO_UPDATE_RESULT_TYPE = 1510;
    const PROMO_CODE_NO_USED             = 1511; //优惠码没有被使用的状态码
    const ERROR_PROMO_CHECK_NO_EXISTS = 1512; //优惠码不存在

    //发票相关的错误码
    const ERROR_INVOICE_HEADER_EMPTY   = 1513;
    const ERROR_INVOICE_ADDRESS_EMPTY  = 1514;
    const ERROR_INVOICE_ZIP_CODE_EMPTY = 1515;
    const ERROR_INVOICE_CONTACT_EMPTY  = 1516;
    const ERROR_INVOICE_PHONE_EMPTY    = 1517;
    const ERROR_INVOICE_MONEY_EMPTY    = 1518;
    const ERROR_INVOICE_PHONE_FORMAT   = 1519;

    private static $error_message = array(
        self::ERROR_ACCOUNT_UNAVAILABLE            => '账号被暂停或已禁用',
        self::ERROR_ACCOUNT_UNACTIVATED            => '账号未激活',
        self::SUCCESS_USER_ACTIVATED               => '账号已激活',
        self::ERROR_EMAIL_EXISTED                  => '该邮箱地址已经存在',
        self::ERROR_EMAIL_FAILURE                  => '错误的邮箱地址',
        self::ERROR_EMAIL_NULL                     => '邮箱地址不能为空',
        self::ERROR_PASSWORD_NULL                  => '密码不能为空',
        self::ERROR_PASSWORD_FAILURE               => '密码必须为大于6位的数字或字符',
        self::ERROR_PASSWORD_WRONG                 => '密码错误，请核对后再输入',
        self::ERROR_PASSWORD_DIFFERENT             => '两次输入的密码不同',
        self::ERROR_ACCOUNT_NOT_EXIST              => '不存在的用户',
        self::ERROR_NO_ACCESS                      => '没有访问权限',
        self::ERROR_USERNAME_NULL                  => '用户名不能为空',
        self::ERROR_USERNAME_FAILURE               => '用户名不符合规则',
        self::ERROR_ADMIN_ADD_SUCCESS              => '添加管理员成功',
        self::ERROR_ADMIN_ADD_FAIL                 => '添加管理员失败',
        self::ERROR_USER_REGISTER_SUCCESS          => '申请成功，请耐心等待客服审核',
        self::ERROR_USER_REGISTER_FAIL             => '对不起，申请失败,请稍后重新申请',
        self::ERROR_USER_MOBILE_NULL               => '手机号码为空',
        self::ERROR_USER_MOBILE_FAILURE            => '错误的手机号码',
        self::ERROR_COMPANY_NAME_NULL              => '公司名称为空',
        self::ERROR_URL_WRONG                      => '链接地址错误',
        self::ERROR_ACTIVATE_EXPIRED               => '激活邀请已过期',
        self::ERROR_CREATE_ACCOUNT_FAIL            => '创建账号失败',
        self::ERROR_CREATE_COMPANY_FAIL            => '添加公司信息失败',
        self::ERROR_CREATE_ROLE_FAIL               => '创建角色失败',
        self::ERROR_CREATE_GROUP_FAIL              => '创建分组失败',
        self::ERROR_PROMO_CONDITION                => '请填写使用条件',
        self::ERROR_PROMO_PATT                     => '请填写优惠模式',
        self::ERROR_PROMO_DISCOUNT                 => '优惠折扣不能大于等于1',
        self::ERROR_PROMO_CREATE_RESULT            => '优惠策略创建失败',
        self::ERROR_PROMO_UPDATE_RESULT            => '优惠策略修改失败',
        self::ERROR_PROMO_CHECK_TIME               => '优惠码使用时间范围不正确',
        self::ERROR_PROMO_CHECK_CONSUMPTION_AMOUNT => '消费金额不符',
        self::ERROR_PROMO_CHECK_USE_COUNT          => '优惠码超过使用次数',
        self::ERROR_PROMO_CREATE_CODE_FIAL         => '优惠码生成失败',
        self::ERROR_PROMO_UPDATE_RESULT_TYPE       => '优惠策略修改失败',
        self::ERROR_PROMO_CHECK_NO_EXISTS          => '优惠码不存在',
        self::ERROR_INVOICE_HEADER_EMPTY           => '发票抬头不能为空',
        self::ERROR_INVOICE_ADDRESS_EMPTY          => '地址不能为空',
        self::ERROR_INVOICE_ZIP_CODE_EMPTY         => '邮编不能为空',
        self::ERROR_INVOICE_CONTACT_EMPTY          => '收件人不能为空',
        self::ERROR_INVOICE_PHONE_EMPTY            => '手机不能为空',
        self::ERROR_INVOICE_MONEY_EMPTY            => '发票金额不能为空',
        self::ERROR_INVOICE_PHONE_FORMAT           => '请填写正确的手机号格式',
        self::ERROR_VERIFICATION_CODE_NULL         => '验证码为空',
        self::ERROR_VERIFICATION_CODE_WRONG        => '验证码错误',
        self::ERROR_VERIFICATION_CODE_EXPIRED      => '验证码已过期',
        self::ERROR_VERIFICATION_CODE_EXIST        => '验证码已经发送，请耐心等待',
    );


    public static function getErrorMessage()
    {
        return self::$error_message;
    }
}