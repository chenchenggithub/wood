<?php
/**
 * @author Neeke.Gao
 * Date: 14-5-29 下午4:22
 */
class Filters_UserAuthFilter extends Filters_BaseFilter
{
    public function filter()
    {
        if (Cookie::has(UserEnum::USER_INFO_COOKIE_KEY)) {
            $ticket = Cookie::get(UserEnum::USER_INFO_COOKIE_KEY);

            if (!CacheService::instance()->exists($ticket, UserEnum::USER_INFO_CACHE_TAG)) {
                UserService::instance()->setUserCache($ticket);
            }

            //验证用户
            $oUserCache = UserService::getUserCache();
            if ($oUserCache->user_status != UserEnum::USER_STATUS_NORMAL) {
                Cookie::forget(UserEnum::USER_INFO_COOKIE_KEY);
                CacheService::instance()->del($ticket);
                throw new Exception(NULL, ProfessionErrorCodeEnum::ERROR_ACCOUNT_UNAVAILABLE);
            }

            //验证访问权限
            $action      = Route::currentRouteAction();
            $action_info = explode('@', $action);
            $aMenus      = UserMenuEnum::getTsbMenus();
            if (!isset($aMenus[$action_info[1]])) {
                throw new Exception(NULL, ProfessionErrorCodeEnum::STATUS_ERROR_API_EXISTS);
            }

            $rightMenus = UserMenuEnum::getUserMenus($oUserCache->role_right);
            if (!in_array($action_info[1], $rightMenus)) {
                throw new Exception(NULL, ProfessionErrorCodeEnum::ERROR_NO_ACCESS);
            }

        } else {
            return Redirect::to('/signin');
        }
    }
}