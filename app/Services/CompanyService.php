<?php
/**
 * Created by PhpStorm.
 * User: dengchao
 * Date: 14-5-19
 * Time: 下午3:33
 */
class CompanyService extends BaseService
{
    private static $self = NULL;
    static public function instance()
    {
        if (self::$self == NULL) {
            self::$self = new self;
        }

        return self::$self;
    }

    /**
     * @var User_CompanyInfoModel
     */
    private $mCompanyInfoModel = null;

    public function __construct()
    {
        $this->mCompanyInfoModel = new User_CompanyInfoModel();
    }

    /**
     * @var VO_Request_DimCompany
     */
    private $oCompanyInfo = null;

    public function setCompanyParamsForRequest(array $params)
    {
        $this->oCompanyInfo = VO_Bound::Bound($params, new VO_Request_DimCompany());
        return $this->oCompanyInfo;
    }

    public function createCompany()
    {
        $aData = $this->mCompanyInfoModel->mkCompanyParamsForInsert($this->oCompanyInfo);
        if(-1 != $this->mCompanyInfoModel->insert($aData))
            return true;
        return false;
    }
}