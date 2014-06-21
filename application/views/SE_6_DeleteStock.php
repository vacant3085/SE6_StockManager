
<html>
  <head>
    <title>DeleteSupervisor</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="/css/bootstrap.min.css">

	<script language="JavaScript">
		function testEnter(){
			 alert(self.location=(document.getElementById('id_stock').value));
			
		}
	</script>
	<?php
		$supervisor = !empty($_POST["id_stock"]) ? $_POST["id_stock"] : null
	?>
  </head>
  <body>
   <header class="navbar navbar-inverse navbar-fixed-top bs-docs-nav" role="banner">
  <div class="container">
    <div class="navbar-header">
      <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".bs-navbar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a href="/index.php/SE6/main" class="navbar-brand">StockManager</a>
    </div>
    <nav class="collapse navbar-collapse bs-navbar-collapse" role="navigation">
      <ul class="nav navbar-nav">
   
        <li>
          <a href="/index.php/SE6/SetPrevilege">设置权限</a>
        </li>
        <li class="active">
          <a href="/index.php/SE6/AddSupervisor">添加账户</a>
        </li>
        <li>
          <a href="/index.php/SE6/DeleteSupervisor">删除账户</a>
        </li>
		<li>
          <a href="/index.php/SE6/NewStock">新股上市</a>
        </li>
		<li>
          <a href="/index.php/SE6/newpassword">修改密码</a>
        </li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li>
          <a href="/index.php/SE6/logout">退出登陆</a>
        </li>
      </ul>
    </nav>
  </div>
</header>


	<div style="margin-top:100px" class="container-fluid">
	<div class="row-fluid">
		<div class="span12">
			
		</div>
	</div>
	<div align="center"  class="row-fluid">
		<div style="width:300px" class="span12">
			<form action="index.php/SE6/del_stock" method="post" role="form" onKeyPress="">
			  <div align="left" class="form-group">
				<label for="exampleInputEmail1">请输入股票代号：</label>
				<input type="text" class="form-control" id="id_stock" onDblClick="testEnter()" onKeyPress="">
				<br/>
				<strong>股票名称：</strong><?php echo !empty($_POST["stock_name"]) ? $_POST["stock_name"] : ""?><br/>
				<strong>管理者：</strong><?php echo !empty($_POST["supervisor"]) ? $_POST["supervisor"] : ""?>
			  </div>
			  <button type="submit" class="btn btn-primary btn-sm">确认删除</button>
			</form>
		</div>
	
		</div>
	</div>
	




    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="/js/jquery/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/js/bootstrap.min.js"></script>
  </body>
</html>
