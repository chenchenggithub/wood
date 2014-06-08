<?php
/**
 * @author Neeke.Gao
 * Date: 14-5-23 下午12:22
 */
class DomainSpall
{
    static public function processSiteUrl($iSiteId)
    {
        return '/site/board/overview/' . (int)$iSiteId;
    }

    static private $boardTpl = 'overview';

    /**
     * 设置目录
     * @param $tab
     * @return array
     */
    static public function processSiteBoardMenu($tab)
    {
        $menus = DomainMenuEnum::$boardMenus;
        foreach ($menus as $key => $menu) {
            if ($key == $tab) {
                $menus[$key]['active'] = TRUE;
                self::$boardTpl        = $menu['tpl'];
                continue;
            }
        }

        return $menus;
    }

    /**
     * 取得board模板页
     * @return string
     */
    static public function processSiteBoardTpl()
    {
        return self::$boardTpl;
    }

    /**
     * 取得服务类型监控点设置
     * @param $app_id
     * @param $target_type
     * @param $target_id
     * @param $service_type
     * @return string
     */
    static public function processSettingMonitorUrl($app_id, $target_type, $target_id, $service_type)
    {
        $url = '/ajax/service/setting/monitor/%d/%d/%d/%d';

        return sprintf($url, $app_id, $target_type, $target_id, $service_type);
    }

    /**
     * 取得服务类型其他设置
     * @param $app_id
     * @param $target_type
     * @param $target_id
     * @param $service_type
     * @return string
     */
    static public function processSettingOtherUrl($app_id, $target_type, $target_id, $service_type)
    {
        $url = '/ajax/service/setting/other/%d/%d/%d/%d';

        return sprintf($url, $app_id, $target_type, $target_id, $service_type);
    }

    /**
     * @param $monitorListDefault
     * @param array $monitorListChoose
     *
     * @return string
     */
    static public function mkMonitorByAreaGroup($monitorListDefault, $monitorListChoose = array())
    {
        $str = '';

        if (!is_array($monitorListDefault) || count($monitorListDefault) < 1) return $str;

        $monitorsAll = MonitorEnum::getMonitors();

        $monitorListByAreaGroup = MonitorEnum::$monitorsByGroupArea;
        $monitorAreaGroup       = MonitorEnum::$monitorGroupsArea;

        foreach ($monitorListByAreaGroup as $areaGroup => $monitors) {
            $aIntersect = array_intersect($monitors, $monitorListDefault);
            if (is_array($aIntersect) && count($aIntersect) > 0) {
                $str .= '<div class="m_title">' . $monitorAreaGroup[$areaGroup] . '</div>';
                $str .= '<div class="m_body">';
                foreach ($aIntersect as $monitorKey) {
                    $str .= '<label class="checkbox">';
                    $str .= '<input type="checkbox" name="monitor_list[]" value="' . $monitorKey . '"';
                    if (in_array($monitorKey, $monitorListChoose)) {
                        $str .= 'checked';
                    }
                    $str .= '> ';
                    $str .= $monitorsAll[$monitorKey][1];
                    $str .= '</label>';
                }
                $str .= '</div>';
            }
        }
        return $str;
    }

    static public function setSiteMenuActive($activeClass)
    {
        $aActive = array();
        $path = Request::path();

        foreach (ProjectEnum::$siteMenu as $_path => $_label) {
            if (strstr($path, $_path)) {
                $aActive[$_path] = $activeClass;
            } else {
                $aActive[$_path] = '';
            }
        }
        return $aActive;
    }

    static public function setAlertMenuActive($activeClass)
    {
        $aActive = array();
        $path = Request::path();

        foreach (ProjectEnum::$alertMenu as $_path => $_label) {
            if (strstr($path, $_path)) {
                $aActive[$_path] = $activeClass;
            } else {
                $aActive[$_path] = '';
            }
        }
        return $aActive;
    }
}