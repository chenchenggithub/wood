<?php
/**
 * Created by PhpStorm.
 * User: dengchao
 * Date: 14-6-6
 * Time: 下午5:29
 */
class UserPersonalSettingService extends BaseService
{
    private static $self = NULL;

    /**
     * @return UserPersonalSettingService
     */
    static public function instance()
    {
        if (self::$self == NULL) {
            self::$self = new self;
        }
        return self::$self;
    }

    /**
     * @var VO_Request_DimUserPersonal
     */
    private $oUserPersonalSetting = null;

    /**
     * @param $params
     * @return VO_Request_DimUserPersonal
     */
    public function setRequestParams($params)
    {
        $this->oUserPersonalSetting = VO_Bound::Bound($params,NEW VO_Request_DimUserPersonal());
        return $this->oUserPersonalSetting;
    }

    private $mUserPersonalModel = null;

    public function __construct()
    {
        $this->mUserPersonalModel = new User_UserPersonalSettingModel();
    }


    public function createUserPersonalSet()
    {
        $aData = $this->mUserPersonalModel->mkParamsForInsert($this->oUserPersonalSetting);
        return $this->mUserPersonalModel->insert($aData);
    }

    public function modifyUserPersonalSet($user_id)
    {
        if(!$user_id) return false;
        $aUpdate = $this->mUserPersonalModel->mkParamsForUpdate($this->oUserPersonalSetting);
        return $this->mUserPersonalModel->update($aUpdate,$user_id);
    }

    public function getUserAlertSetting($user_id)
    {
        if(!$user_id) return null;
        $this->mUserPersonalModel->setSelect(array('alert_style_setting'));
        $result = $this->mUserPersonalModel->fetchRow($user_id);
        $this->mUserPersonalModel->removeSelect();
        if(!$result) return null;
        return json_decode($result->alert_style_setting);
    }

}