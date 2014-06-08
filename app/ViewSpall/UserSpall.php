<?php
/**
 * demo
 * spall helper for views
 */
class UserSpall
{

    /**
     * 取得状态对应标签
     * @param $status
     * @return string
     */
    static public function statusLable($status)
    {
        if (empty($status)) return '';

        switch ($status) {
            case UserEnum::STATUS_NORMAL:
                return '正常';
                break;

            case UserEnum::STATUS_OFFLINE:
                return '已下线';
                break;

            default:
                return '未知';
        }
    }

    /**
     * 取得注册用户状态
     * @param $status
     * @return string
     */
    static public function registerStatusLabel($status)
    {
        if(empty($status)) return '';
        $aStatus = UserEnum::getRegisterStatus();
        if(isset($aStatus[$status]))
            return $aStatus[$status];
        return 'undefault';
    }

    /**
     * 获取用户状态标签
     * @param $status
     * @return string
     */
    static public function userStatusLabel($status)
    {
        if(empty($status)) return '';
        $userStatus = UserEnum::getUserStatus();
        if(array_key_exists($status,$userStatus))
            return $userStatus[$status];
        return '';
    }
}