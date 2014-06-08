<?php
/**
 * Created by PhpStorm.
 * User: admin-chen
 * Date: 14-5-23
 * Time: 上午10:03
 */

class RelationshipStrategyCodeModel extends BaseModel{
    protected $table = 'relationship_strategy_code';
    protected $primaryKey = 'id';

    /**
     * 插入一条维护信息
     */
    public function insertInfo($data){
        return $this->insert($data);
    }

    /**
     * 根据code_id获取数据
     */
    public function getInfoByCodeId($code_id){
        $aWhere = array('code_id'=>$code_id);
       return $this->fetchRow($aWhere);
    }
} 