<?php
/**
 * @author Neeke.Gao
 * Date: 14-5-22 下午6:02
 */
class ProjectPageTest extends TestCase
{
    protected $app_config = 'local';

    /**
     *
     */
    public function PageCreate()
    {
        $data = array(
            'page_url'   => 'http://www.baidu.com',
            'account_id' => 1,
            'app_id'     => 1,
            'domain_id'  => 1,
        );


        PageService::instance()->setRequestPageParams($data);
        $result = PageService::instance()->pageCreate();

        $this->assertTrue($result > 0);
    }

    public function testPageUpdate()
    {
        $data = array(
            'page_id'   => 1,
            'domain_id' => 2,
            'page_url'  => 'http://www.update.com',
        );

        try {
            PageService::instance()->setRequestPageParams($data);
            $result = PageService::instance()->pageUpdate();

            $this->assertTrue($result > 0);
        } catch (Exception $e) {
            $this->assertTrue($e->getCode() == ErrorCodeEnum::STATUS_SUCCESS_DO_ERROR_DB_NULL);
        }
    }

    public function testPageUpdateStatus()
    {
        $data = array(
            'page_id'   => 1,
            'domain_id' => 2,
            'page_url'  => 'http://www.update.com',
            'status'    => ProjectEnum::PAGE_STATUS_NORMAL,
        );

        try {
            PageService::instance()->setRequestPageParams($data);
            $result = PageService::instance()->pageStatusUpdate();

            $this->assertTrue($result >= 0);
        } catch (Exception $e) {
            $accessCodes = array(
                ErrorCodeEnum::STATUS_ERROR_PARAMS_MUST        => ErrorCodeEnum::STATUS_ERROR_PARAMS_MUST,
                ErrorCodeEnum::STATUS_SUCCESS_DO_ERROR_DB_NULL => ErrorCodeEnum::STATUS_SUCCESS_DO_ERROR_DB_NULL,
            );

            $this->assertArrayHasKey($e->getCode(), $accessCodes);
        }
    }

    public function testPageList()
    {
        $data = array(
            'domain_id' => 1,
        );

        PageService::instance()->setRequestPageParams($data);
        $result = PageService::instance()->pageList();

        $this->assertTrue(is_array($result));
        if (count($result) > 0) {
            $this->assertTrue(is_object($result[0]));
        }

    }

    /**
     * @test
     */
    public function ServicePageInsert()
    {
        $data = array(
            'app_id'       => 1,
            'account_id'   => 1,
            'service_type' => ServiceTypeEnum::TYPE_HTTP,
            'domain_id'    => 3,
            'status'       => ServiceTypeEnum::TYPE_STATUS_NORMAL,
            'target_id'    => 1,
            'target_type'  => 2,
            'monitor_list' => array(1, 3, 4),
            'frequency'    => 5,
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
}