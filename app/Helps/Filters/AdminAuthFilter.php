<?php
/**
 * @author Neeke.Gao
 * Date: 14-5-29 下午4:29
 */
class Filters_AdminAuthFilter extends Filters_BaseFilter
{
    public function filter()
    {
        if (Session::has(AdminMenuEnum::ADMIN_SESSION_KEY)) {
            $admin_info  = Session::get(AdminMenuEnum::ADMIN_SESSION_KEY);
            $admin_email = $admin_info->admin_email;

            //检测admin是否存在
            AdminService::instance()->setRequestAdminInfoParams(array('admin_email' => $admin_email));
            if (!AdminService::instance()->checkExists()) {
                throw new Exception(NULL, ProfessionErrorCodeEnum::ERROR_ACCOUNT_NOT_EXIST);
            }

            //检测状态
            if ($admin_info->admin_status != UserEnum::ADMIN_STATUS_NORMAL) {
                throw new Exception(NULL, ProfessionErrorCodeEnum::ERROR_ACCOUNT_UNAVAILABLE);
            }

            //检测action
            $action      = Route::currentRouteAction();
            $action_info = explode('@', $action);
            $adminMenus  = AdminMenuEnum::getMenu();
            if (!isset($adminMenus[$action_info[1]])) {
                throw new Exception(NULL, ProfessionErrorCodeEnum::STATUS_ERROR_API_EXISTS);
            }

            $rightMenus = AdminMenuEnum::getRightMenu($admin_info->admin_right);
            if (!in_array($action_info[1], $rightMenus)) {
                throw new Exception(NULL, ProfessionErrorCodeEnum::ERROR_NO_ACCESS);
            }
        } else {
            return Redirect::to('/login');
        }
    }
}