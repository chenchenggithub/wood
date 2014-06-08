<?php
/**
 * @author Neeke.Gao
 * Date: 14-5-12 下午1:12
 *
 *
 * demo:
 *
 * 1、normal cache
 * $oCacheService = CacheService::instance();
 * $oCacheService->set('username',$username,$minutes);
 * $oCacheService->get('username');
 *
 * 2、cache with tags
 *
 * $oCacheService->set('username',$username,(int)$minutes,(array)$tags);
 * $oCacheService->get('username',(array)$tags);
 *
 * 3、del a cache
 * 当tags为空时，只删除一个key
 * 当tags不为空时，清空该tags下所有cache
 * $oCacheService->del('username',(array)$tags);
 *
 */

class CacheService extends BaseService
{
    private static $self = NULL;

    /**
     *
     * @return CacheService
     */
    static public function instance()
    {
        if (self::$self == NULL) {
            self::$self = new self;
        }

        return self::$self;
    }

    public function getCacheStore()
    {
        return Cache::getStore();
    }


    /**
     * 检测是否存在某key 或 某tags下某key
     * @param $key
     * @param null $tags
     * @return mixed
     */
    public function exists($key, $tags = NULL)
    {
        if (empty($tags)) return Cache::has($key);

        if (!is_array($tags)) $tags = array($tags);
        return Cache::tags($tags)->get($key);
    }

    /**
     * 设置某key值 或 某tags下某key值
     * @param $key
     * @param $value
     * @param int $expireTime
     * @param null $tags
     * @return mixed
     */
    public function set($key, $value, $expireTime = 0, $tags = NULL)
    {
        $expireTime = self::getiExpiresAt($expireTime);

        if (is_null($tags)) {
            if (self::exists($key)) self::del($key);

            Cache::put($key, $value, $expireTime);
        } else {
            $tags = self::getaTags($tags);
            if (self::exists($key, $tags)) self::del($key, $tags);
            Cache::tags($tags)->put($key, $value, $expireTime);
        }

        return TRUE;
    }

    /**
     * 取得某key对应值 或 某tags下某key对应值
     * @param $key
     * @param null $default
     * @param null $tags
     * @return mixed
     */
    public function get($key, $tags = NULL, $default = NULL)
    {
        if (is_null($tags)) {
            return Cache::get($key, $default);
        } else {
            $tags = self::getaTags($tags);
            return Cache::tags($tags)->get($key, $default);
        }
    }

    /**
     * 删除某key 或 某tags下所有key
     * @param $key
     * @param null $tags
     * @return mixed
     */
    public function del($key, $tags = NULL)
    {
        if (is_null($tags)) {
            return Cache::forget($key);
        } else {
            $tags = self::getaTags($tags);
            if (!empty($key)) {
                return Cache::tags($tags)->forget($key);
            } else {
                return Cache::tags($tags)->flush();
            }
        }
    }


    private function getiExpiresAt($expireTime = 0)
    {
        if ((int)$expireTime <= 0) $expireTime = CacheExpireEnum::EXPIRE_DEFAULT;

        return $expireTime;
    }

    private function getaTags($tags = NULL)
    {
        if (!is_array($tags) && !empty($tags)) $tags = array($tags);
        return $tags;
    }
}