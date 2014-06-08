<?php
/**
 * @author Neeke.Gao
 * Date: 14-5-14 下午3:49
 */

class ResourceSpall
{
    static private $version = NULL;

    static public function getResourceVersion()
    {
        if (is_null(self::$version)) {
            self::$version = Config::get('app.resource.version');
        }

        return self::$version;
    }
}