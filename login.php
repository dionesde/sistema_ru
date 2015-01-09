<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <title>Sistema de cadatro de Computatores</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
     <link rel="stylesheet" href="css/bootstrap.min.css">
     <link rel="stylesheet" href="css/bootstrap-theme.min.css">
     
     <script src="js/bootstrap.min.js"></script>
    <style type="text/css">

.panel-heading {
    padding: 5px 15px;
}

.panel-footer {
	padding: 1px 15px;
	color: #A0A0A0;
}

.profile-img {
	width: 96px;
	height: 96px;
	margin: 0 auto 10px;
	display: block;
	-moz-border-radius: 50%;
	-webkit-border-radius: 50%;
	border-radius: 50%;
}
.error {
background:#ffecec url('http://i.imgur.com/uI9zdLt.png') no-repeat 10px 50%;
border:1px solid #D8000C;
color:#D8000C;
padding-left:30px;
}
.success {
background:#e9ffd9 url('http://i.imgur.com/Z2dChip.png') no-repeat 10px 50%;
border:1px solid #a6ca8a;
}
.warning {
background:#fff8c4 url('http://i.imgur.com/EfdEAUr.png') no-repeat 10px 50%;
border:1px solid #f2c779;
}
.notice {
background:#e3f7fc url('http://i.imgur.com/ZcZFYV7.png') no-repeat 10px 50%;
border:1px solid #8ed9f6;
}
    </style>
  <body>
  	
<div class="container" style="margin-top:40px">
		<div class="row">
			<div class="col-sm-6 col-md-4 col-md-offset-4">
				<div class="panel panel-default">
					<div class="panel-heading">
					<strong>Log in </strong>
					</div>
					<div class="panel-body">
						<form role="form" action="ope.php" method="POST">
							<fieldset>
								<div class="row">
<?php if($_GET['error']){echo "<div class='alert-box error'><span>         </span>Nome de usuário ou senha inválidos</div>"; }?>
									<div class="center-block">
										<img src="img/logo_ufsm.jpg" class="profile-img" alt= ""/>
										
									</div>
								</div>

								<div class="row">
									<div class="col-sm-12 col-md-10  col-md-offset-1 ">
										<div class="form-group">
											<div class="input-group">
												<span class="input-group-addon">
													<i class="glyphicon glyphicon-user"></i>
												</span> 
												<input class="form-control" placeholder="Usuário" name="login" type="text" autofocus>
											</div>
										</div>
										<div class="form-group">
											<div class="input-group">
												<span class="input-group-addon">
													<i class="glyphicon glyphicon-lock"></i>
												</span>
												<input class="form-control" placeholder="Senha" name="senha" type="password" value="">
											</div>
										</div>
										<div class="form-group">
											<input type="submit" class="btn btn-lg btn-primary btn-block" value="Logar">
										</div>
									</div>
								</div>
							</fieldset>
						</form>
					</div>
					<div class="panel-footer ">
					
					</div>
                </div>
			</div>
		</div>
	</div>

  </body>
</html>
