<?php
/**
 * Created by PhpStorm.
 * User: dengchao
 * Date: 14-5-16
 * Time: 下午4:09
 */
class User_UserRegisterInfoModel extends BaseModel
{
    protected $table = 'user_register';
    protected $primaryKey = 'register_id';

    public function mkInfoForInsert(VO_Request_DimRegister $request)
    {
        return array(
            'user_email'       => $request->user_email,
            'user_name'        => $request->user_name,
            'user_mobile'      => $request->user_mobile,
            'company_name'     => $request->company_name,
            'company_industry' => $request->company_industry,
            'company_url'      => $request->company_url,
            'register_time'    => time(),
            'register_status'  => UserEnum::REGISTER_STATUS_NORMAL,
        );
    }
}