<?php
/**
 *
 * Class UserCommand
 */
class UserCommand extends BaseCommand
{
    /**
     * @var string
     */
    protected $name = 'command:accountOffLine';

    /**
     * @var string
     */
    protected $description = '每天运行一次，将套餐过期的用户处理为过期';

    private $oUserService = NULL;
    private $oPackageInstanceService = NULL;

    /**
     *
     * @return \UserCommand
     */
    public function __construct()
    {
        parent::__construct();
        $this->oUserService            = UserService::instance();
        $this->oPackageInstanceService = PackageInstanceService::instance();
    }


    /**
     * Execute the console command.
     * @todo 运行时log
     * @return mixed
     */
    public function fire()
    {
        parent::getAllparams();

        $account_ids = $this->oPackageInstanceService->processOfflineAccount();

        var_dump($this->oUserService->upAccountStatusByIds($account_ids, UserEnum::STATUS_OFFLINE));
        echo "处理完毕\n";
    }

}
