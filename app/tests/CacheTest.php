<?php
/**
 * @author Neeke.Gao
 * Date: 14-5-13 下午12:26
 */

class classDemo
{
    private $a = NULL;

    public function __construct()
    {
        $this->a = 'testDemo';
    }
}

class CacheTest extends TestCase
{
    protected $app_config = 'local';

    private $testKeyArray = 'test_key_array';
    private $testKeyInt = 'test_key_int';
    private $testKeyString = 'test_key_string';
    private $testKeyObj = 'test_key_obj';

    private $testTags = array('tag1', 'tag2');
    private $testExpireTime = 10;

    private $testValueArray = array('1', 'a', 'b');
    private $testValueInt = 100;
    private $testValueString = 'this is a string';
    private $testValueString_2 = 'this is a string 2';
    private $testValueObj = NULL;

    public function testGetCacheStore()
    {
        $store = CacheService::instance()->getCacheStore();
        $this->assertTrue(is_object($store));

        $this->assertTrue(Config::get('cache.driver') == 'redis');
    }

    public function testSetCache()
    {
        $result = CacheService::instance()->set($this->testKeyArray, $this->testValueArray);
        $this->assertTrue($result);

        $result = CacheService::instance()->set($this->testKeyInt, $this->testValueInt);
        $this->assertTrue($result);

        $result = CacheService::instance()->set($this->testKeyString, $this->testValueString);
        $this->assertTrue($result);

        $result = CacheService::instance()->set($this->testKeyObj, new classDemo());
        $this->assertTrue($result);
    }

    public function testGetCache()
    {
        $result = CacheService::instance()->get($this->testKeyString);
        $this->assertTrue($result == $this->testValueString);

        $result = CacheService::instance()->get($this->testKeyObj);
        $this->assertTrue($result == new classDemo());
    }

    public function testDelCache()
    {
        $result = CacheService::instance()->set($this->testKeyString, $this->testValueString_2);
        $this->assertTrue($result);

        CacheService::instance()->del($this->testKeyString);

        $result = CacheService::instance()->get($this->testKeyString);
        $this->assertFalse($result == $this->testValueString_2);
    }

    public function testSetCacheWithTags()
    {
        $result = CacheService::instance()->set($this->testKeyArray, $this->testValueArray, NULL, $this->testTags);
        $this->assertTrue($result);

        $result = CacheService::instance()->set($this->testKeyInt, $this->testValueInt, NULL, $this->testTags);
        $this->assertTrue($result);

        $result = CacheService::instance()->set($this->testKeyString, $this->testValueString, NULL, $this->testTags);
        $this->assertTrue($result);

        $result = CacheService::instance()->set($this->testKeyObj, new classDemo(), NULL, $this->testTags);
        $this->assertTrue($result);
    }

    public function testGetCacheWithTags()
    {
        $result = CacheService::instance()->get($this->testKeyString, $this->testTags);
        $this->assertTrue($result == $this->testValueString);

        $result = CacheService::instance()->get($this->testKeyObj, $this->testTags);
        $this->assertTrue($result == new classDemo());
    }

    public function testDelCacheWithTags()
    {
        $result = CacheService::instance()->set($this->testKeyString, $this->testValueString, NULL, $this->testTags);
        $this->assertTrue($result);

        CacheService::instance()->del($this->testKeyString, $this->testTags);

        $result = CacheService::instance()->get($this->testKeyString, $this->testTags);
        $this->assertFalse($result == $this->testValueString);
    }
}