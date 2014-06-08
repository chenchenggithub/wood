<?php
/**
 * Created by PhpStorm.
 * User: dengchao
 * Date: 14-5-16
 * Time: 下午4:27
 */
class UserTest extends TestCase
{
    /*
    public function testCreateRegister()
    {
        $params = array(
            'user_email' => 'dengsingle@163.com',
            'user_name' => 'dengsingle',
            'company_name' => 'yunzhihui',
            'company_url' => 'www.toushibao.com',
            'company_industry' => '1',
            'user_mobile' => '18701685846',
        );
        UserRegisterService::instance()->setRequestRegisterInfoParams($params);
        UserRegisterService::instance()->createRegister();
    }

    public function testGetRegister()
    {
        $register_id = 3;
        UserRegisterService::instance()->getRegisterInfo($register_id);
    }
    */

    /**
     * 用户审核通过

    public function testCreateUser()
    {
        $params = array('register_status' => UserEnum::REGISTER_STATUS_NORMAL);
        UserRegisterService::instance()->setRequestRegisterInfoParams($params);
        $register_users = UserRegisterService::instance()->getRegisterUsers();
        foreach($register_users as $user)
        {
            $user_params = array();
            $user_params['user_name'] = $user->user_name;
            $user_params['user_email'] = $user->user_email;
            $user_params['user_pass'] = '123456';
            $user_params['user_mobile'] = $user->user_mobile;
            UserService::instance()->setRequestUserInfoParams($user_params);
            if(!UserService::instance()->createUser()) continue;

            $register_params = array();
            $register_params['register_id'] = $user->register_id;
            $register_params['register_status'] = UserEnum::REGISTER_STATUS_PASS;
            UserRegisterService::instance()->setRequestRegisterInfoParams($register_params);
            UserRegisterService::instance()->updateStatus();

            //发送邮件

        }
    }

    private function makePassword($length)
    {
        $pattern = '1234567890abcdefghijklmnopqrstuvwxyz';//字符池,可任意修改
        $key = '';
        for($i=0;$i<$length;$i++)
        {
            $key .= $pattern{mt_rand(0,35)};//生成php随机数
        }
        return $key;
    }
    */

    /***
     * 激活用户
     **/
    public function testActivateUser()
    {
        $params = array(
          'user_email' => 'taobao@163.com',
        );
        $this->action('GET','User_UserController@UserActivate',$params);
    }

}