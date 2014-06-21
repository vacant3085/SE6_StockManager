<!DOCTYPE html>
<html>
	<head>
		<title>股票管理系统|登录界面</title>
    		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<!-- UI所需的js文件 -->
		<link href="/css/bootstrap.min2.css" rel="stylesheet" media="screen">
		<script src="/js/jquery/jquery.js"></script>
   		<script src="/js/bootstrap.min.js"></script>
  	</head>
  
  	<!-- 界面主容器 -->
	<div class="well" style="max-width: 400px; margin: 0 auto 10px;">
		<h1 align="center">股票管理系统</h1>

		<!-- logo图片 -->
    		<div class="well" style="max-width: 300px; margin: 0 auto 10px;">
    			<img src="/img/logo.jpg" class="img-rounded">
   		</div>

		<!-- 获取用户名和密码的form -->
		<div class="well" style="max-width: 280px; margin: 0 auto 10px;">
			<form  action="/index.php/SE6/checklogin" method="post">
				<div class="input-prepend">
		  			<span class="add-on">账号：</span>
		  			<input class="span3" id="appendedPrependedInput" type="text" name="user">
				</div>
				</br>
				<div class="input-prepend">
		  			<span class="add-on">密码：</span>
		  			<input class="span3" id="appendedPrependedInput" type="password" name="password">
				</div>
				</br>
				<button type="submit" class="btn btn-primary btn-block">登录</button>
			</form>
		</div>
	
		<!-- 版权声明 -->
		<p align="center">Copyright 2014 S1-6<br />Staff: Jermaine Lee, Alibuda, Suscitation, Yalin Zhou</p>
	</div>
</html>
