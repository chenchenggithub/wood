<?php
/**
 * @author ciogao@gmail.com
 * Date: 14-5-8 下午2:01
 */
class Package_PackageInstanceModel extends BaseModel
{
    protected $table = 'package_instance';
    protected $primaryKey = 'package_instance_id';
    
    /**
     * 创建一个套餐
     * @param array $data
     * @return int $package_instance_id or FALSE
     */
    public function InsertPackageInstance(array $data){
    	$package_instance_id = DB::table($this->table)->insertGetId(
    		array(
    				'account_id' => $data['account_id'], 
    				'price' => $data['price'],
    				'expired_date' => $data['expired_date'],
    				'create_time' => $data['create_time'])
    	);
    	if(!$package_instance_id) return FALSE;
    	return $package_instance_id;
    }
    
    /**
     * 根据account_id获取套餐
     * @param $account_id
     * @return 
     */
    public function GetPacakageInstance($account_id){
    	return DB::table($this->table)->where('account_id',$account_id)
    								  ->first();
    }
    
    /**
     * 更新套餐内的数据
     * @param $account_id
     * @param $data
     * @return
     */
    public function UpdatePackageInstance($account_id,$data){
    	return DB::table($this->table)->where('account_id',$account_id)
    	->update($data);
    }
    
}