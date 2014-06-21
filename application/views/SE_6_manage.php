<!DOCTYPE html>
<!-- 页面中的对话框实现在本文件末端 -->
<html>

	<head>
		<title>股票管理系统|管理员操作界面</title>
    		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<!-- 字符集定义 -->
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		
		<!-- UI所需js库文件 -->
		<script src="/js/jquery/jquery.js"></script>
		<script src="/js/bootstrap.js" ></script>
		<link href="/css/bootstrap.min2.css" rel="stylesheet" media="screen">
	</head>

	<!-- UI主要容器 -->
	<div class="well" style="max-width: 1200px; margin: 0 auto 10px;">

		<!-- 管理员信息栏 -->
		<div class="well" style="max-width: 1200px; margin: 0 autu 10px;">
			<table width="1200" border="0">
				<tr>
					<!-- 管理员头像（目前为默认头像） -->
					<td align="center" width="120">
						<img src="/img/photo.jpg" />
					</td>
					<td align="center" width="100">
						<?php 
							//从服务器获取管理员用户名并显示
							echo '<strong align="center">'.$uid."</strong></br><p>管理员您好！</br>您可以：</p>";
						?>
						<a href="/index.php/SE6/newpassword" data-toggle="modal" class="btn btn-primary" type="button" align="center">修改密码</a>
						<a href="/index.php/SE6/logout" class="btn btn-inverse" type="button" align="center">退出登录</a>
					</td>

					<!-- 广告栏（主要是为了布局的美化） -->
					<td align="left" width="1000">
						<img src="/img/rent.jpg" />
					</td>
				</tr>
			</table>
		</div>
	
		<!-- 股票管理栏 -->
		<div class="well" style="max-width: 1200px; margin: 0 auto 10px;">
			<p>您管理的股票：</p>
			<table class="table table-bordered table-hover table-condensed">
				
				<!-- 表头 -->
				<tr class="info">
					<td><strong>股票ID</strong></td>
					<td><strong>股票名称</strong></td>
					<td><strong>交易状态</strong></td>
					<td><strong>今日涨跌停限制</strong></td>
					<td><strong>次日涨跌停限制</strong></td>
					<td width="138"><strong>其它操作</strong></td>
				</tr>
				<?php
					$size=count($data);
					for($i=0;$i<$size;$i++)
					{
						echo "<tr style='background-color:#ffffff'>";
						echo '<td>'.$data[$i]->id_stock.'</td>';
						echo '<td>'.$data[$i]->name.'</td>';

						//交易状态及其操作按钮智能显示
						if($data[$i]->trade_state==1)
						{
							echo '<td class="text-success">交易开启&nbsp;';
							echo '<a href="#changeStateModal'.$data[$i]->id_stock.'" class="btn btn-danger" type="button" data-toggle="modal" align="center">暂停</a>';
							echo '</td>';
						}
						else
						{
							echo '<td class="text-error">交易暂停&nbsp;';
							echo '<a href="#changeStateModal'.$data[$i]->id_stock.'" class="btn btn-success" type="button" data-toggle="modal" align="center">重启</a>';
							echo '</td>';
						}

						//当天、次日涨跌停限制显示
						echo '<td>';
						if($data[$i]->limit_today<10)
						{
							echo'&nbsp;&nbsp;';
						}
						echo $data[$i]->limit_today.'%</td>';
				
						echo '<td>';
						if($data[$i]->limit_tomorrow<10)
						{
							echo'&nbsp;&nbsp;';
						}
						echo $data[$i]->limit_tomorrow.'%&nbsp;';
						//次日涨跌停设置按钮
						echo '<a href="#setLimit'.$data[$i]->id_stock.'" class="btn btn-primary" type="button" data-toggle="modal" align="center">设置</a></td>';
						echo '<td>
							<a href="#checkTradeInfo'.$data[$i]->id_stock.'" class="btn btn-info" type="button" data-toggle="modal" align="center">查看最近交易信息</a>
							</td>';
						echo '</tr>';
					}
				?>
			</table>
		</div>

		<!-- 版权声明 -->
		<p align="center">Copyright 2014 S1-6<br />Staff: Jermaine Lee, Alibuda, Suscitation, Yalin Zhou</p>
	</div>

<?php	//对话框实现

	$size=count($data);
	for($i=0;$i<$size;$i++)
	{
		//更改交易状态对话框：
		echo '<div id="changeStateModal'.$data[$i]->id_stock.'" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
 			<div class="modal-header">
    				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    				<h3 id="myModalLabel">交易状态改变确认</h3>
  			</div>
  			<div class="modal-body">
			<p>确定要';
		if($data[$i]->trade_state==1)
		{
			echo '<strong class="text-error">暂停</strong>';
		}
		else
		{
			echo '<strong class="text-success">重启</strong>';
		}
		echo '<strong>“'.$data[$i]->name.'”</strong>股票的交易吗？</p>';
		
		echo '<form id="changeStateForm'.$data[$i]->id_stock.'" action="/index.php/SE6/';
		if($data[$i]->trade_state==1)
		{
			echo 'pause_trade';
		}
		else
		{
			echo 'restart_trade';
		}
		echo '" method="post">';
		echo '<div class="input-prepend">
				<span class="add-on">股票ID</span>
				<input class="span2" id="prependedInput" type="text" name="sid" value="'.$data[$i]->id_stock.'" readonly="true" />
			</div>
			</form>
			</div>';
		
  		echo '<div class="modal-footer">
			<input form="changeStateForm'.$data[$i]->id_stock.'" class="btn btn-primary" type="submit" value="确定" />	
			<button class="btn" data-dismiss="modal" aria-hidden="true">取消</button>
  			</div>
			</div>';

		//设置涨跌停限制对话框：
		echo '<div id="setLimit'.$data[$i]->id_stock.'" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
 			<div class="modal-header">
    				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    				<h3 id="myModalLabel">涨跌停限制设置</h3>
  			</div>
  			<div class="modal-body">
				<form id="setLimitForm'.$data[$i]->id_stock.'" action="/index.php/SE6/set_limit" method="post">
					<p>设置<strong>“'.$data[$i]->name.'”</strong>股票次日涨跌停限制为：</p>
					<div class="input-prepend">
						<span class="add-on">股票ID</span>
						<input class="span2" id="prependedInput" type="text" name="sid" value="'.$data[$i]->id_stock.'" readonly="true" />
					</div>
					<div class="input-append">
  						<input class="span2" id="appendedInput" type="text" name="limit" value="10" />
  						<span class="add-on">%</span>
					</div>	
				</form>
  			</div>
  			<div class="modal-footer">
				<input form="setLimitForm'.$data[$i]->id_stock.'" class="btn btn-primary" type="submit" value="确定" />
				<button class="btn" data-dismiss="modal" aria-hidden="true">取消</button>
  			</div>
			</div>';

		//查看最近交易信息对话框：	
		echo '<div id="checkTradeInfo'.$data[$i]->id_stock.'" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
 			<div class="modal-header">
    				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    				<h3 id="myModalLabel">查看最近交易信息</h3>
  			</div>
  			<div class="modal-body">
				<p><strong>“'.$data[$i]->name.'”</strong>股票的最近交易信息：</p>
				<strong>最近成交价格：</strong>
				<strong>最近成交数量：</strong>
				<table class="table table-bordered table-hover table-condensed">
					<tr class="info">
						<td><strong>最近买指令</strong></td>
					</tr>
				</table>
				<table class="table table-bordered table-hover table-condensed">
					<tr class="info">
						<td><strong>最近卖指令</strong></td>
					</tr>
				</table>
				<span class="label label-important">需调用“中央交易系统”相应接口实现</span>
			</div>
  			<div class="modal-footer">
				<button class="btn" data-dismiss="modal" aria-hidden="true">关闭</button>
  			</div>
			</div>';
		
		//修改密码对话框
		echo '<div id="changePassword" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
 			<div class="modal-header">
    				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    				<h3 id="myModalLabel">修改登录密码</h3>
  			</div>
  			<div class="modal-body">
				<form id="changePasswordForm" align="center" action="/index.php/SE6/modify_password" method="post">
					<div class="input-prepend">
						<span class="add-on">管理员ID：</span>
						<input class="span2" id="prependedInput" type="text" name="id" value="'.$uid.'" readonly="true"/>
					</div>
					<br />
					<div class="input-prepend">
						<span class="add-on">原始密码</span>
						<input class="span2" id="prependedInput" type="text" name="password0" />
					</div>
					<br />
					<div class="input-prepend">
						<span class="add-on">新密码</span>
						<input class="span2" id="prependedInput" type="text" name="password" />
					</div>
					<br />
					<div class="input-prepend">
						<span class="add-on">确认新密码</span>
						<input class="span2" id="prependedInput" type="text" name="password1" />
					</div>
				</form>
			</div>
  			<div class="modal-footer">
				<input form="changePasswordForm" class="btn btn-primary" type="submit" value="确定" />
				<button class="btn" data-dismiss="modal" aria-hidden="true">取消</button>
  			</div>
			</div>';
	}
?>
</html>

