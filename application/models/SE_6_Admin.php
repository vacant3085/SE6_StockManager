<?php

//MVC中的model，管理员模型模块
class SE_6_Admin extends CI_Model {

  	 function __construct()
	{
        		parent::__construct();
		$this->load->database();//在模型构造函数中连接数据库
	}

	//获取用户对应密码
	function user_select($user) {
		$this->db->where('id_supervisor', $user); //查询条件字段为用户名
		$this->db->select('password');        //获取密码
		$query = $this->db->get('se_6_supervisor');	//在管理员表中
		return $query->result();	//返回结果
	}

	//管理员是否存在
	function check_id($id){
		$this->db->where('id_supervisor', $id);//查询条件字段为用户名
		$this->db->select('*');  
		$query = $this->db->get('se_6_supervisor');		//在管理员表中
		$result=$query->result();
		if(count($result))    //返回ID是否存在
			return 1;
		else
			return 0;
	}

	//是否超级管理员
	function is_super($id){
		$this->db->where('id_supervisor', $id);//查询条件字段为用户名
		$this->db->select('isAdmin');  //获取是否为超级管理员
		$query = $this->db->get('se_6_supervisor');		//在管理员表中
		$result=$query->result();
		$isAdmin=$result[0]->isAdmin;    //返回布尔值
		return $isAdmin;
	}

	//新管理员				
	function new_admin($arr){
		$id=$arr['id_supervisor'];     //获取ID
		$this->db->where('id_supervisor', $id);
		$this->db->select('*');
		$query = $this->db->get('se_6_supervisor');  //查询是否存在
		$result=$query->result();
		if(count($result)){   //已有记录
			return -1;
		}
		$this->db->insert('se_6_supervisor', $arr); //不存在则添加新用户
		return 0;
	}
	//修改密码
	function modify_pw($id, $pw){
		$this->db->where('id_supervisor', $id);      //以ID为条件字段
		$arr=array('password'=>$pw); //将新密码存入数组
		$this->db->update('se_6_supervisor', $arr);    //更新条目
	}
	//删除管理员
	function delete_admin($id){
		$this->db->where('id_supervisor',$id);//以ID为条件字段
		$query=$this->db->delete('se_6_supervisor');//删除ID对应条目
	}
}

?>