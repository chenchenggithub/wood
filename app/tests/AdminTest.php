<?php
/**
 * Created by PhpStorm.
 * User: dengchao
 * Date: 14-5-15
 * Time: 下午4:48
 */
class AdminTest extends TestCase
{

    protected $app_config = 'local';
    /*
    function testAdminAdd ()
    {
        $params = array();
        $params['admin_email'] = 'chao.deng@yunzhihui.com';
        $params['admin_name'] = 'dengchao';
        $params['admin_right'] = UserEnum::ADMIN_RIGHT_MANAGER;
        $params['parent_manager'] = 0;

        //$this->action('GET', 'Admin_AdminController@getAdminInfo');
        $response = $this->action('POST','Admin_AdminController@addAdminDispose',$params);
    }
    */

    function testEmail()
    {

        MailService::instance()->sendByMQ('emails.user.user_activate',array(
            'user_name' => 'dengchao',
            'password'  => '123456',
            'token'     => 'dsakdjlsajldkjlasd',
        ),'286884912@qq.com','dengchao','welcome');

        /*
        MailService::instance()->send('emails.user.user_activate',array(
            'user_name' => 'dengchao',
            'password'  => '123456',
            'token'     => 'dsakdjlsajldkjlasd',
        ),function(){
            echo 'welcome';
        });
        */
    }
}