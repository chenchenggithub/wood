<?php
/**
 * @author ciogao@gmail.com
 * Date: 14-6-2 下午10:10
 */
class Project_PageController extends BaseController
{
    public function PageCreateApi()
    {
        $this->params['account_id'] = UserService::getUserCache()->account_id;
        PageService::instance()->setRequestPageParams($this->params);

        $result = PageService::instance()->pageCreate();
        $this->rest->success($result);
    }

    public function PageModifyApi()
    {
        PageService::instance()->setRequestPageParams($this->params);

        $result = PageService::instance()->pageCreate();
        $this->rest->success($result);
    }

    public function PageStatusModifyApi()
    {
        PageService::instance()->setRequestPageParams($this->params);

        $result = PageService::instance()->pageStatusUpdate();
        $this->rest->success($result);
    }
}