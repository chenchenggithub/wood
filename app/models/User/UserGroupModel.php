<?php
/**
 * Created by PhpStorm.
 * User: dengchao
 * Date: 14-5-19
 * Time: 下午4:39
 */
class User_UserGroupModel extends BaseModel
{
    protected $table = "group_info";
    protected $join_table = "relationship_group_user";
    protected $primaryKey = "group_id";

    public function mkParamsForInsert(VO_Request_DimGroup $request)
    {
        return array(
            'group_name'  => $request->group_name,
            'parent_id'   => $request->parent_id,
            'level'       => $request->level,
            'level_sort'  => $request->level_sort,
            'create_time' => time(),
            'group_des'   => $request->group_des,
            'account_id'  => $request->account_id,
        );
    }

    public function mkParamsForInsertGroupUser(VO_Request_DimGroup $request)
    {
        return array(
            'group_id' => $request->group_id,
            'user_id'  => $request->user_id,
        );
    }

    public function setTableToJoinTable()
    {
        $this->table = $this->join_table;
    }

    public function getMaxLevelSort($group_id)
    {
        return DB::table($this->table)
            ->where('parent_id','=',$group_id)
            ->max('level_sort');
    }
}