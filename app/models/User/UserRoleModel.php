<?php
/**
 * Created by PhpStorm.
 * User: dengchao
 * Date: 14-5-16
 * Time: 上午11:24
 */
class User_UserRoleModel extends BaseModel
{
    protected $table = 'roles_info';
    protected $join_table = 'relationship_roles_user';
    protected $primaryKey = 'role_id';

    public function getUserRole($user_id)
    {
        return DB::table($this->table)
            ->leftJoin($this->join_table, $this->table . '.role_id', '=', $this->join_table . '.role_id')
            ->where($this->join_table . '.user_id', $user_id)
            ->select($this->table . '.role_name', $this->join_table . '.role_id', $this->table . '.role_right')
            ->first();
    }

    public function mkRoleParamsForInsert(VO_Request_DimRole $request)
    {
        $userRole = UserEnum::getRoles();
        return array(
            'role_name'  => $userRole[$request->role_right],
            'role_right' => $request->role_right,
            'role_des'   => $request->role_des,
            'account_id' => $request->account_id,
        );
    }

    public function mkRoleParamsForInsetRoleUser(VO_Request_DimRole $request)
    {
        return array(
            'role_id' => $request->role_id,
            'user_id' => $request->user_id,
        );
    }

    public function setTableToJoinTable()
    {
        $this->table = $this->join_table;
    }
}