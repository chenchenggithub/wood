<?php
/**
 * Created by PhpStorm.
 * User: dengchao
 * Date: 14-5-12
 * Time: 下午2:19
 */
class AdminService extends BaseService
{
    private static $self = NULL;
    private  $adminInfoModel = NULL;

    /**
     * @var VO_Request_DimAdmin
     */
    private  $oAdminInfo = NULL;

    public function __construct()
    {
        $this->adminInfoModel = new Admin_AdminInfoModel();
    }

    public static function instance()
    {
        if (self::$self == NULL)
        {
            self::$self = new self;
        }
        return self::$self;
    }

    /**
     * @param $params
     * @return VO_Request_DimAdmin
     */
    public function setRequestAdminInfoParams($params)
    {
        $this->oAdminInfo = VO_Bound::Bound($params, new VO_Request_DimAdmin());
        return $this->oAdminInfo;
    }

    /**
     * 添加管理员
     * @return int
     */
    public function  addAdminInfo()
    {
        $aData = $this->adminInfoModel->mkInfoForInsert($this->oAdminInfo);
        return $this->adminInfoModel->insert($aData);
    }

    /**
     * 根据email获取信息
     * @param null $email
     * @return VO_Response_DimAdmin
     */
    public function getInfoByEmail($email = null)
    {
        if(is_null($email))
            $email = $this->oAdminInfo->admin_email;
        $where = array('admin_email'=>$email);
        $result = $this->adminInfoModel->fetchRow($where);
        return $result;
    }

    /**
     * 检查email是否存在
     * @param null $email
     * @return bool
     */
    public function checkExists($email = null)
    {
        if(is_null($email))
            $email = $this->oAdminInfo->admin_email;
        $where = array('admin_email = ?'=>$email);
        return $this->adminInfoModel->exists($where);
    }

    /**
     * @param null $admin_id
     * @return VO_Response_DimAdmin
     */
    public function getInfo($admin_id = null)
    {
        if(is_null($admin_id))
            $admin_id = $this->oAdminInfo->admin_id;
        if(!$admin_id) return null;
        return $this->adminInfoModel->fetchRow($admin_id);
    }

    /**
     * 修改登录时间
     * @param null $admin_id
     * @return bool
     */
    public function updateLoginTime($admin_id = null)
    {
        if(is_null($admin_id))
            $admin_id = $this->oAdminInfo->admin_id;
        if(!$admin_id) return false;
        $aData = $this->adminInfoModel->mkInfoForUpdateLoginTime($this->oAdminInfo);
        return $this->adminInfoModel->update($aData,$admin_id);
    }

    /**
     * 获取角色
     * @return null
     */
    public function getAdminRight()
    {
        if(Session::has(AdminMenuEnum::ADMIN_SESSION_KEY))
        {
            return Session::get(AdminMenuEnum::ADMIN_SESSION_KEY)->admin_right;
        }
        $admin_id = $this->oAdminInfo->admin_id;
        $this->adminInfoModel->setSelect(array('admin_right'));
        $oResult = $this->adminInfoModel->fetchRow($admin_id);
        if(!$oResult) return null;
        return $oResult->admin_right;
    }

    /**
     * 获取角色可访问的菜单
     * @return array
     */
    public function getRightMenu()
    {
        $right = self::getAdminRight();
        $rights = UserEnum::getAdminRight();
        if (!isset($rights[$right])) return array();
        $menus = AdminMenuEnum::getAdminLeftMenu($right);
        return $menus;
    }
}