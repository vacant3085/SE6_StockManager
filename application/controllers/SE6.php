<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//MVC中的controller，控制器模块
class SE6 extends CI_Controller {

	function __construct() {
	parent::__construct();
	header("Content-type:text/html;charset=utf-8");  //设置页面编码为utf-8以正常显示汉字
	$this->load->model('SE_6_Stock');     //载入股票模型
	$this->load->model('SE_6_Admin');    //载入管理员模型
	$this->load->database();
	}

	//控制器默认页面
	function index(){
		$this->load->view('SE_6_login');       //默认载入登陆界面
	}

	//检查登陆信息
	function checklogin()
	{
		$user=$_POST['user'];    //获取登陆的用户名
		$password=$_POST['password'];  //获取登陆的密码
		$this->load->library('session');   //载入session类保存登陆信息
		$return=$this->SE_6_Admin->user_select($user);  //调用管理员模型中的方法获取密码
		if(!$return){      //若对应id没有查询结果
			echo "<script>alert('用户不存在!');location.href='/index.php/SE6/';</script>";
			//$this->load->view('SE_6_login');
		}
		else if($return[0]->password!=$password){       //若查询的密码与输入不匹配
				echo "<script>alert('密码错误!');location.href='/index.php/SE6/';</script>";
				//$this->load->view('SE_6_login');
		}
		else
		{
			$arr=array("aid"=>$user);        
			$this->session->set_userdata($arr); //在session类保存登陆信息
			//$this->load->view('SE_6_head');
			$this->main();      //载入用户主界面
		}
	}


	//检查登陆信息
	function checksession()
	{
		$this->load->library('session');      //载入session类
		if($this->session->userdata('aid'))      //若已登陆
			return 1;
		else               //未登录返回0
			return 0;
	}

	//获取session类中保存的用户名
	function getuid()
	{
		$this->load->library('session');
		return $this->session->userdata('aid');		
	}

	//用户主界面
	function main(){
		if($this->checksession()){       //若已经登陆
			$user=$this->getuid();       //获取用户id
			if($this->SE_6_Admin->is_super($user)){      //如果是超级管理员
				$this->load->view('SE_6_supermanage');       //进入超级管理员界面
			}
			else{         //如果是普通管理员
				$arr2=$this->SE_6_Stock->get_stock($user);  //获取用户管理的股票ID
				$size=count($arr2);
				$data=array('uid'=>$user);
				$arr3=array();
				for ($i = 0; $i <$size; $i++)      //查询所有股票的具体信息，存入数组
				{ 
					$res=$this->SE_6_Stock->stock_info($arr2[$i]->id_stock);
					array_push($arr3, $res[0]);
				} 	
				$data['data']=$arr3;    
				$this->load->view('SE_6_manage',$data);  //将数据提供给管理员界面展示
			}
		}
		else{      //若未登录
			echo "<script>alert('请登录!');</script>";
			$this->load->view('SE_6_login');
		} 
	}
	//退出
	function logout()
	{
		$this->load->library('session'); 
		$this->session->unset_userdata('aid');      //删除用户登陆信息
		$this->load->view('SE_6_login');
	}

	//暂停交易
	function pause_trade(){
		$sid=$_POST['sid'];        //获得股票id
		$this->SE_6_Stock->pause_trade($sid);     //调用股票模型方法暂停交易
		$this->main();        //回到主界面
	}

	//重启交易
	function restart_trade(){
		$sid=$_POST['sid'];   //获得股票id
		$this->SE_6_Stock->restart_trade($sid); //调用股票模型方法重启交易
		$this->main();  //回到主界面
	}

	//设置涨跌停
	function set_limit(){
		$sid=$_POST['sid'];	//获得股票id
		$limit=$_POST['limit'];		//获得涨跌停值
		if(!preg_match('/^[0-9]*$/i',$limit)){
			echo "<script>alert('涨跌停限制输入必须为数字!');</script>"; 
			$this->main();  	//回到主界面
		}
		else{
			$this->SE_6_Stock->set_limit($sid,$limit);//调用股票模型方法设置涨跌停
			$this->main();  	//回到主界面
		}
	}

	//上传文件(批量添加管理员)
	function a_upload(){
		if($_FILES['file']['size']!=NULL){
			$file=$_FILES['file'];        //获取上传的文件
			$name="tmpfile";           //命名为tmpfile
			if(move_uploaded_file($file['tmp_name'],$name)){  //保存在服务器
				$handle= fopen("tmpfile", "r");     //打开文件
				$this->db->trans_start();//事务开始
				if ($handle) {   
					while (!feof($handle)) {     
					$buffer = fgets($handle, 4096);   //按行读取文件到缓存
					$arr=explode(" ",$buffer);
					$data=array(        //存入数组
						'id_supervisor'=>$arr[0],
						'password'=>$arr[1],
						'isAdmin'=>0
						);	
					$this->SE_6_Admin->new_admin($data);   //调用管理员模型方法添加管理员
					}
				$this->db->trans_complete(); //事务结束
				fclose($handle);      
				}
				echo "<script>alert('批量添加完成!');</script>"; 	
			}
			else{
				echo "<script>alert('上传失败!');</script>"; 
			}		
		}
		$this->load->view('SE_6_AddSupervisor');
	}

	//上传文件(批量添加股票)
	function s_upload(){
		if($_FILES['file']['size']!=NULL){
			$file=$_FILES['file'];       //获取上传文件
			$name="tmpfile";
			if(move_uploaded_file($file['tmp_name'],$name)){
				$handle= fopen("tmpfile", "r");    //读取文件
				$this->db->trans_start();//事务开始
				if ($handle) {
					$error="<script>alert('第";
					$i=0;
					$wrong=0;
					while (!feof($handle)) {
						$i=$i+1;
						$buffer = fgets($handle, 4096);   //文件按行读入缓存
						$arr=explode(" ",$buffer);
						$arr[3]=trim($arr[3]);
						$return1=$this->SE_6_Stock->check_id($arr[0]);  
						$return2=$this->SE_6_Admin->check_id($arr[3]); 			
						if($return1){
							$error=$error.$i." ";
							$wrong=1;
						}
						else if(!$return2){  
							$error=$error.$i." ";
							$wrong=1;
						}
						else if(!preg_match('/^[0-9]*$/i',$arr[2])){
							$error=$error.$i." ";
							$wrong=1;
						}
						else{
							$data=array('id_stock'=>$arr[0],  //分割字符串，存入数组
								'name'=>$arr[1],
								'limit_today'=>-1,
								'limit_tomorrow'=>10,
								'trade_state'=>1); 
							$this->SE_6_Stock->new_stock($data, $arr[3]); //调用股票模型方法添加新股
						}
					}
					$error=$error."行添加失败 ');</script>";
					if($wrong!=0){
						echo $error;
					}
					$this->db->trans_complete(); //事务结束
					fclose($handle);
				}
				echo "<script>alert('批量操作完成!');</script>"; 	
			}
			else{
				echo "<script>alert('上传失败!');</script>"; 
			}		
		$this->load->view('SE_6_NewStock');//进入超级管理员界面
		}
	}

	//单支新股
	function add_stock(){
		$id_stock=$_POST['id_stock'];      //获取股票信息
		$name=$_POST['name'];
		$amount=$_POST['amount'];
		$id_supervisor=$_POST['id_supervisor'];
		$return=$this->SE_6_Stock->check_id($id_stock);   //检查是否重复
		if($return){
			echo "<script>alert('股票已存在!');</script>";
			$this->load->view('SE_6_NewStock');      //继续添加
		}
		else if(!preg_match('/^[0-9]{6}$/i',$id_stock)){
			echo "<script>alert('股票代号必须为6位数字!');</script>"; 
			$this->load->view('SE_6_NewStock');      //继续添加
		}
		else if(!preg_match('/^[0-9]*$/i',$amount)){
			echo "<script>alert('股票数必须为数字!');</script>"; 
			$this->load->view('SE_6_NewStock');      //继续添加
		}
		else{
			$arr=array('id_stock'=>$id_stock,    //存入数组
			'name'=>$name,
			'limit_today'=>-1,
			'limit_tomorrow'=>10,
			'trade_state'=>1); 
			$return=$this->SE_6_Admin->check_id($id_supervisor); 
			if(!$return){
				echo "<script>alert('管理员不存在!');</script>";
				$this->load->view('SE_6_NewStock');      //继续添加
			}
			else{
				$this->SE_6_Stock->new_stock($arr,$id_supervisor); //调用股票模型方法添加新股
				echo "<script>alert('添加成功!');</script>"; 
				$this->load->view('SE_6_NewStock');    //继续添加
			}
		}
	}

	//删除股票
	function del_stock(){
		$id_stock=$_POST['id_stock'];
		$return=$this->SE_6_Stock->check_id($id_stock); //检查id正确性
		if($return){
			$this->SE_6_Stock->delete_stock($id_stock);   //调用股票模型发方法删除股票
			echo "<script>alert('删除完成!');</script>";
			$this->load->view('SE_6_DeleteStock');
		}
		else{
			echo "<script>alert('股票不存在!');</script>";
			$this->load->view('SE_6_DeleteStock');
		}
	}

	//设置股票管理员
	function set_relation(){
		$id_stock=$_POST['id_stock'];    //获取表单信息
		$id_supervisor=$_POST['id_supervisor'];
		$arr=array(      //存入数组
			'id_stock'=>$id_stock,
			'id_supervisor'=>$id_supervisor);
		if($this->SE_6_Stock->check_id($id_stock) && $this->SE_6_Admin->check_id($id_supervisor))
		{
			$this->SE_6_Stock->relation_insert($arr);      //调用股票模型方法设置管理员
			echo "<script>alert('设置成功!');</script>"; 
			$this->load->view('SE_6_SetPrevilege');
		}
		else{
			echo "<script>alert('设置失败!');</script>"; 
			$this->load->view('SE_6_SetPrevilege');
		}
	}

	//删除管理员
	function del_admin(){ 
		$id_supervisor=$_POST['id_supervisor'];   //获取要删除的id
		$return=$this->SE_6_Admin->check_id($id_supervisor);
		if($return){
			$this->SE_6_Admin->delete_admin($id_supervisor); //用管理员模型中的方法删除账户
			echo "<script>alert('删除完成!');</script>";
			$this->load->view('SE_6_DeleteSupervisor');
		}
		else{
			echo "<script>alert('管理员不存在!');</script>";
			$this->load->view('SE_6_DeleteSupervisor');
		}
	}
	//修改密码
	function modify_password(){
		$id=$_POST['id'];      //用户id
		$return=$this->SE_6_Admin->user_select($id); //获得当前密码
		$pw0=$_POST['password0'];	//输入的旧密码
		$pw=$_POST['password'];	//新密码
		$pw1=$_POST['password1'];	//新密码确认
		if($pw!=$pw1)    //两次输入不一致
		{
			echo "<script>alert('两次输入的密码不一致!');</script>"; 
			$this->newpassword();
		}
		else if($return[0]->password!=$pw0)   //密码错误
		{
			echo "<script>alert('密码错误!');</script>";
			$this->newpassword();
		}
		else
		{
			$this->SE_6_Admin->modify_pw($id,$pw);  //调用管理员模型方法修改密码
			echo "<script>alert('修改成功!');</script>"; 
			$this->main();  //回到主界面
		}
	}

	//新管理员
	function add_admin(){
		$id=$_POST['id'];
		$password=$_POST['password'];
		$password2=$_POST['password2'];
		if(strlen($id)==0){
			echo "<script>alert('请输入用户名!');</script>";
			$this->load->view('SE_6_AddSupervisor');
		}
		else if(strlen($password)==0){
			echo "<script>alert('请输入密码!');</script>";
			$this->load->view('SE_6_AddSupervisor');
		}
		else if(strlen($password2)==0){
			echo "<script>alert('请再次输入密码!');</script>";
			$this->load->view('SE_6_AddSupervisor');
		}
		else if(!preg_match('/^[0-9a-zA-Z]{1,20}$/i',$id)){
			echo "<script>alert('用户名只能包括数字和英文字符，长度必须小于20');</script>";
			$this->load->view('SE_6_AddSupervisor');
		}
		else if(!preg_match('/^[0-9a-zA-Z]{6,20}$/i',$password)){
			echo "<script>alert('密码只能包括数字和英文字符，长度为6-20');</script>";
			$this->load->view('SE_6_AddSupervisor');
		}
		else if($password!=$password2){
			echo "<script>alert('两次输入的密码不相同');</script>";
			$this->load->view('SE_6_AddSupervisor');
		}
		else{
		$arr=array('id_supervisor'=>$_POST['id'],        //根据表单获取新用户信息
			'password'=>$_POST['password'],
			'isAdmin'=>0
			);
		$result=$this->SE_6_Admin->new_admin($arr);     //添加用户
		if(($result)==-1){
			echo "<script>alert('该管理员已存在!');</script>"; 
			$this->load->view('SE_6_AddSupervisor');
		}
		else{
			echo "<script>alert('增加新管理员成功!');</script>"; 
			$this->load->view('SE_6_AddSupervisor');
		}
		}
	}

	//调用设置权限页面
	function SetPrevilege(){
		$this->load->view('SE_6_SetPrevilege');
	}

	//调用增加管理员页面
	function AddSupervisor(){
		$this->load->view('SE_6_AddSupervisor');
	}

	//调用删除管理员页面
	function DeleteSupervisor(){
		$this->load->view('SE_6_DeleteSupervisor');
	}

	//调用新股上市页面
	function NewStock(){
		$this->load->view('SE_6_NewStock');
	}

	//调用修改密码页面
	function newpassword(){
		$this->load->view('SE_6_changepw');	
	}

}

?>
