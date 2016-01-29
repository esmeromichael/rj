<?php
error_reporting(0);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>RJ Pharmacy </title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

    <link href="assets/css/font-awesome.min.css" rel="stylesheet" />
    <link href="assets/css/font-awesome-animation.css" rel="stylesheet" />
    <link href="assets/css/prettyPhoto.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
    <link href="assets/css/style2.css" rel="stylesheet" />

    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
</head>
<body>

     <div class="container">
        <div class="card card-container">
            <img id="profile-img" class="profile-img-card" src="img/rj.jpg" />
            <p id="profile-name" class="profile-name-card"></p>
            <form class="form-signin" method="post" action="">
                <input type="text" id="inputEmail" class="form-control" name="username" placeholder="Username" required autofocus>
                <input type="password" id="inputPassword" class="form-control" name="password" placeholder="Password" required>
                <div id="remember" class="checkbox">
                    <label>
                        <input type="checkbox" value="remember-me"> Remember me
                    </label>
                </div>
                <button class="btn btn-lg btn-primary btn-block btn-signin" name="submit" type="submit">Login in</button>
               <!--  Mao ni ang script sa login -->
                <div class="flash-message">
                    <?php
                    include('connect.php');

                    if (isset($_POST['submit'])) {
                        $username=$_POST['username'];
                        $password=md5($_POST['password']);
                        $result=mysql_query("select * from users where username='$username' && password='$password'")or die (mysql_error());

                        $count=mysql_num_rows($result);
                        $row=mysql_fetch_array($result);

                        if ($count > 0){
                            session_start();
                            $_SESSION['id'] = $row['id'];
                            header('location:index.php');
                        }
                        else{
                           echo "<p class='alert-danger' style=''>Mismatch username or password. </p>";
                        }
                    }
                    ?>
                </div>
               <!--  end script -->
            </form>
            <a href="register.php" class="forgot-password">
                Register?
            </a>
        </div>
    </div>
</body>
</html>



