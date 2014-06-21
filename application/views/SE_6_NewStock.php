<!DOCTYPE html>
<html>
  <head>
    <title>NewStock</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="/css/bootstrap.min.css">

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
        <li>
          <a href="/index.php/SE6/AddSupervisor">添加账户</a>
        </li>
        <li>
          <a href="/index.php/SE6/DeleteSupervisor">删除账户</a>
        </li>
		<li class="active">
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

	
	
	<div class="row-fluid" style="float:left; margin-left:20%; margin-right:15%" >
		<form action="/index.php/SE6/add_stock" method="post" style="width:300px" role="form">
			  <div align="left" class="form-group">
				<label for="exampleInputEmail1">股票代号</label>
				<input type="text" class="form-control" name="id_stock">
			  </div>
			  <div align="left" class="form-group">
				<label for="exampleInputPassword1">股票名称</label>
				<input type="text" class="form-control" name="name">
			  </div>
			  <div align="left" class="form-group">
				<label for="exampleInputPassword1">股票数</label>
				<input type="text" class="form-control" name="amount">
			  </div>
			   <div align="left" class="form-group">
				<label for="exampleInputPassword1">管理者</label>
				<input type="text" class="form-control" name="id_supervisor">
			  </div>
			
			  <div class="checkbox">
			  </div>
			  <button type="submit" class="btn btn-primary btn-sm">提交</button>
			</form>
			</div>
	<div align="left" class="row-fluid" style="float:left;">
			<form action="/index.php/SE6/s_upload" method="post" style="width:300px" enctype="multipart/form-data">
			  
			  <div align="left" class="form-group">
				<label style="margin-bottom:20px" for="exampleInputFile">批量添加</label>
				<br />
				<input type="file" name="file" id="file">
			  </div>
			  <input type="submit" class="btn btn-primary btn-sm" name="submit" value="上传" />
			</form>
</div>


	
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="/js/jquery/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/js/bootstrap.min.js"></script>
  </body>
</html>
