<?php
/**
 *
 * Class UserService
 */
class UserService extends BaseService
{
    private static $self = NULL;

    /**
     *
     * @return UserService
     */
    static public function instance()
    {
        if (self::$self == NULL) {
            self::$self = new self;
        }

        return self::$self;
    }

    /**
     * @var null|User_UserAccountModel
     */
    private $mUserAccountModel = NULL;

    /**
     * @var null|User_UserInfoModel
     */
    private $mUserInfoModel = NULL;

    public function __construct()
    {

    }

    private function getUserInfoModel()
    {
        if (is_null($this->mUserInfoModel)) {
            $this->mUserInfoModel = new User_UserInfoModel();
        }
    }

    private function getUserAccountModel()
    {
        if (is_null($this->mUserAccountModel))
            $this->mUserAccountModel = new User_UserAccountModel();
    }

    /**
     * @var VO_Request_DimUser
     */
    private $oUserInfo = NULL;

    /**
     * @param $params
     * @return VO_Request_DimUser
     */
    public function setRequestUserInfoParams($params)
    {
        $this->oUserInfo = VO_Bound::Bound($params, NEW VO_Request_DimUser());
        return $this->oUserInfo;
    }

    public function createUser()
    {
        $user_email = $this->oUserInfo->user_email;
        if(self::checkExits($user_email)) return false;
        $this->mUserInfoModel = new User_UserInfoModel();
        $aData                = $this->mUserInfoModel->mkUserParamsForInsert($this->oUserInfo);
        if ($this->checkExits()) return null;
        return $this->mUserInfoModel->insert($aData);
    }

    public function createAccount()
    {
        self::getUserAccountModel();
        $aData = $this->mUserAccountModel->mkAccountParamsFoInsert($this->oUserInfo);
        return $this->mUserAccountModel->insert($aData);
    }

    /**
     * 检查email是否存在
     * @param null $email
     * @return bool
     */
    public function checkExits($email = null)
    {
        if (is_null($email))
            $email = $this->oUserInfo->user_email;
        $where = array('user_email' => $email,'user_status'=>UserEnum::USER_STATUS_NORMAL);
        self::getUserInfoModel();
        return $this->mUserInfoModel->exists($where);
    }

    /**
     * @param null $email
     * @return VO_Response_DimUser
     */
    public function getUserInfoByEmail($email = null)
    {
        if (is_null($email))
            $email = $this->oUserInfo->user_email;
        $where = array('user_email = ?' => $email);
        self::getUserInfoModel();
        return $this->mUserInfoModel->fetchRow($where);
    }

    /**
     * 用户激活时，将account与用户绑定
     * @param $user_id
     * @param $account_id
     * @return bool
     */
    public function relationshipAccount($user_id, $account_id)
    {
        if (!$user_id || !$account_id) return false;
        self::getUserInfo();
        if (!$this->mUserInfoModel->exists($user_id)) return false;
        self::getUserAccountModel();
        if (!$this->mUserAccountModel->exists($account_id)) return false;
        $aUpdate = array('account_id' => $account_id);
        return $this->mUserInfoModel->update($aUpdate, $user_id);
    }

    /**
     * 获取用户的角色
     * @param null $user_id
     * @return VO_Response_DimRole
     */
    public function getUserRole($user_id = null)
    {
        if (is_null($user_id))
            $user_id = $this->oUserInfo->user_id;
        if (!$user_id) return NULL;
        $userRoleModel = new User_UserRoleModel();
        $result        = $userRoleModel->getUserRole($user_id);
        return $result;
    }

    public function getAccountId()
    {
        $user_id = $this->oUserInfo->user_id;
        if (!$user_id) return NULL;

        self::getUserInfoModel();
        $this->mUserInfoModel->setSelect(array('account_id'));
        $result = $this->mUserInfoModel->fetchRow($user_id);
        return $result->account_id;
    }

    /**
     * @param null $user_id
     * @return VO_Response_DimUser
     */
    public function getUserInfo($user_id = null)
    {
        if (is_null($user_id))
            $user_id = $this->oUserInfo->user_id;
        if (!$user_id) return NULL;
        self::getUserInfoModel();
        return $this->mUserInfoModel->fetchRow($user_id);
    }


    /**
     * 获取account_info信息
     * @param null $account_id
     * @return VO_Response_DimUser
     */
    public function getUserAccount($account_id = null)
    {
        if (is_null($account_id))
            $account_id = $this->oUserInfo->account_id;
        if (!$account_id) return NULL;

        self::getUserAccountModel();
        return $this->mUserAccountModel->fetchRow($account_id);
    }

    /**
     *
     * 根据user_id获取用户的所有信息
     * @param null $user_id
     * 即user_info信息和account_info信息
     * @return VO_Response_DimUser
     */
    public function getUserInfoAll($user_id = null)
    {
        if (is_null($user_id))
            $user_id = $this->oUserInfo->user_id;
        if (!$user_id) return NULL;
        self::getUserInfoModel();
        return $this->mUserInfoModel->getUserInfoAll($user_id);
    }

    /**
     * 批量更新account状态
     * @param array $account_ids
     * @param $iStatus
     * @return bool
     */
    public function upAccountStatusByIds(array $account_ids, $iStatus = UserEnum::STATUS_NORMAL)
    {
        if (count($account_ids) < 1) return FALSE;

        $aWhere = array(
            'account_id in ?' => $account_ids,
        );

        $aUpdate = array(
            'account_status' => $iStatus,
        );

        self::getUserAccountModel();
        return $this->mUserAccountModel->update($aUpdate, $aWhere);
    }

    /**
     * 获取账户的余额
     */
    public function getAccountBalance($account_id)
    {
        self::getUserAccountModel();
        $this->mUserAccountModel->setSelect(array('balance_value'));
        return $this->mUserAccountModel->fetchRow(array('account_id = ?' => $account_id));
    }

    /**
     * 更新账户余额
     */
    public function updateAccountBalance($account_id, $money)
    {
        $aUpdate = array('balance_value' => $money);
        $aWhere  = array(array('account_id = ?' => $account_id));
        self::getUserAccountModel();
        if (-1 == $this->mUserAccountModel->update($aUpdate, $aWhere)) return false;
        return true;
    }

    /**
     * 更新套餐
     * @param $package_id
     * @param $account_id
     * @return bool
     */
    public function updateAccountPackage($package_id, $account_id)
    {
        if (!$account_id || !$package_id) return false;
        $aUpdate = array('package_id' => $package_id);
        self::getUserAccountModel();
        return $this->mUserAccountModel->update($aUpdate, $account_id);
    }

    /**
     * 根据ticket获取user_id
     * @param $ticket
     * @return null
     */
    public function getUserIdByTicket($ticket)
    {
        if (!$ticket) return null;
        $aWhere = array('user_ticket = ?' => $ticket);
        self::getUserInfoModel();
        $this->mUserInfoModel->setSelect(array('user_id'));
        $oInfo = $this->mUserInfoModel->fetchRow($aWhere);
        $this->mUserInfoModel->removeSelect();
        if (!$oInfo) return null;
        return $oInfo->user_id;
    }

    /**
     * 修改用户登录时间
     * @param $user_id
     * @return bool
     */
    public function updateUserLoginTime($user_id)
    {
        if (!$user_id) return false;
        $login_time      = time();
        $oUserInfo       = self::getUserInfo($user_id);
        $last_login_time = $oUserInfo->login_time;
        if (empty($oUserInfo->login_time)) {
            $last_login_time = $login_time;
        }
        $aUpdate = array('login_time' => $login_time, 'last_login_time' => $last_login_time);
        self::getUserInfoModel();
        return $this->mUserInfoModel->update($aUpdate, $user_id);
    }

    /**
     * 设置用户信息cache
     * @param $ticket
     * @return bool
     */
    public function setUserCache($ticket)
    {
        if (!$ticket) return false;
        $user_id = self::getUserIdByTicket($ticket);
        if (!$user_id) return false;
        $oUserInfo = self::getUserInfoAll($user_id);
        $oRoleInfo = self::getUserRole($user_id);
        $params    = array();
        foreach ($oUserInfo as $key => $value) {
            $params[$key] = $value;
        }
        foreach ($oRoleInfo as $key => $value) {
            $params[$key] = $value;
        }

        $cacheUserInfo = VO_Bound::Bound($params, NEW VO_Request_UserCache());
        CacheService::instance()->set($ticket, $cacheUserInfo, 24 * 60, UserEnum::USER_INFO_CACHE_TAG);
        return true;
    }

    /**
     * @var VO_Response_UserCache
     */
    private static $getUserCache = NULL;

    /**
     * @return VO_Response_UserCache
     */
    public static function getUserCache()
    {
        if (is_null(self::$getUserCache)) {
            if (Cookie::has(UserEnum::USER_INFO_COOKIE_KEY)) {
                $ticket             = Cookie::get(UserEnum::USER_INFO_COOKIE_KEY);
                self::$getUserCache = CacheService::instance()->get($ticket, UserEnum::USER_INFO_CACHE_TAG);
            }
        }

        return self::$getUserCache;
    }

    /**
     * 用户激活
     * @param $oUserInfo
     * @return bool
     */
    public function userActivating($oUserInfo)
    {
        if (empty($oUserInfo)) return false;
        //创建account
        self::setRequestUserInfoParams(array('package_id'=>0));
        $account_id = self::createAccount();
        if (!$account_id) return false;
        //关联account_id
        if (!self::relationshipAccount($oUserInfo->user_id, $account_id)) return false;
        //创建company_info
        $oRegisterInfo = UserRegisterService::instance()->getRegisterInfoByRelationshipUser($oUserInfo->user_id);
        if (!$oRegisterInfo) return false;
        $cParams = array(
            'company_name'     => $oRegisterInfo->company_name,
            'company_url'      => $oRegisterInfo->company_url,
            'company_industry' => $oRegisterInfo->company_industry,
            'account_id'       => $account_id,
        );
        CompanyService::instance()->setCompanyParamsForRequest($cParams);
        if (!CompanyService::instance()->createCompany()) return false;
        unset($cParams);
        //创建个人设置
        UserPersonalSettingService::instance()->setRequestParams(array('user_id'=>$oUserInfo->user_id));
        if(!UserPersonalSettingService::instance()->createUserPersonalSet())
            return false;
        //创建角色
        $rParams = array(
            array(
                'role_right' => UserEnum::USER_ROLE_ADMIN,
                'role_des'   => '全部权限',
                'account_id' => $account_id,
            ),
            array(
                'role_right' => UserEnum::USER_ROLE_ADVANCED,
                'role_des'   => '管理和查看监控任务',
                'account_id' => $account_id,
            ),
            array(
                'role_right' => UserEnum::User_ROLE_READONLY,
                'role_des'   => '查看监控任务',
                'account_id' => $account_id,
            ),
        );
        RoleService::instance()->setRoleRequestParams($rParams[0]);
        $role_id = RoleService::instance()->createRole();
        if (!$role_id) return false;
        RoleService::instance()->setRoleRequestParams($rParams[1]);
        RoleService::instance()->createRole();
        RoleService::instance()->setRoleRequestParams($rParams[2]);
        RoleService::instance()->createRole();
        unset($rParams);
        //角色与用户绑定
        $ruParams = array(
            'user_id' => $oUserInfo->user_id,
            'role_id' => $role_id,
        );
        RoleService::instance()->setRoleRequestParams($ruParams);
        if (!RoleService::instance()->createRoleUser()) return false;
        unset($ruParams);
        //创建分组
        $gParams = array(
            'group_name' => $oRegisterInfo->company_name,
            'parent_id'  => 0,
            'level'      => 1,
            'level_sort' => 1,
            'group_des'  => $oRegisterInfo->company_name,
            'account_id' => $account_id,
        );
        GroupService::instance()->setGroupRequestParams($gParams);
        $group_id = GroupService::instance()->createGroup();
        if (!$group_id) return false;
        unset($gParams);
        //分组与用户绑定
        $guParams = array(
            'group_id' => $group_id,
            'user_id'  => $oUserInfo->user_id,
        );
        GroupService::instance()->setGroupRequestParams($guParams);
        if (!GroupService::instance()->createGroupUser()) return false;
        unset($guParams);
        //创建package_instance
        $package_id = PackageInstanceService::instance()->insertTryPackage($account_id);
        if (!$package_id) return false;
        //创建默认app
        if (!APPService::instance()->processDefaultApp($account_id)) return false;
        //修改account_info中的package_id
        if (!self::updateAccountPackage($package_id, $account_id)) return false;
        //更新状态
        if (!self::updateUserStatusForActivate($oUserInfo->user_id)) return false;
        return true;
    }

    /**
     * 更新用户为激活状态
     * @param $user_id
     * @return bool
     */
    private function updateUserStatusForActivate($user_id)
    {
        if (!$user_id) return false;
        $aUpdate = array('user_status' => UserEnum::USER_STATUS_NORMAL, 'activating_time' => time());
        self::getUserInfoModel();
        return $this->mUserInfoModel->update($aUpdate, $user_id);
    }

    /**
     * 修改密码
     * @param $password
     * @return bool
     */
    public function modifyPassword($password)
    {
        $user_id = self::getUserCache()->user_id;
        if (!$password) return false;
        $ticket      = Cookie::get(UserEnum::USER_INFO_COOKIE_KEY);
        $newPassword = md5(substr($ticket, 0, 8) . $password);
        $aUpdate     = array('user_pass' => $newPassword);
        self::getUserInfoModel();
        return $this->mUserInfoModel->update($aUpdate, $user_id);
    }

    /**
     * 修改用户信息
     * @return bool
     */
    public function modifyUserInfo()
    {
        self::getUserInfoModel();
        $aUpdate = $this->mUserInfoModel->mkUserParamsForUpdate($this->oUserInfo);
        $user_id = $this->oUserInfo->user_id;
        if(!$user_id)
            $user_id = self::getUserCache()->user_id;
        return $this->mUserInfoModel->update($aUpdate,$user_id);
    }

    /**
     * 修改用户email
     * @param $email
     * @return bool
     */
    public function modifyUserEmail($email)
    {
        if(!$email) return false;
        $user_id = self::getUserCache()->user_id;
        if(!$user_id) return false;
        $aUpdate = array('user_email'=>$email);
        self::getUserInfoModel();
        return $this->mUserInfoModel->update($aUpdate,$user_id);
    }

    /**
     * 修改用户状态
     * @param $user_id
     * @param $status
     * @return bool
     */
    public function modifyUserStatus($user_id,$status)
    {
        if(!$user_id || !$status) return false;
        $aUpdate = array('user_status' => $status);
        self::getUserInfoModel();
        return $this->mUserInfoModel->update($aUpdate,$user_id);
    }

    /**
     * 添加账号用户
     * @param array $params
     * @return bool
     */
    public function addAccountUser(array $params)
    {
        //添加user_info
        self::setRequestUserInfoParams($params);
        $user_id = self::createUser();
        if(!$user_id) return false;
        //关联角色
        $roleParams = array('user_id'=>$user_id,'role_id'=>$params['role_id']);
        RoleService::instance()->setRoleRequestParams($roleParams);
        if(!RoleService::instance()->createRoleUser()) return false;
        //关联分组
        $groupParams = array('user_id'=>$user_id,'group_id'=>$params['group_id']);
        GroupService::instance()->setGroupRequestParams($groupParams);
        if(!GroupService::instance()->createGroupUser()) return false;
        //发送激活邮件
        $token = md5(time().$user_id.$this->oUserInfo->user_email);
        MailService::instance()->sendByMQ('emails.user.user_activate',array(
            'user_name' => $this->oUserInfo->user_name,
            'password'  => $this->oUserInfo->user_pass,
            'token'     => $token,
        ),$this->oUserInfo->user_email,$this->oUserInfo->user_name,'toushibao.com');
        //生成cache
        CacheService::instance()->set($token,$this->oUserInfo->user_email,7*24*60);
        return true;
    }
}