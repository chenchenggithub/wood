<?php
/**
 * Created by PhpStorm.
 * User: admin-chen
 * Date: 14-5-21
 * Time: 下午2:45
 */
class Admin_PromoCodeController extends BaseController{

    public function showPromoPage(){
        $this->viewAdmin('admin.promo_page');
    }

    /**
     * 加载优惠码列表
     */
    public function ajaxPromoCodeList(){
        $code_list =  PromoStrategyService::instance()->getPromoCodeList();
        $this->viewAjax('admin.ajaxTemplate.ajax_promo_code_list')->with('code_list',$code_list);
    }

    /**
     * 加载优惠策略列表
     */
    public function ajaxPromoStrategyList(){
        $strate_list = PromoStrategyService::instance()->getPormoStrategyList();

        $this->viewAjax('admin.ajaxTemplate.ajax_promo_strategy_list')->with('strate_list',$strate_list);
    }

    /**
     * 加载创建优惠策略
     */
    public function ajaxCreateStrategy(){
        $this->viewAjax('admin.ajaxTemplate.ajax_create_strategy');
    }

    /**
     * 加载修改优惠策略
     */
    public function ajaxUpdateStrategy(){
        $strategy_id = $this->params['strategy_id'];
        $strategy_info = PromoStrategyService::instance()->getUpdatePromoStrategy($strategy_id);
        $this->viewAjax('admin.ajaxTemplate.ajax_update_strategy')->with('strategy_info',$strategy_info);
    }
    /**
     * 新建优惠策略
     */
    public function ajaxCreatePromoStrategy(){
        $admin_info = Session::get(AdminMenuEnum::ADMIN_SESSION_KEY);
        $user_id = $admin_info->admin_id;
        if(!PromoStrategyService::instance()->createPromoStrategy($user_id,$this->params)) {
            $error_info =  ProfessionErrorCodeEnum::getErrorMessage();
            $this->rest->error($error_info[ProfessionErrorCodeEnum::ERROR_PROMO_CREATE_RESULT],ProfessionErrorCodeEnum::ERROR_PROMO_CREATE_RESULT);
        }
        $this->rest->success(array(1,2,3));
    }

    /**
     * 修改优惠策略
     */
    public function ajaxUpdatePromoStrategy(){
        $admin_info = Session::get(AdminMenuEnum::ADMIN_SESSION_KEY);
        $user_id = $admin_info->admin_id;
        if(!PromoStrategyService::instance()->updatePromoStrategy($user_id,$this->params)){
            $error_info =  ProfessionErrorCodeEnum::getErrorMessage();
            $this->rest->error($error_info[ProfessionErrorCodeEnum::ERROR_PROMO_UPDATE_RESULT_TYPE],ProfessionErrorCodeEnum::ERROR_PROMO_UPDATE_RESULT_TYPE);
        }
        $this->rest->success();
    }

    /**
     * 生成优惠码
     */
    public function ajaxCreatePromoCode(){
        $strategy_id = $this->params['strategy_id'];
        $admin_info = Session::get(AdminMenuEnum::ADMIN_SESSION_KEY);
        $user_id = $admin_info->admin_id;
        if(!PromoStrategyService::instance()->createPromoCode($strategy_id,$user_id)){
            $error_info = ProfessionErrorCodeEnum::getErrorMessage();
            $this->rest->error($error_info[ProfessionErrorCodeEnum::ERROR_PROMO_CREATE_CODE_FIAL],ProfessionErrorCodeEnum::ERROR_PROMO_CREATE_CODE_FIAL);
        }
        $this->rest->success();
    }
}