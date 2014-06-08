<?php
/**
 * Created by PhpStorm.
 * User: admin-chen
 * Date: 14-5-23
 * Time: 上午9:50
 */

class Admin_PromoCodeModel extends BaseModel{
    protected $table = 'promo_code';
    protected $primaryKey = 'code_id';

    /**
     * 新建优惠码信息
     */
    public function insertPromoCode($data){
        return $this->insert($data);
    }

    /**
     * 获取优惠码列表
     */
    public function getPromoCodeList($limit){
        return DB::table($this->table)
            ->select('promo_code.strategy_id', 'promo_strategy.name','promo_code.code','promo_code.used_count','promo_code.create_time','admin_info.admin_email')
            ->leftJoin('promo_strategy', 'promo_code.strategy_id', '=', 'promo_strategy.strategy_id')
            ->leftJoin('admin_info', 'promo_code.create_user_id', '=', 'admin_info.admin_id')
            ->orderBy('promo_code.create_time', 'desc')
            ->paginate($limit);
    }

    /**
     * 获取优惠码的相关信息
     */
    public function getCodeInfoByCodeId($code_id){
        return $this->fetchRow($code_id);
    }

    /**
     * 更新优惠码使用的次数
     */
    public function updatePromoCodeUsedCount($code_id){
        return  DB::update('update '.$this->table.' set used_count = used_count + 1 where code_id = ?', array($code_id));
    }

    /**
     * 获取优惠码的code_id
     * @param $code
     * @return array
     */
    public function getCodeInfoByPromoCode($code){
        return DB::table($this->table)->where('code',$code)->first();
    }
} 