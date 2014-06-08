<?php
class Package_PackageInstanceItemsModel extends BaseModel
{
	protected $table = 'package_instance_items';
	protected $primaryKey = 'package_instance_items_id';

	/**
	 * 一次性创建多条新的数据
	 * @param array $data
	 * @return bool TRUE or FALSE
	 */
	public function InsertPackageInstanceItems(array $data){
		return DB::table($this->table)->insert($data);
	}
	
	/**
	 * 根据套餐id获取套餐项目
	 * @param int $package_instance_id
	 * @return array $package
	 */
	public function GetPackageItems($package_instance_id){
		$package = DB::table($this->table)
		->where('package_instance_id',$package_instance_id)
		->select('package_instance_items_id','package_conf_id','value','monitor_value')
		->get();
		if($package) return $package;
		return FALSE;
	}

    /**
     * 获取套餐中的监测点
     * @param $package_instance_id
     * @return array
     */
    public function getPackageMonitor($package_instance_id){
        $this->setSelect(array('monitor_value'));
        return  $this->fetchRow(array('package_instance_id = ?' =>$package_instance_id, 'package_conf_id = ?'=>PackageEnum::MONITOR));
    }

    /**
	 * 更新套餐项目
	 * @param $package_instance_items_id
	 * @param $data
	 * @return bool
	 */
	public function UpdatePackageItems($package_instance_items_id,$data){
		return DB::table($this->table)
				->where('package_instance_items_id',$package_instance_items_id)
				->update($data);
	}

    /**
     * 删除套餐中的所有项目
     */
    public function delPackageItems($package_instance_id){
        return DB::table($this->table)->where('package_instance_id',$package_instance_id)->delete();
    }
	
}