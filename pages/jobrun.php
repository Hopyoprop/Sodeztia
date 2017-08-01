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
<body>
    <div id="wrapper">
        <!-- Navigation -->
                <div class="col-lg-16">
                    <h1 class="page-header">Deploying <?php echo $_POST['playbook'] ?></h1>
                <!-- /.col-lg-12 -->
         <!-- /.row -->
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <?php
session_start();

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '1qwer$#@!');
define('DB_DATABASE', 'tasks');
$db=mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE) or die("Failed to connect to MySQL: " . mysql_error()); 

$output="";
//Run Vagrant and Ansible Commands here
if ($_SERVER["REQUEST_METHOD"] == "POST"){
$honeypot = strtolower($_POST[playbook]);
exec("sudo cp -a /home/honeypots/$honeypot /home/");
chdir("/home/$honeypot/");
exec("sudo vagrant up --provision 2>&1",$msg,$error);
    
while (@ ob_end_flush()); // end all output buffers if any

$proc = popen('sudo vagrant up --provision', 'r');
echo '<pre>';
while (!feof($proc))
{
    echo fread($proc, 4096);
    @ flush();
}
echo '</pre>';
pclose($proc);

if ($error==1){
    chdir("/var/www/html/pages");
    $file = fopen('../logs/errors.log','a+');
   
    for ($i=0;$i<sizeof($msg);$i++){
        fwrite($file,date("D M j H:i:s Y") . ' [:error] ' .$msg[$i].PHP_EOL);
    }
    fclose($file);
    echo '<META HTTP-EQUIV="Refresh" Content="0; URL=schedule.php?task=2">';
}
else {
    
        $id = mt_rand(0,mt_getrandmax());
        //Else task if Running is Successful
        $sql = "INSERT INTO completed_tasks (id,nameoftask, user, taskexecutedtime,playbook_selected,comments,honeylive) VALUES ($id,'$_POST[jobname]','$_SESSION[username]', NOW(),'$_POST[playbook]','$_POST[comments]','YES')";
    
        if (mysqli_query($db, $sql)) {
            echo '<META HTTP-EQUIV="Refresh" Content="0; URL=schedule.php?task=1">';
        } else {
            echo '<META HTTP-EQUIV="Refresh" Content="0; URL=schedule.php?task=2">';
        }
        mysqli_close($db);
    }
}else {
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}
?>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
        </div>
            
    <!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="../vendor/raphael/raphael.min.js"></script>
    <script src="../vendor/morrisjs/morris.min.js"></script>
    <script src="../data/morris-data.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>
</body>
</html>
