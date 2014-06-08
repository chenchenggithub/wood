<?php
/**
 * Created by PhpStorm.
 * User: admin-chen
 * Date: 14-5-22
 * Time: 下午3:13
 */

class Admin_PromoStrategyModel extends BaseModel{
    protected $table = 'promo_strategy';
    protected $primaryKey = 'strategy_id';
    /**
     * 创建一条优惠策略
     */
    public function insertPromoStrategy($data){
       return  $this->insert($data);
    }

    /**
     * 更新一条优惠策略
     */
    public function updatePromoStrategy($strategy_id,array $data){
        return  $this->update($data,$strategy_id);
    }

    /**
     * 更新优惠策略生成的优惠码数量
     */
    public function updatePromoStrategyCodeCount($strategy_id){
      return  DB::update('update '.$this->table.' set create_code_count = create_code_count + 1 where strategy_id = ?', array($strategy_id));
    }

    /**
     * 依据strategy_id获取一条优惠策略数据
     */
    public function getInfoByStrategyId($strategy_id){
        return $this->fetchRow($strategy_id);
    }
}