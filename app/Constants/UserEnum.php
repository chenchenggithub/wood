<?php
/**
 *user常量
 *
 * Class UserEnum
 */
class UserEnum
{
    /*****用户账号状态*****/
    const STATUS_NORMAL = 1; //账号正常
    const STATUS_OFFLINE = 2; //账号过期

    /*****申请用户状态*****/
    const REGISTER_STATUS_NORMAL = 1; //已注册，等待审核
    const REGISTER_STATUS_PASS = 2; //审核通过
    const REGISTER_STATUS_FAIL = 3; //审核失败
    private static $register_status = array(
        self::REGISTER_STATUS_NORMAL => '等待审核',
        self::REGISTER_STATUS_PASS   => '审核通过',
        self::REGISTER_STATUS_FAIL   => '审核失败',
    );

    public static function getRegisterStatus()
    {
        return self::$register_status;
    }

    /*****正式用户状态*****/
    const USER_STATUS_NORMAL = 1; //正常使用
    const USER_STATUS_AWAITING_ACTIVATE = 2; //等待激活
    const USER_STATUS_PAUSED = 3; //已暂停
    const USER_STATUS_DELETED = 4; //已删除

    public static function getUserStatus()
    {
        return array(
            self::USER_STATUS_NORMAL            => '正常',
            self::USER_STATUS_AWAITING_ACTIVATE => '未激活',
            self::USER_STATUS_PAUSED            => '已暂停',
            self::USER_STATUS_DELETED           => '已删除',
        );
    }

    /******* 手机认证状态 *******/
    const USER_MOBILE_AUTH_YES = 1; //已认证手机
    const USER_MOBILE_AUTH_NO = 2; //未认证手机

    /******* 系统语言 *******/
    const SYSTEM_LANGUAGE_EN = 1; //英文
    const SYSTEM_LANGUAGE_ZN = 2; //中文

    /******* 系统时区 *******/
    const SYSTEM_TIMEZONE_P0800 = "P0800";
    const SYSTEM_TIMEZONE_N1200 = "N1200";
    const SYSTEM_TIMEZONE_N1100 = "N1100";
    const SYSTEM_TIMEZONE_N1000 = "N1000";
    const SYSTEM_TIMEZONE_N0900 = "N0900";
    const SYSTEM_TIMEZONE_N0800 = "N0800";
    const SYSTEM_TIMEZONE_N0700 = "N0700";
    const SYSTEM_TIMEZONE_N0600 = "N0600";
    const SYSTEM_TIMEZONE_N0500 = "N0500";
    const SYSTEM_TIMEZONE_N0400 = "N0400";
    const SYSTEM_TIMEZONE_N0300 = "N0300";
    const SYSTEM_TIMEZONE_N0200 = "N0200";
    const SYSTEM_TIMEZONE_N0100 = "N0100";
    const SYSTEM_TIMEZONE_P0000 = "P0000";
    const SYSTEM_TIMEZONE_P0100 = "P0100";
    const SYSTEM_TIMEZONE_P0200 = "P0200";
    const SYSTEM_TIMEZONE_P0300 = "P0300";
    const SYSTEM_TIMEZONE_P0400 = "P0400";
    const SYSTEM_TIMEZONE_P0500 = "P0500";
    const SYSTEM_TIMEZONE_P0600 = "P0600";
    const SYSTEM_TIMEZONE_P0630 = "P0630";
    const SYSTEM_TIMEZONE_P0700 = "P0700";
    const SYSTEM_TIMEZONE_P0900 = "P0900";
    const SYSTEM_TIMEZONE_P1000 = "P1000";
    const SYSTEM_TIMEZONE_P1100 = "P1100";
    const SYSTEM_TIMEZONE_P1200 = "P1200";
    const SYSTEM_TIMEZONE_P1300 = "P1300";
    private static $system_timezone = array(
        self::SYSTEM_TIMEZONE_P0800 => "(GMT+0800) 北京时间：北京、重庆、香港、新加坡 ",
        self::SYSTEM_TIMEZONE_N1200 => "(GMT-1200) 日界线西",
        self::SYSTEM_TIMEZONE_N1100 => "(GMT-1100) 中途岛、萨摩亚群岛",
        self::SYSTEM_TIMEZONE_N1000 => "(GMT-1000) 夏威夷",
        self::SYSTEM_TIMEZONE_N0900 => "(GMT-0900) 阿拉斯加",
        self::SYSTEM_TIMEZONE_N0800 => "(GMT-0800) 太平洋时间  (美国和加拿大)",
        self::SYSTEM_TIMEZONE_N0700 => "(GMT-0700) 山地时间  (美国和加拿大)",
        self::SYSTEM_TIMEZONE_N0600 => "(GMT-0600) 中部时间  (美国和加拿大)、墨西哥城",
        self::SYSTEM_TIMEZONE_N0500 => "(GMT-0500) 东部时间  (美国和加拿大)、波哥大",
        self::SYSTEM_TIMEZONE_N0400 => "(GMT-0400) 大西洋时间  (加拿大)、加拉加斯",
        self::SYSTEM_TIMEZONE_N0300 => "(GMT-0300) 巴西、布宜诺斯艾利斯、乔治敦",
        self::SYSTEM_TIMEZONE_N0200 => "(GMT-0200) 中大西洋",
        self::SYSTEM_TIMEZONE_N0100 => "(GMT-0100) 亚速尔群岛、佛得角群岛",
        self::SYSTEM_TIMEZONE_P0000 => "(GMT+0000) 格林尼治标准时：西欧时间、伦敦、卡萨布兰卡",
        self::SYSTEM_TIMEZONE_P0100 => "(GMT+0100) 中欧时间、安哥拉、利比亚",
        self::SYSTEM_TIMEZONE_P0200 => "(GMT+0200) 东欧时间、开罗、雅典",
        self::SYSTEM_TIMEZONE_P0300 => "(GMT+0300) 巴格达、科威特、莫斯科",
        self::SYSTEM_TIMEZONE_P0400 => "(GMT+0400) 阿布扎比、马斯喀特、巴库",
        self::SYSTEM_TIMEZONE_P0500 => "(GMT+0500) 叶卡捷琳堡、伊斯兰堡、卡拉奇",
        self::SYSTEM_TIMEZONE_P0600 => "(GMT+0600) 阿拉木图、 达卡、新亚伯利亚",
        self::SYSTEM_TIMEZONE_P0630 => "(GMT+0630) 仰光",
        self::SYSTEM_TIMEZONE_P0700 => "(GMT+0700) 曼谷、河内、雅加达",
        self::SYSTEM_TIMEZONE_P0900 => "(GMT+0900) 东京、汉城、大阪、雅库茨克",
        self::SYSTEM_TIMEZONE_P1000 => "(GMT+1000) 悉尼、关岛",
        self::SYSTEM_TIMEZONE_P1100 => "(GMT+1100) 马加丹、索罗门群岛",
        self::SYSTEM_TIMEZONE_P1200 => "(GMT+1200) 奥克兰、惠灵顿、堪察加半岛",
        self::SYSTEM_TIMEZONE_P1300 => "(GMT+1300) 努库阿洛法",
    );

    public static function getSystemTimezone()
    {
        return self::$system_timezone;
    }

    /********* 消息订阅 ********/
    const SYSTEM_NOTICE_SUBSCRIPTION_YES = 1; //订阅系统消息
    const SYSTEM_NOTICE_SUBSCRIPTION_NO  = 2; //不订阅系统消息

    /********* 用户来源 ********/
    const USER_FROM_TSB = 1; //透视宝注册用户
    const USER_FROM_JKB = 2; //监控宝申请过来的用户

    //用户信息cache标签
    const USER_INFO_CACHE_TAG = '__USER_INFO_TAG';
    //用户信息cookie
    const USER_INFO_COOKIE_KEY = '__USER_INFO_TICKET';
    //验证码cache标签
    const USER_VERIFICATION_CODE_TAG = '__VERIFICATION_CODE_TAG';

    /*****用户角色*****/
    const USER_ROLE_ADMIN    = 1;
    const USER_ROLE_ADVANCED = 2;
    const User_ROLE_READONLY = 3;
    static private $userRoles = array(
        self::USER_ROLE_ADMIN    => '管理员',
        self::USER_ROLE_ADVANCED => '高级用户',
        self::User_ROLE_READONLY => '只读用户',
    );

    /*****系统人员状态*****/
    const ADMIN_STATUS_NORMAL = 1; //正常
    const ADMIN_STATUS_PAUSED = 2; //已暂停
    const ADMIN_STATUS_DELETED = 3; //已删除

    /*****系统人员权限*****/
    const ADMIN_RIGHT_MANAGER    = 1;
    const ADMIN_RIGHT_CS_MANAGER = 2;
    const ADMIN_RIGHT_CS_COMMON  = 3;
    const ADMIN_RIGHT_RD_MANAGER = 4;
    const ADMIN_RIGHT_RD_COMMON  = 5;

    const ACCOUNT_ID = 1; //测试使用可删除@chencheng
    const USER_ID = 1; //测试使用的可删除@chencheng


    static private $adminRight = array(

        self::ADMIN_RIGHT_MANAGER    => '系统管理员',
        self::ADMIN_RIGHT_CS_COMMON  => '客服专员',
        self::ADMIN_RIGHT_CS_MANAGER => '客服经理',
        self::ADMIN_RIGHT_RD_MANAGER => '研发经理',
        self::ADMIN_RIGHT_RD_COMMON  => '研发专员',
    );

    public static function getAdminRight()
    {
        return self::$adminRight;
    }

    public static function getRoles()
    {
        return self::$userRoles;
    }

    /***** 企业行业 *****/
    const COMPANY_INDUSTRY_INTERNET   = 1;
    const COMPANY_INDUSTRY_BUSINESS   = 2;
    const COMPANY_INDUSTRY_GAME       = 3;
    const COMPANY_INDUSTRY_MEDIA      = 4;
    const COMPANY_INDUSTRY_EDUCATION  = 5;
    const COMPANY_INDUSTRY_PRODUCT    = 6;
    const COMPANY_INDUSTRY_GOVERNMENT = 7;
    const COMPANY_INDUSTRY_HOTEL      = 8;
    const COMPANY_INDUSTRY_BIOLOGICAL = 9;
    const COMPANY_INDUSTRY_OTHER      = 10;

    private static $company_industry = array(
        self::COMPANY_INDUSTRY_INTERNET   => '互联网门户及社区',
        self::COMPANY_INDUSTRY_BUSINESS   => '电子商务（B2C,B2B）',
        self::COMPANY_INDUSTRY_GAME       => '游 戏',
        self::COMPANY_INDUSTRY_MEDIA      => '媒体|信息服务',
        self::COMPANY_INDUSTRY_EDUCATION  => '教育|科研机构',
        self::COMPANY_INDUSTRY_PRODUCT    => '生产|制造|贸易',
        self::COMPANY_INDUSTRY_GOVERNMENT => '政 府',
        self::COMPANY_INDUSTRY_HOTEL      => '酒店|旅游|餐饮',
        self::COMPANY_INDUSTRY_BIOLOGICAL => '生物医药',
        self::COMPANY_INDUSTRY_OTHER      => '其他'
    );

    public static function getCompanyIndustry()
    {
        return self::$company_industry;
    }

}
