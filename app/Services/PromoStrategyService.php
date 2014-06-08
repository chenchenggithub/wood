<?php
/**
 * Created by PhpStorm.
 * User: admin-chen
 * Date: 14-5-22
 * Time: 下午2:57
 */

class PromoStrategyService extends BaseService
{
    static $self = NULL;

    static public function instance()
    {
        if (is_null(self::$self)) {
            self::$self = new self();
        }
        return self::$self;
    }

    /**
     * 创建优惠策略
     * @param       $user_id
     * @param array $data
     * @return bool|int
     */
    public function createPromoStrategy($user_id, array $data)
    {
        //优惠码使用条件组装
        $promo_condition = $this->createUseConditionConf($data);
        //优惠模式组装
        $promo_patt = $this->createPattConf($data);

        $now_time                         = time();
        $insertData['create_user_id']     = $user_id;
        $insertData['name']               = $data['promo_name'];
        $insertData['remark']             = $data['promo_remark'];
        $insertData['use_condition_conf'] = json_encode($promo_condition);
        $insertData['patt_conf']          = json_encode($promo_patt);
        $insertData['create_time']        = $now_time;
        $insertData['update_time']        = $now_time;
        $promo_strategy_model             = new Admin_PromoStrategyModel();
        if (!$strategy_id = $promo_strategy_model->insertPromoStrategy($insertData))
            return false;
        return $strategy_id;
    }

    /**
     * 修改优惠策略
     * @param       $user_id
     * @param array $data
     * @return bool|int
     */
    public function updatePromoStrategy($user_id, array $data)
    {
        //优惠码使用条件组装
        $promo_condition = $this->createUseConditionConf($data);
        //优惠模式组装
        $promo_patt = $this->createPattConf($data);

        $strategy_id                      = $data['strategy_id'];
        $now_time                         = time();
        $updateData['create_user_id']     = $user_id;
        $updateData['name']               = $data['promo_name'];
        $updateData['remark']             = $data['promo_remark'];
        $updateData['use_condition_conf'] = json_encode($promo_condition);
        $updateData['patt_conf']          = json_encode($promo_patt);
        $updateData['update_time']        = $now_time;
        $promo_strategy_model             = new Admin_PromoStrategyModel();
        if (-1 == $promo_strategy_model->updatePromoStrategy($strategy_id, $updateData))
            return false;
        return true;
    }

    /**
     * 优惠码使用条件组装
     */
    private function createUseConditionConf(array $data)
    {
        $promo_condition = new stdClass();
        foreach (PromoStrategyEnum::$promo_use_condition as $v) {
            if ($v == PromoStrategyEnum::TIME_LIMIT) {
                $promo_condition->{$v} = implode(',', $data[$v]);
            } else {
                $promo_condition->{$v} = $data[$v];
            }
        }
        return $promo_condition;
    }

    /**
     * 优惠模式组装
     */
    private function createPattConf(array $data)
    {
        $promo_patt = new stdClass();
        foreach (PromoStrategyEnum::$promo_patt as $v) {
            $promo_patt->{$v} = $data[$v];
        }
        return $promo_patt;
    }

    /**
     * 获取要修改策略的数据
     */
    public function getUpdatePromoStrategy($strategy_id)
    {
        $promo_strategy_model = new Admin_PromoStrategyModel();
        $strategy_info        = $promo_strategy_model->getInfoByStrategyId($strategy_id);
        //格式化所需的数据
        $returnData                     = new stdClass();
        $condition_conf                 = json_decode($strategy_info->use_condition_conf);
        $patt_conf                      = json_decode($strategy_info->patt_conf);
        $limit_time                     = explode(',', $condition_conf->{PromoStrategyEnum::TIME_LIMIT});
        $returnData->strategy_id        = $strategy_info->strategy_id;
        $returnData->name               = $strategy_info->name;
        $returnData->remark             = $strategy_info->remark;
        $returnData->start_time         = $limit_time[0];
        $returnData->end_time           = $limit_time[1];
        $returnData->consumption_amount = $condition_conf->{PromoStrategyEnum::CONSUMPTION_AMOUNT};
        $returnData->use_count          = $condition_conf->{PromoStrategyEnum::USE_COUNT};
        $returnData->discount           = $patt_conf->{PromoStrategyEnum::DISCOUNT};
        $returnData->promo_amount       = $patt_conf->{PromoStrategyEnum::PROMO_AMOUNT};
        return $returnData;
    }

    /**
     * 解析使用优惠码
     * @param $account_id
     * @param $code
     * @param $amount 优惠前的总金额
     * @internal param $code_id
     * @return array
     */
    public function analyzePromoCode($account_id, $code, $amount)
    {
        //根据优惠码获取优惠策略id(优惠码是唯一的)
        $promo_code_model = new Admin_PromoCodeModel();
        $code_info = $promo_code_model->getCodeInfoByPromoCode($code);
        $error_message = ProfessionErrorCodeEnum::getErrorMessage();
        if(empty($code_info)) return array('error_code'=>ProfessionErrorCodeEnum::ERROR_PROMO_CHECK_NO_EXISTS,'error_msg'=>$error_message[ProfessionErrorCodeEnum::ERROR_PROMO_CHECK_NO_EXISTS]);
        $strategy_id         = $code_info->strategy_id;
        $code_id = $code_info->code_id;

        $promo_strategy_model = new Admin_PromoStrategyModel();
        $promo_strategy_model->setSelect(array('use_condition_conf', 'patt_conf'));
        $strategy_info      = $promo_strategy_model->fetchRow($strategy_id);
        $use_condition_conf = json_decode($strategy_info->use_condition_conf);
        $patt_conf          = json_decode($strategy_info->patt_conf);

        //验证使用条件
        foreach ($use_condition_conf as $k => $v) {
            //检查方法是否在类中存在
            //if(!method_exists(new self(),PromoStrategyEnum::$check_method[$k])) continue;
            if (!empty($v)) {
                $return_data = CheckPromoStrategyService::{
                    PromoStrategyEnum::$check_method[$k]}($code_id,$account_id,$amount,$v);
                if ($return_data['error_code'] !== ProfessionErrorCodeEnum::PROMO_STRATEGY_SUCCESS)
                    return $return_data;
            }
        }

        //更新优惠码使用的次数
        $promo_code_model = new Admin_PromoCodeModel();
        $promo_code_model->updatePromoCodeUsedCount($code_id);

        //使用优惠模式
        foreach ($patt_conf as $k => $v) {
            if (!empty($v)) {
                if (PromoStrategyEnum::DISCOUNT == $k) {
                    $return_amount = $amount * $v;
                    $promo_strategy = PromoStrategyEnum::DISCOUNT;
                    $promo_value = $v;
                    break;
                }
                if (PromoStrategyEnum::PROMO_AMOUNT == $k) {
                    $return_amount = $amount - $v;
                    $promo_strategy = PromoStrategyEnum::PROMO_AMOUNT;
                    $promo_value = $v;
                    break;
                }
            }
        }
        return array(
            'error_code'    => ProfessionErrorCodeEnum::PROMO_STRATEGY_SUCCESS,
            'return_amount' => $return_amount ,//使用优惠码后的金额
            'promo_strategy' =>$promo_strategy,
            'promo_value' =>$promo_value
        );
    }

    /**
     * 获取优惠策略列表
     */
    public function getPormoStrategyList()
    {
        $strategy_info = DB::table('promo_strategy')->paginate(AjaxPageEnum::PROMO_STRATEGY_PAGE_NUM);
        $strategy_info->{AjaxPageEnum::AJAX_PAGE_FUNC} = 'admin_promo.strategy_list_page';//指定js的ajax分页函数名
        foreach ($strategy_info as $v) {
            $v->use_condition = $this->formatPromoCondition($v->use_condition_conf);
            $v->promo_patt    = $this->formatPromoPatt($v->patt_conf);
            $v->create_time   = FormatTimeSpall::YmdHi($v->create_time);
        }
        return $strategy_info;
    }

    /**
     * 格式化使用条件
     */
    private function formatPromoCondition($condition)
    {
        $returnStr      = '';
        $condition_conf = json_decode($condition);
        foreach ($condition_conf as $k => $v) {
            if (!empty($v)) {
                //时间条件
                if (PromoStrategyEnum::TIME_LIMIT == $k) {
                    $time_limit = explode(',', $v);
                    $returnStr .= '使用期限:' . $time_limit[0] . '到' . $time_limit[1] . '<br />';
                }
                //使用次数条件
                if (PromoStrategyEnum::USE_COUNT == $k) {
                    $returnStr .= '次数限制:' . $v . '<br />';
                }
                //消费金额条件
                if (PromoStrategyEnum::CONSUMPTION_AMOUNT == $k) {
                    $returnStr .= '消费达到金额:' . $v . '<br />';
                }
            }
        }
        return $returnStr;
    }

    /**
     * 格式化优惠模式
     */
    private function formatPromoPatt($patt)
    {
        $returnStr = '';
        $patt_conf = json_decode($patt);
        foreach ($patt_conf as $k => $v) {
            if (!empty($v)) {
                //折扣优惠模式
                if (PromoStrategyEnum::DISCOUNT == $k) {
                    $returnStr .= ($v * 10) . '折<br />';
                }
                //优惠金额模式
                if (PromoStrategyEnum::PROMO_AMOUNT == $k) {
                    $returnStr .= '优惠金额：' . $v . '<br />';
                }
            }
        }
        return $returnStr;
    }

    /**
     * 获取优惠码列表
     */
    public function getPromoCodeList()
    {//promo_code_list_page
        $promo_code_model = new Admin_PromoCodeModel();
        $promo_code_list  = $promo_code_model->getPromoCodeList(AjaxPageEnum::PROMO_STRATEGY_PAGE_NUM);
        $promo_code_list->{AjaxPageEnum::AJAX_PAGE_FUNC} = 'admin_promo.promo_code_list_page';//指定js的ajax分页函数名
        foreach ($promo_code_list as $v) {
            $v->create_time = FormatTimeSpall::YmdHi($v->create_time);
        }
        return $promo_code_list;
    }


    /**
     *  依据策略创建优惠码
     */
    public function createPromoCode($strategy_id, $user_id)
    {
        $insertData['strategy_id']    = $strategy_id;
        $insertData['create_user_id'] = $user_id;
        $insertData['code']           = $this->createCodeMethod();
        $insertData['create_time']    = time();
        $promo_code_model             = new Admin_PromoCodeModel();
        if (!$code_id = $promo_code_model->insertPromoCode($insertData))
            return false;
        $rela_strategy_code_model  = new RelationshipStrategyCodeModel();
        $insertRela['code_id']     = $code_id;
        $insertRela['strategy_id'] = $strategy_id;
        if (!$rela_strategy_code_model->insertInfo($insertRela))
            return false;
        $promo_strategy_model = new Admin_PromoStrategyModel();
        if (-1 == $promo_strategy_model->updatePromoStrategyCodeCount($strategy_id))
            return false;
        return $code_id;
    }

    /**
     * 生成优惠码的算法
     */
    public function createCodeMethod()
    {
        //临时算法
        $promo_code_model = new Admin_PromoCodeModel();
        while(true){
            $code = mt_rand(100000, 999999);
            $result = $promo_code_model->getCodeInfoByPromoCode($code);
            if(isset($result)) continue;
            return $code;
        }
    }

    /**
     * 增加优惠码被使用的次数
     * @param $code
     * @return bool|int
     */
    public function addPromoCodeUsedCount($code){
        $promo_code_model = new Admin_PromoCodeModel();
        $code_info = $promo_code_model->getCodeInfoByPromoCode($code);
        if(empty($code_info)) return 0;
        if(-1 == $promo_code_model->updatePromoCodeUsedCount($code_info->code_id)) return false;
        return $code_info->code_id;
    }
}