<?php
/**
 * Created by PhpStorm.
 * User: admin-chen
 * Date: 14-6-4
 * Time: 下午5:33
 */

class SiteDashboardTest extends TestCase{
    protected $app_config = 'local';
    public function testInterface(){
        $this->abc();
    }
    private function abc(){
        ES_SiteDashboardService::instance()->testEs();
    }
} 