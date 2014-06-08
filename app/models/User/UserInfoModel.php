<?php
/**
 * Created by PhpStorm.
 * User: dengchao
 * Date: 14-5-16
 * Time: 上午10:26
 */
class User_UserInfoModel extends BaseModel
{
    protected $table = 'user_info';
    protected $join_table = 'account_info';
    protected $primaryKey = 'user_id';

    public function getUserInfoAll($user_id)
    {
        return DB::table($this->table)
            ->leftJoin($this->join_table,$this->table . '.account_id', '=',$this->join_table . '.account_id')
            ->where( $this->table . '.user_id', '=' , $user_id )
            ->first();
    }

    public function mkUserParamsForInsert(VO_Request_DimUser $request)
    {
        $ticket = md5(time().$request->user_pass);
        return array(
            'user_name'   => $request->user_name,
            'user_email'  => $request->user_email,
            'user_mobile' => $request->user_mobile ? $request->user_mobile : 0,
            'user_qq'     => $request->user_qq ? $request->user_qq : 0,
            'account_id'  => $request->account_id ? $request->account_id : 0,
            'user_ticket' => $ticket,
            'user_pass'   => md5(substr($ticket,0,8).$request->user_pass),
        );
    }

    public function mkUserParamsForUpdate(VO_Request_DimUser $request)
    {
        $params =  array(
            'user_name'   => $request->user_name,
            'user_qq'     => $request->user_qq ? $request->user_qq : 0,
        );
        if(!empty($request->user_mobile))
            $params['user_mobile'] = $request->user_mobile;
        return $params;
    }

}