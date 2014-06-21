<?php

//MVC中的model，股票模型模块
class SE_6_Stock extends CI_Model {
		
  	 function __construct(){
      		 parent::__construct();			
		$this->load->database();//在模型构造函数中连接数据库
   	 }
	
	//增加股票与管理员关联记录
	function relation_insert($arr){
		$sid=$arr['id_stock'];
		$this->db->where('id_stock', $sid);    //查询条件，id_stock为字段为指定值
		$this->db->select('*');      //获取整个记录
		$query = $this->db->get('se_6_supervisedstock'); //在关联关系表中
		$result=$query->result();      //得到结果
		if(count($result)){   //已有记录
			$manager=$arr['id_supervisor'];      //更新数据库中的关联信息记录
			$arr2=array('id_supervisor'=>$manager);
			$this->db->where('id_stock', $sid);
			$this->db->update('se_6_supervisedstock', $arr2);
		}
		else   //新记录
			$this->db->insert('se_6_supervisedstock',$arr);    //增加新的记录
	}


	//暂停交易
	function pause_trade($sid){
		$this->db->where('id_stock', $sid);      //查询条件，id_stock为字段为指定值
		$arr=array('trade_state'=>0); //新的记录字段存入数组
		$this->db->update('se_6_stockstate', $arr); //更新数据库记录，暂停交易
	}

	//重启交易
	function restart_trade($sid){
		$this->db->where('id_stock', $sid);	//查询条件，id_stock为字段为指定值
		$arr=array('trade_state'=>1); //新的记录字段存入数组
		$this->db->update('se_6_stockstate', $arr);//更新数据库记录，重启交易
	}

	//设置涨跌停
	function set_limit($sid,$limit){
		$this->db->where('id_stock', $sid);//查询条件，id_stock为字段为指定值
		$arr=array('limit_tomorrow'=>$limit); //新的记录字段存入数组
		$this->db->update('se_6_stockstate', $arr);//更新数据库记录，设置涨跌停
	}

	//新股上市				
	function new_stock($arr,$aid){
		$this->db->insert('se_6_stockstate', $arr);  //将用户提供的记录插入股票表
		$arr2=array('id_stock'=>$arr['id_stock'],
			'id_supervisor'=>$aid); 
		$this->db->insert('se_6_supervisedstock', $arr2);      //将关联关系表存入管理信息
	}

	//股票是否存在
	function check_id($sid){
		$this->db->where('id_stock', $sid);//查询条件，id_stock为字段为指定值
		$this->db->select('*');
		$query = $this->db->get('se_6_stockstate'); 	//在股票表中查询
		$result=$query->result();
		if(count($result))    //返回是否存在的信息
			return 1;
		else
			return 0;
	}

	//获取股票信息
	function stock_info($sid){
		$this->db->where('id_stock', $sid);//查询条件，id_stock为字段为指定值
		$this->db->select('*');
		$query = $this->db->get('se_6_stockstate');	//在股票表中查询
		return $query->result();	//返回股票条目的所有信息
	}

	//获取股票id
	function get_stock($id){
		$this->db->where('id_supervisor', $id);//查询条件，id_supervisor为字段为指定值
		$this->db->select('id_stock');      //获取他管理的股票列表
		$query = $this->db->get('se_6_supervisedstock');   //在关联表中
		return $query->result();  //返回结果
	}

	//删除股票
	function delete_stock($id){
		$this->db->where('id_stock',$id);//查询条件，id_stock为字段为指定值
		$query=$this->db->delete($stocktable);     //删除股票记录
	}

}

?>
