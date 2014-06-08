<?php
/**
 * @author ciogao@gmail.com
 * Date: 14-5-8 上午10:19
 */

class User_UserAccountModel extends BaseModel
{
    protected $table = 'account_info';
    protected $primaryKey = 'account_id';

    public function mkAccountParamsFoInsert(VO_Request_DimUser $request)
    {
        return array(
            'package_id' => $request->package_id,
            'create_time' => time(),
        );
    }

}