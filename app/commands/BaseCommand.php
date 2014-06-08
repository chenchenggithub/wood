<?php
/**
 * @author ciogao@gmail.com
 * Date: 14-5-8 下午1:34
 */
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class BaseCommand extends Command
{
    /**
     * @var array
     */
    protected $aParams = array();

    protected $oService = NULL;

    public function __construct()
    {
        parent::__construct();
    }

    protected function getAllparams()
    {
        $this->aParams = $this->argument();
    }


    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return array(
//            array('id', InputArgument::REQUIRED, '0'),
//            array('type', InputArgument::REQUIRED, '1'),
        );
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return array(
            array('example', NULL, InputOption::VALUE_OPTIONAL, 'An example option.', NULL),
        );
    }
}