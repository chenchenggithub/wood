<?php
/**
 * Created by PhpStorm.
 * User: dengchao
 * Date: 14-5-16
 * Time: 上午10:04
 */
class VO_Response_DimUser extends VO_Common
{
    /******** user_info *******/
    public $user_id;

    public $user_email;

    public $user_pass;

    public $user_name;

    public $user_status;

    public $user_ticket;

    public $user_mobile;

    public $mobile_auth;

    public $user_qq;

    public $user_from;

    public $login_time;

    public $last_login_time;

    public $activating_time;

    /****** account_info ******/
    public $account_id;

    public $account_status;

    public $create_time;

    public $package_id;

    public $currency_type;

    public $balance_value;

    public $recharge_time;
}