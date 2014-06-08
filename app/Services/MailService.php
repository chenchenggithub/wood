<?php
/**
 * demo:
 * MailService::instance()->sendByMQ(
 * 'emails.welcome',
 * array('data' => array(1,2,3,'111111')),
 * 'neeke.gao@yunzhihui.com',
 * 'Neeke.Gao',
 * 'Welcome!')
 *
 *
 * @author Neeke.Gao
 * Date: 14-5-22 上午11:13
 */
class MailService extends BaseService
{
    /**
     * @var MailService
     */
    private static $self = NULL;

    /**
     * @static
     * @return MailService
     */
    public static function instance()
    {
        if (self::$self == NULL) {
            self::$self = new self;
        }
        return self::$self;
    }

    /**
     * @var MQRedisService
     */
    private $oMQService = NULL;

    public function __construct()
    {

    }

    private function processMQService()
    {
        $this->oMQService = MQRedisService::instance();
        $this->oMQService->setQName('sendEmail');
    }

    /**
     * 直接发送
     * @param $sView
     * @param $aDataForView
     * @param $callback
     * @return mixed
     */
    public function send($sView, $aDataForView, $callback)
    {
        return Mail::send($sView, $aDataForView, $callback);
    }

    /**
     * 塞入队列
     * @param $sView
     * @param $aDataForView
     * @param $sMailToEmail
     * @param $sMailToName
     * @param $sSubject
     * @return mixed
     */
    public function sendByMQ($sView, $aDataForView, $sMailToEmail, $sMailToName, $sSubject)
    {
        self::processMQService();

        $rawParams = array(
            'sView'        => $sView,
            'aDataForView' => $aDataForView,
            'sMailToEmail' => $sMailToEmail,
            'sMailToName'  => $sMailToName,
            'sSubject'     => $sSubject,
        );

        $request = VO_Bound::Bound($rawParams, NEW VO_Request_SendEmail());

        return $this->oMQService->push(serialize($request));
    }

    /**
     * 运用队列发送
     * @return mixed
     *
     * @todo log it
     */
    public function processMailWithMQ()
    {
        self::processMQService();

        while (TRUE) {
            $result = self::_getMailPop();

            if (!$result) die;

            self::send($result->sView, $result->aDataForView, function ($m) use ($result) {
                $m->to($result->sMailToEmail, $result->sMailToName)->subject($result->sSubject);
            });
        }

        return TRUE;
    }

    /**
     * @return VO_Request_SendEmail
     */
    private function _getMailPop()
    {
        $result = $this->oMQService->pop();
        if (!$result) return FALSE;

        return unserialize($result);
    }
}