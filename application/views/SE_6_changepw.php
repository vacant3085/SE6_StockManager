<!DOCTYPE html>
<html>
	<head>
		<title>股票管理系统|修改密码</title>
    		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<!-- UI所需的js文件 -->
		<link href="/css/bootstrap.min2.css" rel="stylesheet" media="screen">
		<script src="/js/jquery/jquery.js"></script>
   		<script src="/js/bootstrap.min.js"></script>
  	</head>
  
  	<!-- 界面主容器 -->
	<div class="well" style="max-width: 400px; margin: 0 auto 10px;">
		<h1 align="center">修改密码</h1>

		<!-- logo图片 -->
    		<div class="well" style="max-width: 300px; margin: 0 auto 10px;">
    			<img src="/img/cplogo.jpg" class="img-rounded">
   		</div>

		<!-- 获取用户名和密码的form -->
		<form id="changePasswordForm" align="center" action="/index.php/SE6/modify_password" method="post">
			<div class="input-prepend">
				<span class="add-on">确认管理员ID：</span>
				<input class="span2" id="prependedInput" type="text" name="id" />
			</div>
			<br />
			<div class="input-prepend">
				<span class="add-on">原始密码</span>
				<input class="span2" id="prependedInput" type="password" name="password0" />
			</div>
			<br />
			<div class="input-prepend">
				<span class="add-on">新密码</span>
				<input class="span2" id="prependedInput" type="password" name="password" />
			</div>
			<br />
			<div class="input-prepend">
				<span class="add-on">确认新密码</span>
				<input class="span2" id="prependedInput" type="password" name="password1" />
			</div>
			<br />
			<input class="btn btn-primary" type="submit" value="确定" />
			<a href="/index.php/SE6/main" class="btn btn-inverse" type="button" align="center">取消</a>
		</form>
	
		<!-- 版权声明 -->
		<p align="center">Copyright 2014 S1-6<br />Staff: Jermaine Lee, Alibuda, Suscitation, Yalin Zhou</p>
	</div>
</html>

