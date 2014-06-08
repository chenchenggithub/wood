<?php
/**
 * Created by PhpStorm.
 * User: admin-chen
 * Date: 14-5-20
 * Time: 下午6:38
 */

class User_UserAdminController extends BaseController{
    /**
     * 展示用户基本信息
     */
    public function showBasicInfo(){
        $this->view('user.basic_info')->with('select_label',UserAdminMenuEnum::BASIC_INFO);
    }
} 