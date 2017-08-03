<!DOCTYPE html>
<html lang="en">
<?php session_start();
if (empty($_SESSION["username"])){
    header('Location: login.php');
}
?>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Sodeztia</title>
    
    <!-- PHP Link -->
    <link href="../php/index.php">

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="../vendor/morrisjs/morris.css" rel="stylesheet">

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
    define('DB_SERVER', 'localhost');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', '1qwer$#@!');
    define('DB_DATABASE', 'tasks');
    $db=mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE) or die("Failed to connect to MySQL: " . mysql_error()); 
    
    $sql = "SELECT COUNT(*) as 'Tasks' from completed_tasks";
    $result = mysqli_query($db,$sql);
    $row = mysqli_fetch_assoc($result);
    
    $sql2 = "SELECT COUNT(*) as 'Tasks' FROM completed_tasks WHERE honeylive='YES'";
    $result2 = mysqli_query($db, $sql2);
    $row2 = mysqli_fetch_assoc($result2);
    
    $output = shell_exec("sudo ls /home/honeypots/");
    $honeypots = preg_split("#[\r\n]+#", $output);
    $noofhoney = sizeof($honeypots)-1;
    
    $sql3="SELECT CONVERT(taskexecutedtime,DATE) as 'Dates', COUNT(CONVERT(taskexecutedtime,DATE)) as 'Count' FROM completed_tasks GROUP BY Dates";
    $result3 = mysqli_query($db,$sql3);
    $row3 = mysqli_fetch_all($result3,MYSQLI_NUM); 
    
    $sql4="SELECT name, TIMESTAMPDIFF(hour, timeadded, NOW()) as 'diff',comment from comments;";
    $result4=mysqli_query($db,$sql4);
    $row4=mysqli_fetch_all($result4,MYSQLI_NUM);

?>  
    <script type="text/javascript">
window.onload = function () {
    var chart = new CanvasJS.Chart("chartContainer",
    {
      title:{
        text: "Timeline of Last"
    },
       animationEnabled: true,
    axisX:{
        title: "Timeline",
        gridThickness: 2,
        valueFormatString: "DD MMM"
    },
    axisY: {
        title: "Tasks Executed"
    },
    data: [
    {        
        type: "spline",
        dataPoints: [//array
        <?php 
    if (sizeof($row3)<5){
    for ($i=0; $i<sizeof($row3); $i++){ 
         $dateoutput = explode("-",$row3[$i][0]);
            ?>
        { x: new Date(<?php echo $dateoutput[0]?>,<?php echo $dateoutput[1]-1?>, <?php echo $dateoutput[2] ?>), y:<?php echo $row3[$i][1] ?>},
<?php }}
    else {
     for ($i=0; $i<5; $i++){ 
         $dateoutput = explode("-",$row3[$i][0]);
            ?>
        { x: new Date(<?php echo $dateoutput[0]?>,<?php echo $dateoutput[1]-1?>, <?php echo $dateoutput[2] ?>), y:<?php echo $row3[$i][1] ?>},
<?php }   
        
    }?>
        ]
    }
    ]
});

    chart.render();
}
</script>
<body>
    <div id="wrapper">
        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <img src="../images/logo.png" alt="Logo.png"><a class="navbar-brand" href="index.php">Sodeztia</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <!-- /.dropdown --> 
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-tasks fa-fw"></i> Task Progress <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-tasks">
                        <li>
                            <a href="#">
                                <div>
                                    <p>
                                        <strong>Task 1</strong>
                                        <span class="pull-right text-muted">40% Complete</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                                            <span class="sr-only">40% Complete (success)</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <p>
                                        <strong>Task 2</strong>
                                        <span class="pull-right text-muted">20% Complete</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%">
                                            <span class="sr-only">20% Complete</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <p>
                                        <strong>Task 3</strong>
                                        <span class="pull-right text-muted">60% Complete</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%">
                                            <span class="sr-only">60% Complete (warning)</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <p>
                                        <strong>Task 4</strong>
                                        <span class="pull-right text-muted">80% Complete</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%">
                                            <span class="sr-only">80% Complete (danger)</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a class="text-center" href="#">
                                <strong>See All Tasks</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-tasks -->
                </li>
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-bell fa-fw"></i> Alerts <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-alerts">
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-comment fa-fw"></i> New Comment
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-twitter fa-fw"></i> 3 New Followers
                                    <span class="pull-right text-muted small">12 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-envelope fa-fw"></i> Message Sent
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-tasks fa-fw"></i> New Task
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-upload fa-fw"></i> Server Rebooted
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a class="text-center" href="#">
                                <strong>See All Alerts</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-alerts -->
                </li>
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i><?php echo $_SESSION["username"];?> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->
            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse collapse" aria-expanded="false">
                    <ul class="nav" id="side-menu">
                        <li>
                            <a href="index.php"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Tasks<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="completedtasks.php"><i class="fa fa-check-circle fa-fw"></i> Completed Tasks</a>
                                </li>
                                <li>
                                    <a href="schedule.php"><i class="fa fa-clock-o fa-fw"></i> Execute Task</a>
                                </li>
                                <li>
                                    <a href="destroytask.php"><i class="fa fa-times-circle-o fa-fw"></i> Shutdown Honeypot</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                         <a href="comments.php"><i class="fa fa fa-comments-o fa-fw"></i> Comments</a>
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>
          <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"><img src="../images/logo_big.png" width="150" height="130"> Dashboard</h1>
                </div>
                <!-- /.col-lg-12 -->
            <div class="col-lg-12">
              <?php if($_GET["task"]==1) : ?>
                <div class="alert alert-success alert-dismissable fade in">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true" aria-label="close">&times;</button>
                    Comment successfully added.
                </div>
                <?php elseif($_GET["task"]==2) : ?>
                <div class="alert alert-danger alert-dismissable fade in">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true" aria-label="close">&times;</button>
                    Comment adding failed. Please refer to logs.
                </div>
                <?php endif ?>
              </div>
         <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-connectdevelop fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $row2['Tasks']; ?></div>
                                    <div>Honeypots Online!</div>
                                </div>
                            </div>
                        </div>
                        <a href="destroytask.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            <div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-comments-o  fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <form role="form" action="commentadd.php" method="post">
                                    <div class="form-group" style="margin-bottom:13px">
                                    <input class="form-control" placeholder="Add a comment" value="" name="comment" style="height:20%">
                                    </div>
                                    <button type="submit" class="btn btn-default btn-block" style="height:20%">Submit</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <a>
                            <div class="panel-footer">
                                <span class="pull-left">View Below</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-down"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-file-text-o fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $noofhoney ?></div>
                                    <div>Playbooks Available</div>
                                </div>
                            </div>
                        </div>
                        <a>
                            <div class="panel-footer">
                                <span class="pull-left">View Below</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-down"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-tasks fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $row['Tasks']; ?></div>
                                    <div>Completed Tasks</div>
                                </div>
                            </div>
                        </div>
                        <a href="completedtasks.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                </div>
            <div class="row">
                <!-- /.col-lg-6 -->
                <div class="col-lg-6">
                <div class="panel panel-default">
                        <div class="panel-heading">
                            Timeline of Events
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                        <div id="chartContainer" style="height: 350px ; width: 100%;">
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                </div>
                 <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Playbooks Available!
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div id="morris"></div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <div class="col-lg-12">
                <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa fa-bell-o fa-fw"></i> Recent Comments
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <ul class="timeline">
                                <?php 
                                for ($r=sizeof($row4)-1; $r>=0;$r--){
                                        if ($r%2!=0){?>
                                    <li class="timeline">
                                        <div class="timeline-badge success"><i class="fa fa fa-exclamation"></i>
                                        </div>
                                    <div class="timeline-panel">
                                        <div class="timeline-heading">
                                            <h4 class="timeline-title">Comment by: <?php echo $row4[$r][0] ?></h4>
                                            <p><small class="text-muted"><i class="fa fa-clock-o"></i> <?php print $row4[$r][1] ?> hours ago</small>
                                            </p>
                                        </div>
                                        <div class="timeline-body">
                                            <p><?php echo $row4[$r][2]?></p>
                                        </div>
                                    </div>
                                </li> 
                                        <?php } else{?>
                                
                                <li class="timeline-inverted">
                                        <div class="timeline-badge success"><i class="fa fa fa-exclamation"></i>
                                        </div>
                                    <div class="timeline-panel">
                                        <div class="timeline-heading">
                                            <h4 class="timeline-title">Comment by: <?php echo $row4[$r][0] ?></h4>
                                            <p><small class="text-muted"><i class="fa fa-clock-o"></i> <?php echo $row4[$r][1] ?> hours ago</small>
                                            </p>
                                        </div>
                                        <div class="timeline-body">
                                            <p><?php echo $row4[$r][2]?></p>
                                        </div>
                                    </div>
                                </li> 
                                
                                
                                <?php }    
                                } ?>
                            </ul>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
            </div> 
            <!-- Row -->
        </div>
        <!-- Page Wrapper -->
    </div>
    <!-- Wrapper End -->
    
    <!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="../vendor/raphael/raphael.min.js"></script>
    <script src="../vendor/morrisjs/morris.min.js"></script>
    
    <!--Canvas JS MIN-->
    <script src="../dist/js/canvasjs.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>
        
    <script>
    Morris.Donut({
    element: 'morris',
    data: [
        <?php
             $output = shell_exec("sudo ls /home/honeypots/");
             $honeypots = preg_split("#[\r\n]+#", $output);
             for ($i=0;$i<sizeof($honeypots)-1;$i++){
                                            ?>              
        {label:"<?php echo strtoupper($honeypots[$i])?>", value: 1},
         <?php
           }
         ?>
    ]
});    
    </script>
</body>
</html>