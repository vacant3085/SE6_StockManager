<!DOCTYPE html>
<html>
  <head>
    <title>DeleteSupervisor</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="/css/bootstrap.min.css">

	 <script type="text/javascript">
		$().ready(function() {
		 $("#id_supervisor").autocomplete("get_course_list.php", {
		  selectFirst: false
		 });
		});
	</script>
	
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
        <li class="active">
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
	<div align="center" class="container-fluid">

	<div style="margin-top:100px;width:400px">
	<form  action="/index.php/SE6/del_admin" method="post" role="form">
			  <div align="left" class="form-group">
				<label for="exampleInputEmail1">请输入管理员账户：</label>
				<input type="text" class="form-control" name="id_supervisor">
				<br/>
			  </div>
			  <button type="submit" class="btn btn-primary btn-sm">确认删除</button>
			</form>
	</div>

	</div>
	



    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/js/bootstrap.min.js"></script>
  </body>
</html>
