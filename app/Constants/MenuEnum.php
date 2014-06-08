<?php
/**
 * Created by PhpStorm.
 * User: dengchao
 * Date: 14-5-26
 * Time: 上午11:07
 */
class MenuEnum
{
    /*****菜单属性*****/
    const TYPE   = 'type';
    const PARENT = 'parent';
    const LABEL  = 'label';
    const URL    = 'url';
    const GROUP  = 'group';
    const LEAF   = 'leaf';
    const ACTIVE = 'active';

    /*****type属性*****/
    const MENU_TYPE_TOP = 1; //顶部水平导航
    const MENU_TYPE_LEFT = 2; //左边垂直导航
    const MENU_TYPE_RIGHT = 3; //右边垂直导航
    const MENU_TYPE_BUTTON = 4; //功能性按钮
    const MENU_TYPE_AJAX = 5; //ajax请求


    protected static $newMenus = array(); //生成的带选中状态的导航
    private static $baseMenus = array(); //原始导航目录
    private static $parentMenus = array(); //所有当前导航的父导航
    protected static $rootParent = ''; //当前导航的根目录

    /*****group*****/
    const MENU_GROUP_ACCOUNT  = 1;
    const MENU_GROUP_BUY      = 2;
    const MENU_GROUP_TEMPLATE = 3;

    private static $menuGroups = array(
        self::MENU_GROUP_ACCOUNT  => '账户信息',
        self::MENU_GROUP_BUY      => '购买',
        self::MENU_GROUP_TEMPLATE => '模板管理',
    );

    public static function getMenuGroups()
    {
        return self::$menuGroups;
    }

    protected static function mkNewMenus(array $baseMenu)
    {
        self::$baseMenus = $baseMenu;
        $action          = self::getCurrentAction();
        self::findParentMenu($action);
        if (!empty(self::$parentMenus)) {
            foreach (self::$parentMenus as $value) {
                $baseMenu[$value][self::ACTIVE] = TRUE;
            }
        }
        $baseMenu[$action][self::ACTIVE] = TRUE;
        self::$newMenus                  = $baseMenu;
    }

    protected static function setMenus(array $menus)
    {
        $aMenus = array();
        foreach ($menus as $menu) {
            if (empty(self::$newMenus[$menu][self::PARENT])) {
                if (!isset($aMenus[$menu])) $aMenus[$menu] = self::$newMenus[$menu];
            } else {
                $parent = self::$newMenus[$menu][self::PARENT];
                if (!isset($aMenus[$parent])) {
                    $aMenus[$parent] = self::$newMenus[$parent];
                }
                $aMenus[$parent][self::LEAF][] = self::$newMenus[$menu];
            }
        }
        return $aMenus;
    }

    protected static function getCurrentAction()
    {
        $actionStr = Route::currentRouteAction();
        $aAction   = explode('@', $actionStr);
        $action    = $aAction[1];
        return $action;
    }

    protected static function findParentMenu($key)
    {
        $menus = self::$baseMenus;
        if (array_key_exists($key, $menus)
            && array_key_exists(self::PARENT, $menus[$key])
            && !empty($menus[$key][self::PARENT])
        ) {
            $parent = $menus[$key][self::PARENT];
            array_push(self::$parentMenus, $parent);
            self::findParentMenu($parent);
        }
    }

    protected static function getRootParent($key)
    {
        if (array_key_exists(self::PARENT, self::$baseMenus[$key])
            && empty(self::$baseMenus[$key][self::PARENT])
        ) {
            self::$rootParent = $key;
        } else {
            $parent = self::$baseMenus[$key][self::PARENT];
            self::getRootParent($parent);
        }
    }
}