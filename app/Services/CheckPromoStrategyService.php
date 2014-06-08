<?php
/**
 * Created by PhpStorm.
 * User: admin-chen
 * Date: 14-5-22
 * Time: 下午5:33
 */

class CheckPromoStrategyService extends BaseService{
    static  $self = NULL;
    static public function instance(){
        if(is_null(self::$self)){
            self::$self = new self();
        }
        return self::$self;
    }

    /**
     * 优惠码允许使用的时间范围
     * @param $code_id
     * @param $account_id
     * @param $amount
     * @param $data
     * @return array
     */
    static public function checkTimeLimit($code_id,$account_id,$amount,$data){
        $error_info = ProfessionErrorCodeEnum::getErrorMessage();
        $time = explode(',',$data);
        if(empty($time[0]) || empty($time[1])) return array('error_code'=>ProfessionErrorCodeEnum::PROMO_STRATEGY_SUCCESS);
        $start_time = strtotime($time[0]);//var_dump($start_time);exit;
        $end_time = strtotime($time[1]);
        $now_time = time();

        if($now_time < $start_time || $now_time > $end_time) return array(
            'error_code' => ProfessionErrorCodeEnum::ERROR_PROMO_CHECK_TIME,
            'error_msg' => $error_info[ProfessionErrorCodeEnum::ERROR_PROMO_CHECK_TIME]
        );
        return array('error_code'=>ProfessionErrorCodeEnum::PROMO_STRATEGY_SUCCESS);
    }

    /**
     * 优惠码允许使用的次数
     * @param $code_id
     * @param $account_id
     * @param $amount
     * @param $data
     * @return array
     */
    static public function checkUseCount($code_id,$account_id,$amount,$data){
        $error_info = ProfessionErrorCodeEnum::getErrorMessage();
        //获取该优惠码被使用的次数
        $promo_code_model = new Admin_PromoCodeModel();
        $code_info = $promo_code_model->getCodeInfoByCodeId($code_id);
        $used_count = $code_info->used_count;
        if($used_count >= $data) return array(
            'error_code' => ProfessionErrorCodeEnum::ERROR_PROMO_CHECK_USE_COUNT,
            'error_msg' => $error_info[ProfessionErrorCodeEnum::ERROR_PROMO_CHECK_USE_COUNT]
        );
        return array('error_code'=>ProfessionErrorCodeEnum::PROMO_STRATEGY_SUCCESS);
    }

    /**
     * 消费金额要达到策略标准
     * @param $code_id
     * @param $account_id
     * @param $amount
     * @param $data
     * @return array
     */
    static public function checkConsumptionAmount($code_id,$account_id,$amount,$data){
        $error_info = ProfessionErrorCodeEnum::getErrorMessage();
        if($amount < $data) return array(
            'error_code' => ProfessionErrorCodeEnum::ERROR_PROMO_CHECK_CONSUMPTION_AMOUNT,
            'error_msg' => $error_info[ProfessionErrorCodeEnum::ERROR_PROMO_CHECK_CONSUMPTION_AMOUNT]
        );
        return array('error_code'=>ProfessionErrorCodeEnum::PROMO_STRATEGY_SUCCESS);
    }

}