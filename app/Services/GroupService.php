<?php
/**
 * Created by PhpStorm.
 * User: dengchao
 * Date: 14-5-19
 * Time: 下午4:44
 */
class GroupService extends BaseService
{
    private static $self = NULL;

    static public function instance()
    {
        if (self::$self == NULL) {
            self::$self = new self;
        }

        return self::$self;
    }

    /**
     * @var VO_Request_DimGroup
     */
    private $oGroupInfo = null;

    public function setGroupRequestParams(array $params)
    {
        $this->oGroupInfo = VO_Bound::Bound($params, new VO_Request_DimGroup());
        return $this->oGroupInfo;
    }

    private $mGroupModel = null;

    public function __construct()
    {
        $this->mGroupModel = new User_UserGroupModel();
    }

    public function createGroup()
    {
        $aData = $this->mGroupModel->mkParamsForInsert($this->oGroupInfo);
        return $this->mGroupModel->insert($aData);
    }

    public function createGroupUser()
    {
        $aData = $this->mGroupModel->mkParamsForInsertGroupUser($this->oGroupInfo);
        $this->mGroupModel->setTableToJoinTable();
        if (-1 != $this->mGroupModel->insert($aData))
            return true;
        return false;
    }

    public function modifyGroupName()
    {
        $group_id = $this->oGroupInfo->group_id;
        if (!$group_id) return false;
        $group_name = $this->oGroupInfo->group_name;
        $aUpdate    = array('group_name' => $group_name);
        return $this->mGroupModel->update($aUpdate, $group_id);
    }

    public function getGroupUsers($group_id = null,$offset=null,$limit=null)
    {
        if (is_null($group_id))
            $group_id = $this->oGroupInfo->group_id;
        if (!$group_id) return null;
        $this->mGroupModel->setTableToJoinTable();
        if(!is_null($offset) || !is_null($limit))
        {
            $this->mGroupModel->setLimit($offset,$limit);
        }
        $aWhere = array('group_id' => $group_id);
        return $this->mGroupModel->fetchAll($aWhere);
    }

    public function getUserGroup($user_id)
    {
        if(!$user_id) return null;
        $this->mGroupModel->setTableToJoinTable();
        $aWhere = array('user_id' => $user_id);
        $this->mGroupModel->setSelect(array('group_id'));
        $result = $this->mGroupModel->fetchRow($aWhere);
        $this->mGroupModel->removeSelect();
        if(!$result) return null;
        return $result->group_id;
    }

    public function getGroupUserNum($group_id = null)
    {
        if (is_null($group_id))
            $group_id = $this->oGroupInfo->group_id;
        if(!$group_id) return 0;
        $this->mGroupModel->setTableToJoinTable();
        $aWhere = array('group_id' => $group_id);
        return $this->mGroupModel->count($aWhere);
    }

    public function delGroup($group_id = null)
    {
        if (is_null($group_id))
            $group_id = $this->oGroupInfo->group_id;
        $group_users = self::getGroupUsers($group_id);
        if (!empty($group_users)) return false;
        $aWhere = array('group_id' => $group_id);
        return $this->mGroupModel->delete($aWhere);
    }

    public function getAccountGroup()
    {
        $account_id = UserService::getUserCache()->account_id;
        $aWhere = array('account_id' => $account_id);
        $aOrder = array('group_id' => 'asc');
        return $this->mGroupModel->fetchAll($aWhere,array(),$aOrder);
    }

    public function getAccountRootGroupId()
    {
        $account_id = UserService::getUserCache()->account_id;
        $aWhere = array(
            'account_id' => $account_id,
            'level' => 1,
            'level_sort' => 1,
        );
        $this->mGroupModel->setSelect(array('group_id'));
        $result = $this->mGroupModel->fetchRow($aWhere);
        $this->mGroupModel->removeSelect();
        if(!$result) return null;
        return $result->group_id;
    }

    public function delGroupUser($group_id, $user_id)
    {
        if (!$group_id || !$user_id) return false;
        $aWhere = array(
            'group_id' => $group_id,
            'user_id'  => $user_id,
        );
        $this->mGroupModel->setTableToJoinTable();
        return $this->mGroupModel->delete($aWhere);
    }

    /**
     * @param null $group_id
     * @return VO_Response_DimGroup
     */
    public function getGroupInfo($group_id = null)
    {
        if(is_null($group_id))
            $group_id = $this->oGroupInfo->group_id;
        if(!$group_id) return null;
        return $this->mGroupModel->fetchRow($group_id);
    }

    public function getMaxSortByParent($group_id)
    {
        if(!$group_id) return 0;
        $result = $this->mGroupModel->getMaxLevelSort($group_id);
        if(!$result) return 0;
        return $result;
    }
}