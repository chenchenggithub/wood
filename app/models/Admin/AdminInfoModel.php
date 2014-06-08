<?php
/**
 * Created by PhpStorm.
 * User: dengchao
 * Date: 14-5-12
 * Time: 下午2:27
 */
class Admin_AdminInfoModel extends BaseModel
{
    protected $table = 'admin_info';
    protected $primaryKey = 'admin_id';

    public function mkInfoForWhere(VO_Request_DimAdmin $request)
    {
        $result = array();
        foreach ($request as $key => $value) {
            if ($value) $result[$key] = $value;
        }
        return $result;
    }

    public function mkInfoForUpdateLoginTime(VO_Request_DimAdmin $request)
    {
        return array(
            'login_time'      => $request->login_time,
            'last_login_time' => $request->last_login_time,
        );
    }

    public function mkInfoForInsert(VO_Request_DimAdmin $request)
    {
        return array(
            'admin_email'    => $request->admin_email,
            'admin_name'     => $request->admin_name,
            'admin_pass'     => $request->admin_pass,
            'admin_status'   => UserEnum::ADMIN_STATUS_NORMAL,
            'admin_right'    => $request->admin_right,
            'parent_manager' => $request->parent_manager,
            'create_time'    => time(),
        );
    }
}