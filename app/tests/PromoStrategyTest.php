<?php
/**
 * Created by PhpStorm.
 * User: admin-chen
 * Date: 14-5-22
 * Time: 下午3:58
 */

class PromoStrategyTest extends TestCase{
    /**
     * 优惠码、策略测试入口
     */
    public function testInterface(){
        //创建优惠策略
        //$this->createPromoStrategy();
        //解析优惠码
        //$this->analyzePromoCode();
        //生成一条优惠码
       // $this->createPromoCode();
    }

    /**
     * 创建优惠策略
     */
    private function createPromoStrategy(){

    }

    /**
     * 解析优惠码
     */
    private function analyzePromoCode(){
        $code_id = 10;
        $account_id = 1;
        $amount = 3000;
        $result = PromoStrategyService::instance()->analyzePromoCode($account_id,$code_id,$amount);
        var_dump($result);
    }

    /**
     * 生成优惠码
     */
    private function createPromoCode(){
        $strategy_id = 1;
        $user_id = 1;
        $result = PromoStrategyService::instance()->createPromoCode($strategy_id,$user_id);
        var_dump($result);
    }
} 