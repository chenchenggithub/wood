<?php
/**
 * Created by PhpStorm.
 * User: dengchao
 * Date: 14-5-16
 * Time: 下午3:55
 */
class UserRegisterService extends BaseService
{
    private $mUserRegisterModel = NULL;

    public function __construct()
    {
        $this->mUserRegisterModel = new User_UserRegisterInfoModel();
    }

    private static $self = NULL;

    public static function instance()
    {
        if (self::$self == NULL) {
            self::$self = new self;
        }
        return self::$self;
    }

    /**
     * @var VO_Request_DimRegister
     */
    private $oRegisterUserInfo = NULL;

    public function setRequestRegisterInfoParams($params)
    {
        $this->oRegisterUserInfo = VO_Bound::Bound($params, NEW VO_Request_DimRegister());
        return $this->oRegisterUserInfo;
    }

    public function createRegister()
    {
        $aData = $this->mUserRegisterModel->mkInfoForInsert($this->oRegisterUserInfo);
        return $this->mUserRegisterModel->insert($aData);
    }

    public  function checkRegister()
    {
        $email = $this->oRegisterUserInfo->user_email;
        $where = array('user_email = ?' => $email);
        return $this->mUserRegisterModel->exists($where);
    }

    /**
     * @return VO_Response_DimRegister
     */
    public function getRegisterInfo()
    {
        $register_id = $this->oRegisterUserInfo->register_id;
        if (!$register_id) return null;
        return $this->mUserRegisterModel->fetchRow($register_id);
    }

    public function updateStatus()
    {
        $register_id     = $this->oRegisterUserInfo->register_id;
        $register_status = $this->oRegisterUserInfo->register_status;
        $aData           = array('register_status' => $register_status);
        if (!$register_id || !$register_status) return false;
        return $this->mUserRegisterModel->update($aData, $register_id);
    }

    /**
     * @param null $offset
     * @param null $limit
     * @return VO_Request_DimRegister
     */
    public function getRegisterUsers($offset = null,$limit = null)
    {
        $register_status = $this->oRegisterUserInfo->register_status;
        $where = array();
        if($register_status)
        {
            $where = array('register_status = ?' => $register_status);
        }
        $order = array('register_time'=>'asc');
        if(!is_null($offset) && !is_null($limit))
        {
            $this->mUserRegisterModel->setLimit($offset,$limit);
        }
        $user_list = $this->mUserRegisterModel->fetchAll($where,array(),$order);
        if(!$user_list) return array();
        return $user_list;
    }

    public function getRegisterUsersCount()
    {
        $register_status = $this->oRegisterUserInfo->register_status;
        $where = array();
        if($register_status)
        {
            $where = array('register_status = ?' => $register_status);
        }
        $count = $this->mUserRegisterModel->count($where);
        return $count;
    }

    public function updateRelationshipUser($user_id)
    {
        $register_id = $this->oRegisterUserInfo->register_id;
        $aData = array('relationship_user'=>$user_id);
        return $this->mUserRegisterModel->update($aData,$register_id);
    }

    /**
     * @param $user_id
     * @return VO_Response_DimRegister
     */
    public function getRegisterInfoByRelationshipUser($user_id)
    {
        if(!$user_id) return null;
        $where = array('relationship_user = ?' => $user_id);
        return $this->mUserRegisterModel->fetchRow($where);
    }

    /**
     * 生成随机密码
     * @param $length
     * @return string
     */
    public static  function makePassword($length)
    {
        $pattern = '1234567890@#$%^&*abcdefghijklmnopqrstuvwxyz';//字符池,可任意修改
        $key = '';
        for($i=0;$i<$length;$i++)
        {
            $key .= $pattern{mt_rand(0,strlen($pattern)-1)};//生成php随机数
        }
        return $key;
    }


    /**
     * 用户审核通过
     * @param $info
     * @return bool
     */
    public function RegisterApplyPass($info)
    {
        $uParams = array();
        foreach($info as $key => $value)
        {
            $uParams[$key] = $value;
        }
        $uParams['user_pass'] = self::makePassword(6);
        UserService::instance()->setRequestUserInfoParams($uParams);
        //创建用户
        if(UserService::instance()->checkExits($info->user_email)) return false;
        $user_id = UserService::instance()->createUser();
        if(!$user_id) return false;
        //关联user_id
        if(!self::updateRelationshipUser($user_id)) return false;
        //修改状态
        if(!UserRegisterService::instance()->updateStatus()) return false;
        //发送邮件
        $token = md5(time().$user_id.$info->user_email);
        MailService::instance()->sendByMQ('emails.user.user_activate',array(
            'user_name' => $info->user_name,
            'password'  => $uParams['user_pass'],
            'token'     => $token,
        ),$info->user_email,$info->user_name,'toushibao.com');
        //生成cache
        CacheService::instance()->set($token,$info->user_email,7*24*60);
        return true;
    }

    public function RegisterApplyNotPass($info)
    {
        if(!UserRegisterService::instance()->updateStatus()) return false;
        //发送邮件
        MailService::instance()->sendByMQ('emails.user.register_not_pass',
            array(
        ),$info->user_email,$info->user_name,'toushibao.com');
        return true;
    }
}