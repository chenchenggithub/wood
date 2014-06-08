<?php
/**
 * Created by PhpStorm.
 * User: admin-chen
 * Date: 14-5-22
 * Time: 上午11:52
 */

class Filters_PromoStrategyFilter extends Filters_BaseFilter
{
    /**
     * 验证创建优惠策略提交的数据
     */
    public function filter()
    {

        $error_info = ProfessionErrorCodeEnum::getErrorMessage();

        //使用条件不能为空
        if (empty($this->params[PromoStrategyEnum::TIME_LIMIT]) && empty($this->params[PromoStrategyEnum::USE_COUNT]) && empty($this->params[PromoStrategyEnum::CONSUMPTION_AMOUNT])) {
            RESTService::instance()->error($error_info[ProfessionErrorCodeEnum::ERROR_PROMO_CONDITION], ProfessionErrorCodeEnum::ERROR_PROMO_CONDITION);
        }

        //优惠模式不能为空
        if (empty($this->params[PromoStrategyEnum::DISCOUNT]) && empty($this->params[PromoStrategyEnum::PROMO_AMOUNT])) {
            RESTService::instance()->error($error_info[ProfessionErrorCodeEnum::ERROR_PROMO_PATT], ProfessionErrorCodeEnum::ERROR_PROMO_PATT);
        }

        //折扣不能大于1
        if ($this->params[PromoStrategyEnum::DISCOUNT] >= 1) {
            RESTService::instance()->error($error_info[ProfessionErrorCodeEnum::ERROR_PROMO_DISCOUNT], ProfessionErrorCodeEnum::ERROR_PROMO_DISCOUNT);
        }
    }
} 