<?php
/**
 * Created by PhpStorm.
 * User: dengchao
 * Date: 14-5-22
 * Time: 上午9:54
 */
class User_UserController extends BaseController
{
    /****
     * 用户激活
     */
    public function UserActivate()
    {
        $token = $this->params['token'];
        if (!$token) {
            $this->professionError(ProfessionErrorCodeEnum::ERROR_URL_WRONG);
        }
        if (!CacheService::instance()->exists($token)) {
            $this->professionError(ProfessionErrorCodeEnum::ERROR_ACTIVATE_EXPIRED);
        }
        //验证用户
        $user_email                 = CacheService::instance()->get($token);
        $oUserInfo = UserService::instance()->getUserInfoByEmail($user_email);
        if (!$oUserInfo) {
            $this->professionError(ProfessionErrorCodeEnum::ERROR_ACCOUNT_NOT_EXIST);
        }
        if ($oUserInfo->user_status == UserEnum::USER_STATUS_NORMAL) {
            $this->professionError(ProfessionErrorCodeEnum::SUCCESS_USER_ACTIVATED);
        }
        if ($oUserInfo->user_status == UserEnum::USER_STATUS_PAUSED
            || $oUserInfo->user_status == UserEnum::USER_STATUS_DELETED) {
            $this->professionError(ProfessionErrorCodeEnum::ERROR_ACCOUNT_UNAVAILABLE);
        }
        if(!empty($oUserInfo->account_id))
        {
            if(!UserService::instance()->modifyUserStatus($oUserInfo->user_id,UserEnum::USER_STATUS_NORMAL))
                $this->rest->error();
            $this->rest->success();
        }
        //开启事物
        BaseModel::transStart();
        if (!UserService::instance()->userActivating($oUserInfo)) {
            BaseModel::transRollBack();
            $this->rest->error();
        }
        //事物提交
        BaseModel::transCommit();
        //清除cache
        CacheService::instance()->del($token);
        $this->rest->success();
    }

    /**
     * 登录页面
     * @return mixed
     */
    public function showLogin()
    {
        if (Cookie::has(UserEnum::USER_INFO_COOKIE_KEY))
            return Redirect::to('/dashboard');
        return View::make('user.login');
    }

    /**
     * 用户登录
     */
    public function disposeLogin()
    {
        //验证输入
        $aRule = array(
            'user_email' => 'required | email',
            'user_pass'  => 'required',
        );
        $aCode = array(
            'user_email' => array(
                ProfessionErrorCodeEnum::ERROR_EMAIL_NULL,
                ProfessionErrorCodeEnum::ERROR_EMAIL_FAILURE,
            ),
            'user_pass'  => array(
                ProfessionErrorCodeEnum::ERROR_PASSWORD_NULL
            ),
        );
        $this->validatorError($aRule, $aCode);
        //验证用户
        UserService::instance()->setRequestUserInfoParams($this->params);
        $oUserInfo = UserService::instance()->getUserInfoByEmail();
        if (!$oUserInfo) {
            $this->professionError(ProfessionErrorCodeEnum::ERROR_ACCOUNT_NOT_EXIST);
        }
        if (md5(substr($oUserInfo->user_ticket, 0, 8) . $this->params['user_pass']) != $oUserInfo->user_pass) {
            $this->professionError(ProfessionErrorCodeEnum::ERROR_PASSWORD_WRONG);
        }
        if (UserEnum::USER_STATUS_AWAITING_ACTIVATE == $oUserInfo->user_status) {
            $this->professionError(ProfessionErrorCodeEnum::ERROR_ACCOUNT_UNACTIVATED);
        }
        if (UserEnum::USER_STATUS_DELETED == $oUserInfo->user_status || UserEnum::USER_STATUS_PAUSED == $oUserInfo->user_status) {
            $this->professionError(ProfessionErrorCodeEnum::ERROR_ACCOUNT_UNAVAILABLE);
        }
        //修改登录时间
        UserService::instance()->updateUserLoginTime($oUserInfo->user_id);
        //生成cookie
        if (isset($this->params['remember']) && $this->params['remember'] == 1) {
            $cookie = Cookie::forever(UserEnum::USER_INFO_COOKIE_KEY, $oUserInfo->user_ticket);
        } else {
            $cookie = Cookie::make(UserEnum::USER_INFO_COOKIE_KEY, $oUserInfo->user_ticket, 24 * 3600);
        }
        //跳转
        return Redirect::to('/dashboard')->withCookie($cookie);
    }


    function Dashboard()
    {
        $this->view('user.dashboard');
    }

    function Application()
    {
        echo 'welcome';
    }

    function SiteMonitor()
    {
        echo 'welcome';
    }

    function MobileTerminal()
    {
        echo 'welcome';
    }

    function Alert()
    {
        echo 'welcome';
    }

    function Report()
    {
        echo 'welcome';
    }

    function MonitorClient()
    {
        echo 'welcome';
    }

    function System()
    {
        return Redirect::to('/user/basic_info');
    }

    function UserBasicInfo()
    {
        $this->view('user.base_info')->with(array(
            'leftLeafMenu' => UserMenuEnum::getLeftLeafMenu(),
            'menuGroup'    => UserMenuEnum::getMenuGroups(),
        ));
    }

    /**
     * 用户管理
     */
    function UserList()
    {
        $this->view('user.user_list')->with(array(
            'leftLeafMenu' => UserMenuEnum::getLeftLeafMenu(),
            'menuGroup'    => UserMenuEnum::getMenuGroups(),
        ));
    }

    /**
     * 加载用户分组
     */
    function AjaxGetGroups()
    {
        //获取用户分组
        $groups = GroupService::instance()->getAccountGroup();
        foreach ($groups as $group) {
            $groupUserNum    = GroupService::instance()->getGroupUserNum($group->group_id);
            $group->user_num = $groupUserNum;
        }
        return View::make('user.ajax.load_groups')->with(array(
            'groups' => $groups,
        ));
    }

    /**
     * 创建用户分组
     */
    function AjaxCreateGroup()
    {
        $params               = array();
        $params['group_name'] = $this->params['group_name'];
        if (!isset($this->params['parent_id']))
            $parent_id = GroupService::instance()->getAccountRootGroupId();
        else
            $parent_id = $this->params['parent_id'];
        $params['parent_id'] = $parent_id;

        $parent_info     = GroupService::instance()->getGroupInfo($parent_id);
        $params['level'] = $parent_info->level + 1;

        $maxLevelSort = GroupService::instance()->getMaxSortByParent($parent_id);
        $params['level_sort'] = $maxLevelSort + 1;
        $params['account_id'] = UserService::getUserCache()->account_id;

        GroupService::instance()->setGroupRequestParams($params);
        if(GroupService::instance()->createGroup())
            $this->rest->success();
        $this->rest->error();
    }

    /**
     * 修改分组名称
     */
    function AjaxModifyGroup()
    {
        if(!$this->params['group_id'] || !$this->params['group_name'])
            $this->rest->error();
        GroupService::instance()->setGroupRequestParams($this->params);
        if(!GroupService::instance()->modifyGroupName())
            $this->rest->error();
        $this->rest->success();
    }

    /**
     * 加载分组下的用户
     */
    function AjaxGetGroupUsers()
    {
        $group_id = $this->params['group_id'];
        //分页设置
        if(!isset($this->params['page'])) $this->params['page'] = 1;
        $limit = 10;
        $offset = ($this->params['page'] - 1) * $limit;
        $totalItems = GroupService::instance()->getGroupUserNum($group_id);
        $group_users = GroupService::instance()->getGroupUsers($group_id,$offset,$limit);
        Paginator::setCurrentPage($this->params['page']);
        $page_info = Paginator::make($group_users, $totalItems, $limit);

        $aGroupUsers = array();
        //设置用户角色显示投标css
        $aRoleTag = array(
            UserEnum::USER_ROLE_ADMIN => 'admin_user',
            UserEnum::USER_ROLE_ADVANCED => 'senior_user',
            UserEnum::User_ROLE_READONLY => 'normal_user',
        );
        foreach($group_users as $user)
        {
            $user_id = $user->user_id;
            $user_info = UserService::instance()->getUserInfo($user_id);
            $aGroupUsers[$user_id] = new stdClass();
            $aGroupUsers[$user_id]->user_name = $user_info->user_name;
            $aGroupUsers[$user_id]->user_email = $user_info->user_email;
            $aGroupUsers[$user_id]->user_status = $user_info->user_status;
            $user_role = UserService::instance()->getUserRole($user_id);
            $aGroupUsers[$user_id]->user_right = $user_role->role_right;
            $aGroupUsers[$user_id]->right_tag = $aRoleTag[$user_role->role_right];
        }
        $accountRoles = RoleService::instance()->getAccountRoles(UserService::getUserCache()->account_id);
        foreach($accountRoles as $role)
        {
            $role->right_tag = $aRoleTag[$role->role_right];
        }
        return View::make('user.ajax.load_group_users')->with(array(
            'users' => $aGroupUsers,
            'roles' => $accountRoles,
            'pages' => $page_info,
        ));
    }

    /**
     * 添加用户
     */
    function AjaxCreateUser()
    {
        $user_email = $this->params['user_email'];
        //检查email
        $aRule = array(
            'user_email' => 'email',
        );
        $aCods = array(
            'user_email' => array(ProfessionErrorCodeEnum::ERROR_EMAIL_FAILURE),
        );
        $this->validatorError($aRule,$aCods);
        //设置信息
        $this->params['user_pass'] = UserRegisterService::instance()->makePassword(6);
        $aString = explode('@',$user_email);
        $this->params['user_name'] = $aString[0];
        $this->params['account_id'] = UserService::getUserCache()->account_id;
        //开启事物
        BaseModel::transStart();
        if(!UserService::instance()->addAccountUser($this->params))
        {
            BaseModel::transRollBack();
            $this->rest->error();
        }
        //提交事物
        BaseModel::transCommit();
        $this->rest->success();
    }

    /**
     * 修改用户状态
     */
    function AjaxModifyUserStatus()
    {
        $user_id = $this->params['user_id'];
        $user_status = $this->params['user_status'];
        if($user_id == UserService::getUserCache()->user_id)
            $this->rest->error();
        $aStatus = UserEnum::getUserStatus();
        if(!array_key_exists($user_status,$aStatus))
            $this->rest->error();
        if(!UserService::instance()->modifyUserStatus($user_id,$user_status))
            $this->rest->error();
        $this->rest->success();
    }

    /**
     * 修改用户分组
     */
    function AjaxModifyUserGroup()
    {
        if(!$this->params['user_id'] || !$this->params['group_id'])
            $this->rest->error();
        //检查用户原先分组
        $group_id = GroupService::instance()->getUserGroup($this->params['user_id']);
        if(!$group_id)
            $this->rest->error();
        //删除原分组的关联关系，然后再绑定新的分组
        BaseModel::transStart();
        if(!GroupService::instance()->delGroupUser($group_id,$this->params['user_id']))
        {
            BaseModel::transRollBack();
            $this->rest->error();
        }
        GroupService::instance()->setGroupRequestParams($this->params);
        if(!GroupService::instance()->createGroupUser())
        {
            BaseModel::transRollBack();
            $this->rest->error();
        }
        BaseModel::transCommit();
        $this->rest->success();
    }

    /**
     * 操作日志
     */
    function UserLogs()
    {
        $this->view('user.user_log')->with(array(
            'leftLeafMenu' => UserMenuEnum::getLeftLeafMenu(),
            'menuGroup'    => UserMenuEnum::getMenuGroups(),
        ));
    }
}