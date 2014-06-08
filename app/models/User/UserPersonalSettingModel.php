<?php
/**
 * Created by PhpStorm.
 * User: dengchao
 * Date: 14-6-6
 * Time: 下午4:18
 */
class User_UserPersonalSettingModel extends BaseModel
{
    protected $table = 'user_personal_setting';
    protected $primaryKey = 'user_id';

    public function mkParamsForInsert(VO_Request_DimUserPersonal $request)
    {
        return array(
            'user_id'             => $request->user_id,
            'language'            => $request->language ? $request->language : UserEnum::SYSTEM_LANGUAGE_ZN,
            'time_zone'           => $request->time_zone ? $request->time_zone : UserEnum::SYSTEM_TIMEZONE_P0800,
            'subscription'        => UserEnum::SYSTEM_NOTICE_SUBSCRIPTION_YES,
            'alert_style_setting' => NULL,
            'head_portrait'       => NULL,
        );
    }

    public function mkParamsForUpdate(VO_Request_DimUserPersonal $request)
    {
        return array(
            'language'      => $request->language,
            'time_zone'     => $request->time_zone,
            'subscription'  => $request->subscription,
            'head_portrait' => $request->head_portrait,
        );
    }
}