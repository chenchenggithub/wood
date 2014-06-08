<?php
/**
 * Created by PhpStorm.
 * User: dengchao
 * Date: 14-5-19
 * Time: 下午4:17
 */
class RoleService extends BaseService
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
     * @var VO_Request_DimRole
     */
    private $oRoleInfo = null;

    public function setRoleRequestParams(array $params)
    {
        $this->oRoleInfo = VO_Bound::Bound($params, new VO_Request_DimRole());
        return $this->oRoleInfo;
    }

    private $mRoleInfoModel = null;

    public function __construct()
    {
        $this->mRoleInfoModel = new User_UserRoleModel();
    }

    public function createRole()
    {
        $aData = $this->mRoleInfoModel->mkRoleParamsForInsert($this->oRoleInfo);
        return $this->mRoleInfoModel->insert($aData);
    }

    public function createRoleUser()
    {
        $aData = $this->mRoleInfoModel->mkRoleParamsForInsetRoleUser($this->oRoleInfo);
        $this->mRoleInfoModel->setTableToJoinTable();
        if (-1 != $this->mRoleInfoModel->insert($aData))
            return true;
        return false;
    }

    public function delRoleUser($role_id, $user_id)
    {
        if (!$role_id || !$user_id)
            return false;
        $aWhere = array(
            'role_id' => $role_id,
            'user_id' => $user_id,
        );
        $this->mRoleInfoModel->setTableToJoinTable();
        return $this->mRoleInfoModel->delete($aWhere);
    }

    public function getAccountRoles($account_id = null)
    {
        if(is_null($account_id))
            $account_id = $this->oRoleInfo->account_id;
        if(!$account_id) return null;
        $aWhere = array('account_id' => $account_id);
        $aOrder = array('role_id'=>'asc');
        return $this->mRoleInfoModel->fetchAll($aWhere,array(),$aOrder);
    }
}