<?php
use Symfony\Component\Console\Tests\Descriptor\ObjectsProvider;

class OrderCommodity{
	/**
	 * 一次性创建多条新的数据
	 * @param array $data
	 * @return bool TRUE or FALSE
	 */
	public function InsertOrderCommodity(array $data){
		return DB::table('order_commodity')->insert($data);
	}
	
	/**
	 * 根据订单id获取订单项目
	 * @param int $order_id
	 * @return Object $commodity
	 */
	public function GetCommodityByOrderId($order_id){
		$commodity = DB::table('order_commodity')
					->where('order_history_id',$order_id)
					->select('package_conf_id','value','monitor_value')
					->get();
		if($commodity) return $commodity;
		return FALSE;
	}

    /**
     * 获取订单中的某个项目的值
     * @param int $order_id
     * @param     $package_conf_id
     * @return Object $commodity
     */
	public function GetOneCommodity($order_id,$package_conf_id){
		$commodity = DB::table('order_commodity')
		->where('order_history_id',$order_id)
		->where('package_conf_id',$package_conf_id)
		->select('value')
		->first();
		if($commodity) return $commodity;
		return FALSE;
	}
	
}