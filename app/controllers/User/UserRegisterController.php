<?php
/**
 * Created by PhpStorm.
 * User: dengchao
 * Date: 14-5-16
 * Time: 下午3:34
 */
class User_UserRegisterController extends BaseController
{
    public function showApply()
    {
        return View::make('user.apply')->with(array(
            'industry' => UserEnum::getCompanyIndustry(),
        ));
    }

    /**
     * 用户注册
     */
    public function applyDispose()
    {
        //验证
        $rules = array(
            'user_email' => 'required | email',
            'user_name'  => 'required',
            'user_mobile' => array('required','regex:/^1[3458][0-9][0-9]{8}$/'),
            'company_name' => 'required',
        );
        $codes = array(
            'user_email' => array(
                ProfessionErrorCodeEnum::ERROR_EMAIL_NULL,
                ProfessionErrorCodeEnum::ERROR_EMAIL_FAILURE,
            ),
            'user_name' => array(
                ProfessionErrorCodeEnum::ERROR_USERNAME_NULL,
            ),
            'user_mobile' => array(
                ProfessionErrorCodeEnum::ERROR_USER_MOBILE_NULL,
                ProfessionErrorCodeEnum::ERROR_USER_MOBILE_FAILURE,
            ),
            'company_name' => array(
                ProfessionErrorCodeEnum::ERROR_COMPANY_NAME_NULL,
            )
        );
        $this->validatorError($rules,$codes);
        //添加注册
        UserRegisterService::instance()->setRequestRegisterInfoParams($this->params);
        if(UserRegisterService::instance()->checkRegister())
        {
            $this->professionError(ProfessionErrorCodeEnum::ERROR_EMAIL_EXISTED);
        }
        if(!UserRegisterService::instance()->createRegister())
        {
            $this->professionError(ProfessionErrorCodeEnum::ERROR_USER_REGISTER_FAIL);
        }
        $this->rest->success();
    }

    /***
     * 处理申请用户
     * @return bool
     */
    public function ajaxDisposeRegister()
    {
        UserRegisterService::instance()->setRequestRegisterInfoParams($this->params);
        $info = UserRegisterService::instance()->getRegisterInfo();
        if(!$info) $this->rest->error();
        //审核通过
        if($this->params['register_status'] == UserEnum::REGISTER_STATUS_PASS)
        {
            BaseModel::transStart();
            if(!UserRegisterService::instance()->RegisterApplyPass($info))
            {
                BaseModel::transRollBack();
                $this->rest->error();
            }
            $this->rest->success();
        }
        //审核失败
        if($this->params['register_status'] == UserEnum::REGISTER_STATUS_FAIL)
        {
            if(!UserRegisterService::instance()->RegisterApplyNotPass($info))
                $this->rest->error();
            $this->rest->success();
        }
    }
}