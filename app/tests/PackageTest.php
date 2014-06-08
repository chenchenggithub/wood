<?php
/**
 * Created by PhpStorm.
 * User: admin-chen
 * Date: 14-5-16
 * Time: 上午10:23
 */
class PackageTest extends TestCase{
    protected $app_config = 'local';

    /**
     * 套餐相关的测试入口
     */
    public function testInstance(){
       // $this->getPackageMonitor();//获取套餐中的监测点
        $this->insertTryPackage();
    }

    /**
     * 获取套餐中的监测点
     */
    private function getPackageMonitor(){
        $account_id = 1;
        $monitor = PackageInstanceService::instance()->getPackageMonitor($account_id);
        if(!$monitor) $this->assertTrue(false);
        $this->assertTrue(true);
    }
    /**
     * 导入试用套餐
     */
    private function insertTryPackage(){
        $account_id = 1;
        $result = PackageInstanceService::instance()->insertTryPackage($account_id);
        if(!$result) $this->assertTrue(false);
        $this->assertTrue(true);
    }
}