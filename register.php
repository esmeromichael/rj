<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html lang="en">
<!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<title>RJ Pharmacy </title>
	<link href="assets/css/bootstrap.css" rel="stylesheet" />
	<link href="assets/css/font-awesome.min.css" rel="stylesheet" />
	<link href="assets/css/font-awesome-animation.css" rel="stylesheet" />
	<link href="assets/css/prettyPhoto.css" rel="stylesheet" />
	<link href="assets/css/style.css" rel="stylesheet" />
	<link href="assets/css/style2.css" rel="stylesheet" />
	<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
</head>
<body>
	 <!-- NAV SECTION -->
		<div class="navbar navbar-inverse navbar-fixed-top" >
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#">RJ Gwapo</a>
			</div>
		</div>
	</div>
	<div class="container" style="margin-top: 7%;">
		<div id="signupbox" style="margin-top:50px" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
			<div class="panel panel-info">
				<div class="panel-heading">
					<div class="panel-title">Register</div>
					<div style="float:right; font-size: 85%; position: relative; top:-10px"><a id="signinlink" href="login.php" >Login</a></div>
				</div>
				<div class="panel-body" >
					<form id="signupform" class="form-horizontal" role="form" method="post" action="">
						<div id="signupalert" style="display:none" class="alert alert-danger">
							<p>Error:</p>
							<span></span>
						</div>
						<div class="form-group">
							<label for="email" class="col-md-3 control-label">Username</label>
							<div class="col-md-9">
								<input type="text" class="form-control" name="username" placeholder="Username">
							</div>
						</div>
						<div class="form-group">
							<label for="firstname" class="col-md-3 control-label">First Name</label>
							<div class="col-md-9">
								<input type="text" class="form-control" name="firstname" placeholder="First Name">
							</div>
						</div>
						<div class="form-group">
							<label for="lastname" class="col-md-3 control-label">Last Name</label>
							<div class="col-md-9">
								<input type="text" class="form-control" name="lastname" placeholder="Last Name">
							</div>
						</div>
						<div class="form-group">
							<label for="password" class="col-md-3 control-label">Password</label>
							<div class="col-md-9">
								<input type="password" class="form-control" name="password" placeholder="Password">
							</div>
						</div>
						<div class="form-group">
							<!-- Button -->
							<div class="col-md-offset-3 col-md-9">
								<button id="btn-signup" type="submit" class="btn btn-info" name="submit"><i class="icon-hand-right"></i> &nbsp Sign Up</button>
							</div>
						</div>
					</form>
				 </div>
			</div>
		</div>
	</div>
</body>
</html>
<?php
include('connect.php');

	if (isset($_POST['submit'])){
		$Firstname=$_POST['firstname'];
		$Lastname=$_POST['lastname'];
		$username=$_POST['username'];
		$password=md5($_POST['password']);

		$login=mysql_query("select * from users")or die(mysql_error());
		$count=mysql_num_rows($login);
		if ($count < 3){
			mysql_query("insert into users (firstname,lastname,username,password) values('$Firstname','$Lastname','$username','$password')")or die(mysql_error());
			header('location:login.html');
		}
		else{
			echo "</br>";
			echo "</br>";
			echo "</br>";
			echo "</br>";
			echo "<center>";
			echo 'SORRY ONLY 3 USERS ALLOWED TO REGISTER '. '<a href="index.php">CLICK OK</a>';
			echo "</br>";
			echo "</br>";
			echo "</center>";
		}
}

	?>