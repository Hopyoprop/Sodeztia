<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Login</title>

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<?php
session_start();
if (empty($_SESSION["username"]) && empty($_SESSION["password"])){
$_SESSION["username"] = "";
$_SESSION["password"] = "";
$_SESSION["nameErr"] = "";
$_SESSION["passErr"] = "";
$_SESSION["authErr"] = "";
}
?>

<body>

    <div class="container">
        <div class="col-lg-12">
           <img src="../images/logo_big.png" width="30%" style="display:block; margin-left:auto; margin-right:auto;">  
        </div>
        <div class="row">
         <div class="col-lg-12">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Please Sign In</h3>
                    </div>
                    <div class="panel-body">
                        <form method="post" action="loginvalidation.php">
                            <fieldset>
                            <div class="has-error">
                                    <label class="control-label" for="inputError"> <?php echo $_SESSION["authErr"]; ?></label>
                            </div>
                           
                            <?php if($_SESSION["nameErr"]=="") : ?>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Username" name="username" type="text" value="<?php echo $_SESSION["username"]?>" autofocus>
                                </div>
                                <?php else :?>
                                <div class="form-group has-error">
                                        <label class="control-label" for="inputError"><?php echo $_SESSION["nameErr"]?></label>
                                         <input class="form-control" placeholder="Username" name="username" type="text" autofocus value="<?php echo $_SESSION["username"]?>"><label class="control-label" for="inputError">
                                </div>
                            <?php endif?>
                            <?php if($_SESSION["passErr"]=="") : ?>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="password" type="password" value="<?php echo $_SESSION["password"]?>">
                                </div>
                            <?php else : ?>
                                    <div class="form-group has-error">
                                    <label class="control-label" for="inputError"><?php echo $_SESSION["passErr"] ?></label>
                                    <input type="password" class="form-control" placeholder="Password" name="password" type="password" value="<?php echo $_SESSION["password"]?>" id="inputError">
                                </div>
                            <?php endif?>
                                <input type="submit" class="btn btn-lg btn-success btn-block" value="Login"></input>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

</body>

</html>
