<?php
/**
 * Created by PhpStorm.
 * User: dengchao
 * Date: 14-5-13
 * Time: 下午3:29
 */
class Admin_AdminController extends  BaseController
{

    public function showLogin()
    {
        if(Session::has(AdminMenuEnum::ADMIN_SESSION_KEY))
        {
            $this->setParams();
            if(AdminService::instance()->checkExists())
            {
                return Redirect::to('/admin_info');
            }
        }
        return View::make('admin.login');
    }

    public function loginDispose()
    {
        //验证
        $rule = array('admin_email'=>'required|email','admin_pass'=>'required');
        $error_code = array(
            'admin_email' =>array(
                ProfessionErrorCodeEnum::ERROR_EMAIL_NULL,
                ProfessionErrorCodeEnum::ERROR_EMAIL_FAILURE,
            ),
            'admin_pass'  =>array(
                ProfessionErrorCodeEnum::ERROR_PASSWORD_NULL,
            )
        );
        $this->validatorError($rule,$error_code);
        //核对信息
        AdminService::instance()->setRequestAdminInfoParams($this->params);
        $admin_info = AdminService::instance()->getInfoByEmail();
        if(!$admin_info)
        {
            $this->professionError(ProfessionErrorCodeEnum::ERROR_ACCOUNT_NOT_EXIST);
        }
        if($admin_info->admin_pass != md5($this->params['admin_pass']))
        {
            $this->professionError(ProfessionErrorCodeEnum::ERROR_PASSWORD_WRONG);
        }
        if($admin_info->admin_status != UserEnum::ADMIN_STATUS_NORMAL)
        {
            $this->professionError(ProfessionErrorCodeEnum::ERROR_ACCOUNT_UNAVAILABLE);
        }
        //修改登录时间
        $login_time = time();
        $last_login_time = $admin_info->login_time;
        if(empty($last_login_time)) $last_login_time = $login_time;
        $aParams = array(
            'admin_id' => $admin_info->admin_id,
            'login_time'=>$login_time,
            'last_login_time'=>$last_login_time
        );
        AdminService::instance()->setRequestAdminInfoParams($aParams);
        if(AdminService::instance()->updateLoginTime())
        {
            //生成session
            Session::put(AdminMenuEnum::ADMIN_SESSION_KEY,$admin_info);
        }
        //跳转
        return Redirect::to('/admin_info');
    }

    public function loginOut()
    {
        if(Session::has(AdminMenuEnum::ADMIN_SESSION_KEY))
            Session::forget(AdminMenuEnum::ADMIN_SESSION_KEY);
        return Redirect::to('/login');
    }

    public function getAdminInfo()
    {
        $this->viewAdmin('admin.admin_info');
    }

    public function addAdmin()
    {
        return View::make('admin.add_admin');
    }

    public function addAdminDispose()
    {
        //验证
        $val_rule = array(
            'admin_email' => 'required | email',
            'admin_name'  => 'required',
        );
        $error_code = array(
            'admin_email' => array(
                ProfessionErrorCodeEnum::ERROR_EMAIL_NULL,
                ProfessionErrorCodeEnum::ERROR_EMAIL_FAILURE,
            ),
            'admin_name' => array(
                ProfessionErrorCodeEnum::ERROR_USERNAME_NULL,
            ),
        );
        $this->validatorError($val_rule,$error_code);
        //检测email是否存在
        AdminService::instance()->setRequestAdminInfoParams($this->params);
        if(AdminService::instance()->getInfoByEmail())
        {
            $this->professionError(ProfessionErrorCodeEnum::ERROR_EMAIL_EXISTED);
        }
        //添加
        $this->params['admin_pass'] = md5("toushibao@123");
        if(AdminService::instance()->addAdminInfo())
        {
            $this->professionError(ProfessionErrorCodeEnum::ERROR_ADMIN_ADD_SUCCESS);
        }
        $this->professionError(ProfessionErrorCodeEnum::ERROR_ADMIN_ADD_FAIL);
    }

    /******** 用户审核 ********/
    public function getRegisterUser()
    {
        $this->viewAdmin('admin.user_list');
    }

    public function ajaxLoadRegisterUser()
    {
        //分页设置
        if(!isset($this->params['page'])) $this->params['page'] = 1;
        UserRegisterService::instance()->setRequestRegisterInfoParams($this->params);
        $totalItems = UserRegisterService::instance()->getRegisterUsersCount();
        $limit = 10;
        $offset = ($this->params['page'] - 1) * $limit;
        $user_lists = UserRegisterService::instance()->getRegisterUsers($offset,$limit);

        Paginator::setCurrentPage($this->params['page']);
        $page_info = Paginator::make($user_lists, $totalItems, $limit);
        return View::make('admin.load_user_list')->with(array(
                'lists' => $user_lists,
                'pages' => $page_info,
                'company_industry' => UserEnum::getCompanyIndustry(),
            )
        );
    }

    public function getEntUser()
    {
        echo "hello";
    }

    /**
     *设置登录用户信息
     */
    private function setParams()
    {
        $admin_info = Session::get(AdminMenuEnum::ADMIN_SESSION_KEY);
        if(!$admin_info) Redirect::to('/login');
        foreach($admin_info as $key => $value)
        {
            $this->params[$key] = $value;
        }
        AdminService::instance()->setRequestAdminInfoParams($this->params);
    }

}