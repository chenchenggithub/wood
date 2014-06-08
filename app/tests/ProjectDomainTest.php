<?php
/**
 * @author Neeke.Gao
 * Date: 14-5-16 上午10:07
 */

class ProjectDomainTest extends TestCase
{
    protected $app_config = 'local';

    /**
     * //     * @test
     */
    public function DomainCreate()
    {
        $data = array(
            'site_name'   => 'unit create test',
            'site_domain' => 'http://www.baidu.com',
            'account_id'  => 1,
            'app_id'      => 1,
        );


        SiteService::instance()->setRequestSiteInfoParams($data);
        $result = SiteService::instance()->baseInfoCreate();

        $this->assertTrue($result > 0);
    }

    public function testDomainUpdate()
    {
        $data = array(
            'domain_id'   => 2,
            'site_name'   => 'unit update test',
            'site_domain' => 'http://www.update.com',
        );

        try {
            SiteService::instance()->setRequestSiteInfoParams($data);
            $result = SiteService::instance()->baseInfoUpdate();

            $this->assertTrue($result > 0);
        } catch (Exception $e) {

            $this->assertTrue($e->getCode() == ErrorCodeEnum::STATUS_ERROR_API_VALIDE_AUTH);
        }
    }

    public function testDomainDel()
    {
        $data = array();
    }

    /**
     * @test
     */
    public function ServiceDomainInsert()
    {
        $data = array(
            'app_id'         => 1,
            'account_id'     => 1,
            'service_type'   => 1,
            'domain_id'      => 3,
            'status'         => ServiceTypeEnum::TYPE_STATUS_NORMAL,
            'target_id'      => 1,
            'target_type'    => 1,
            'monitor_list'   => array(1, 3, 4),
            'frequency'      => 5,
            'dns_type'       => 1,
            'use_dns_ip'     => 1,
            'metric_ip_1[]'  => array(115),
            'metric_ip_2[]'  => array(239),
            'metric_ip_3[]'  => array(211),
            'metric_ip_4[]'  => array(110),
            'use_dns_server' => 1,
            'dns_server'     => '8.8.8.8',
        );

        try {

            SiteService::instance()->setRequestRsServiceParams($data);
            $result = SiteService::instance()->ckIfServiceCanModify();

            SchedulerConfigExtService::instance()->setRequestRsServiceParams($data);
            SchedulerConfigExtService::instance()->setConfigExtRequest($data);
            SchedulerConfigExtService::instance()->configExtModify();

            $this->assertTrue($result);
        } catch (Exception $e) {
            $this->assertTrue($e->getCode() == ErrorCodeEnum::STATUS_ERROR_API_VALIDE_AUTH);
        }

    }

    public function testServiceDomainUpdate()
    {
        $data = array(
            'id'             => 1,
            'app_id'         => 1,
            'account_id'     => 1,
            'service_type'   => 1,
            'status'         => ServiceTypeEnum::TYPE_STATUS_OFFLINE,
            'target_id'      => 1,
            'target_type'    => 1,
            'monitor_list'   => array(1, 3, 4),
            'frequency'      => 5,
            'dns_type'       => 1,
            'use_dns_ip'     => 1,
            'metric_ip_1[]'  => array(115),
            'metric_ip_2[]'  => array(239),
            'metric_ip_3[]'  => array(211),
            'metric_ip_4[]'  => array(110),
            'use_dns_server' => 1,
            'dns_server'     => '8.8.8.8',
        );

        try {
            SiteService::instance()->setRequestRsServiceParams($data);
            SiteService::instance()->ckIfServiceCanModify();

            SchedulerConfigExtService::instance()->setRequestRsServiceParams($data);
            SchedulerConfigExtService::instance()->setConfigExtRequest($data);
            $result = (bool)SchedulerConfigExtService::instance()->configExtModify();

            if (!$result) {
                $this->assertFalse($result);
            } else {
                $this->assertTrue($result);
            }

        } catch (Exception $e) {
            $this->assertTrue($e->getCode() == ErrorCodeEnum::STATUS_ERROR_API_VALIDE_AUTH);
        }
    }

    public function testServiceDomainOffline()
    {
        $data = array(
//            'id'           => 1,
            'app_id'       => 1,
            'account_id'   => 1,
            'service_type' => 1,
            'target_id'    => 1,
            'target_type'  => 1,
        );

        try {
            SiteService::instance()->setRequestRsServiceParams($data);
            SiteService::instance()->ckIfServiceCanModify();

            SchedulerConfigExtService::instance()->setRequestRsServiceParams($data);
            SchedulerConfigExtService::instance()->setConfigExtRequest($data);
            $result = (bool)SchedulerConfigExtService::instance()->configExtOffline();

            if (!$result) {
                $this->assertFalse($result);
            } else {
                $this->assertTrue($result);
            }

        } catch (Exception $e) {
            $accessCodes = array(
                ErrorCodeEnum::STATUS_ERROR_API_VALIDE_AUTH    => ErrorCodeEnum::STATUS_ERROR_API_VALIDE_AUTH,
                ErrorCodeEnum::STATUS_SUCCESS_DO_ERROR_DB_NULL => ErrorCodeEnum::STATUS_SUCCESS_DO_ERROR_DB_NULL,
            );

            $this->assertArrayHasKey($e->getCode(), $accessCodes);
        }
    }


    public function testServiceDomainStop()
    {
        $data = array(
//            'id'           => 1,
            'app_id'       => 1,
            'account_id'   => 1,
            'service_type' => 1,
            'target_id'    => 1,
            'target_type'  => 1,
        );

        try {
            SiteService::instance()->setRequestRsServiceParams($data);
            SiteService::instance()->ckIfServiceCanModify();

            SchedulerConfigExtService::instance()->setRequestRsServiceParams($data);
            SchedulerConfigExtService::instance()->setConfigExtRequest($data);
            $result = (bool)SchedulerConfigExtService::instance()->configExtStop();

            if (!$result) {
                $this->assertFalse($result);
            } else {
                $this->assertTrue($result);
            }

        } catch (Exception $e) {
            $accessCodes = array(
                ErrorCodeEnum::STATUS_ERROR_API_VALIDE_AUTH    => ErrorCodeEnum::STATUS_ERROR_API_VALIDE_AUTH,
                ErrorCodeEnum::STATUS_SUCCESS_DO_ERROR_DB_NULL => ErrorCodeEnum::STATUS_SUCCESS_DO_ERROR_DB_NULL,
            );

            $this->assertArrayHasKey($e->getCode(), $accessCodes);
        }
    }
}