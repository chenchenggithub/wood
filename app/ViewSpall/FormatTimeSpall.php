<?php
class FormatTimeSpall
{
    static private function getRealTimestamp($timestamp)
    {
        return is_null($timestamp) ? time() : (int)$timestamp;
    }

    /**
     * 时间格式：年-月-日 小时:分钟:秒
     * @param int $timestamp
     * @return bool|string
     */
    static public function YmdHis($timestamp = NULL)
    {
        return date('Y-m-d H:i:s', self::getRealTimestamp($timestamp));
    }

    /**
     * 时间格式：年-月-日 小时:分钟
     * @param int $timestamp
     * @return bool|string
     */
    static public function YmdHi($timestamp = NULL)
    {
        return date('Y-m-d H:i', self::getRealTimestamp($timestamp));
    }

    /**
     * 时间格式：年-月-日
     * @param int $timestamp
     * @return bool|string
     */
    static public function Ymd($timestamp = NULL)
    {
        return date('Y-m-d', self::getRealTimestamp($timestamp));
    }
}