<?php
/**
 * Created by PhpStorm.
 * User: dengchao
 * Date: 14-5-19
 * Time: 下午3:36
 */
class User_CompanyInfoModel extends BaseModel
{
    protected $table = 'company_info';
    protected $primaryKey = 'account_id';

    public function mkCompanyParamsForInsert(VO_Request_DimCompany $request)
    {
        return array(
            'account_id'       => $request->account_id,
            'company_name'     => $request->company_name,
            'company_address'  => $request->company_address,
            'company_url'      => $request->company_url,
            'company_fax'      => $request->company_fax,
            'company_logo'     => $request->company_logo,
            'company_industry' => $request->company_industry,
            'company_tel'      => $request->company_tel,
        );
    }
}