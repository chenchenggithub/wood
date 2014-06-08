<?php
/**
 *
 * Class MQEmailCommand
 */
class MQEmailCommand extends BaseCommand
{
    /**
     * @var string
     */
    protected $name = 'command:MQEmail';

    /**
     * @var string
     */
    protected $description = '每两分钟运行一次，处理队列中待发送的邮件';

    private $oMailService = NULL;

    public function __construct()
    {
        parent::__construct();
        $this->oMailService = MailService::instance();
    }


    /**
     * Execute the console command.
     * @todo 运行时log
     * @return mixed
     */
    public function fire()
    {
        parent::getAllparams();

        $result = $this->oMailService->processMailWithMQ();

        if ($result) {
            echo "处理完毕\n";
        } else {
            echo "产生错误，请查看日志\n";
        }
    }

}
