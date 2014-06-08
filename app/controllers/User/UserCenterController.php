<?php
/**
 * Created by PhpStorm.
 * User: dengchao
 * Date: 14-6-4
 * Time: 下午2:40
 */
class User_UserCenterController extends  BaseController
{

    /**
     * 退出
     * @return mixed
     */
    function LoginOut()
    {
        $ticket = Cookie::get(UserEnum::USER_INFO_COOKIE_KEY);
        $cookie = Cookie::forget(UserEnum::USER_INFO_COOKIE_KEY);
        CacheService::instance()->del($ticket);
        return Redirect::to('/signin')->withCookie($cookie);
    }

    function UserCenterIndex()
    {
       return View::make('user.user_center')->with(array(
           'userInfo' => UserService::getUserCache(),
       ));
    }

    function ModifyUserInfo()
    {
        //验证用户名
        $aRule = array('user_name' => 'required');
        $aCode = array('user_name' =>array(ProfessionErrorCodeEnum::ERROR_USERNAME_NULL));
        //验证手机
        if(UserService::getUserCache()->mobile_auth == UserEnum::USER_MOBILE_AUTH_NO)
        {
            $aRule['user_mobile'] = 'required | Mobilephone';
            $aCode['user_mobile'] = array(
                ProfessionErrorCodeEnum::ERROR_USER_MOBILE_NULL,
                ProfessionErrorCodeEnum::ERROR_USER_MOBILE_FAILURE,
            );
        }
        $this->validatorError($aRule,$aCode);
        //修改
        UserService::instance()->setRequestUserInfoParams($this->params);
        if(!UserService::instance()->modifyUserInfo())
            $this->rest->error();
        $this->rest->success();
    }

    /**
     * 修改密码
     */
    function ModifyPassword()
    {
        //验证密码
        $aRule = array(
            'user_pass' => 'required | min:6',
        );
        $aCode = array(
            'user_pass' => array(
                ProfessionErrorCodeEnum::ERROR_PASSWORD_NULL,
                ProfessionErrorCodeEnum::ERROR_PASSWORD_FAILURE,
            ),
        );
        $this->validatorError($aRule,$aCode);
        if($this->params['user_pass'] != $this->params['user_pass_repeat'])
            $this->professionError(ProfessionErrorCodeEnum::ERROR_PASSWORD_DIFFERENT);
        //验证原密码
        $ticket = Cookie::get(UserEnum::USER_INFO_COOKIE_KEY);
        $now_pass = md5(substr($ticket,0,8).$this->params['now_pass']);
        if(UserService::getUserCache()->user_pass != $now_pass)
            $this->professionError(ProfessionErrorCodeEnum::ERROR_PASSWORD_WRONG);
        //修改密码
        if(!UserService::instance()->modifyPassword($this->params['user_pass']))
            $this->rest->error();
        //更新cache
        UserService::instance()->setUserCache($ticket);
        $this->rest->success();
    }


    function LoadModifyEmail()
    {
        return View::make('user.ajax.load_modify_email');
    }

    function SendEmailCode()
    {
        $email = $this->params['new_email'];
        $aRule = array('new_email' => 'required | email');
        $aCode = array(
            'new_email' => array(
                ProfessionErrorCodeEnum::ERROR_EMAIL_NULL,
                ProfessionErrorCodeEnum::ERROR_EMAIL_FAILURE,
            )
        );
        $this->validatorError($aRule,$aCode);
        //检查email是否已存在
        if(UserService::instance()->checkExits($email))
            $this->professionError(ProfessionErrorCodeEnum::ERROR_EMAIL_EXISTED);
        //检测验证码
        if(CacheService::instance()->exists($email,UserEnum::USER_VERIFICATION_CODE_TAG))
            $this->professionError(ProfessionErrorCodeEnum::ERROR_VERIFICATION_CODE_EXIST);
        //发送验证码
        $code = ToolKit::mkValidatorCode(6);
        $user_name = UserService::getUserCache()->user_name;
        MailService::instance()->sendByMQ('emails.user.modify_email',array(
            'user_name' => $user_name,
            'code' => $code
        ),$email,$user_name,'toushibao.com');
        CacheService::instance()->set($email,$code,24*60,UserEnum::USER_VERIFICATION_CODE_TAG);
        $this->rest->success();
    }

    function ModifyEmail()
    {
        $email = $this->params['new_email'];
        $code = $this->params['email_code'];
        //验证code
        if(!$code)
            $this->professionError(ProfessionErrorCodeEnum::ERROR_VERIFICATION_CODE_NULL);
        if(!CacheService::instance()->exists($email,UserEnum::USER_VERIFICATION_CODE_TAG))
            $this->professionError(ProfessionErrorCodeEnum::ERROR_VERIFICATION_CODE_EXPIRED);
        if($code != CacheService::instance()->get($email,UserEnum::USER_VERIFICATION_CODE_TAG))
            $this->professionError(ProfessionErrorCodeEnum::ERROR_VERIFICATION_CODE_WRONG_);
        //修改email
        if(!UserService::instance()->modifyUserEmail($email))
            $this->rest->error();
        //释放cache
        CacheService::instance()->del($email,UserEnum::USER_VERIFICATION_CODE_TAG);
        //重新设置用户信息cache
        $ticket = Cookie::get(UserEnum::USER_INFO_COOKIE_KEY);
        UserService::instance()->setUserCache($ticket);
        $this->rest->success();
    }

    function LoadMobileAuth()
    {

    }

    function SendMobileCode()
    {

    }

    function AuthMobile()
    {

    }
}