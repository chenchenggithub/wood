<?php
/**
 * @author Neeke.Gao
 * Date: 14-5-22 下午1:53
 */
class MQRedisService extends BaseService
{

    /**
     * @var MQRedisService
     */
    private static $self = NULL;

    /**
     * @static
     * @return MQRedisService
     */
    public static function instance()
    {
        if (self::$self == NULL) {
            self::$self = new self;
        }
        return self::$self;
    }

    /**
     * @var Redis
     */
    private $oRedis;

    /**
     * @var string
     */
    private $sQName = 'default';

    public function __construct()
    {
        if (!class_exists('Redis')) {
            throw new Exception('php-redis can not work',ErrorCodeEnum::STATUS_SUCCESS_DO_ERROR_KV);
        }

        $redisHost = Config::get('database.redis.default.host');
        $redisPort = Config::get('database.redis.default.port');

        $this->oRedis = new Redis();
        $this->oRedis->connect($redisHost, $redisPort);
    }

    /**
     * @param $sName
     */
    public function setQName($sName)
    {
        $this->sQName = $sName;
    }

    /**
     * 入栈 顶（左）
     * @param $value
     * @return int
     */
    public function push($value)
    {
        return $this->oRedis->lPush($this->sQName, $value);
    }

    /**
     * 出栈 底（右）
     * @return string
     */
    public function pop()
    {
        return $this->oRedis->rPop($this->sQName);
    }
}