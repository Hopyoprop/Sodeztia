<?php
session_start();

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '1qwer$#@!');
define('DB_DATABASE', 'tasks');
$db=mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE) or die("Failed to connect to MySQL: " . mysql_error()); 

$output="";
//Run Vagrant and Ansible Commands here
//exec("sudo mkdir -p /home/test");
/*
$output = shell_exec("sudo ls /home/honeypots/");
$oparray = preg_split("#[\r\n]+#", $output);

for ($i=0;$i<sizeof($oparray)-1;$i++){
    echo "$oparray[$i] <br>";
}
*/
    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        
        $sql = "INSERT INTO completed_tasks (nameoftask, user, taskexecutedtime,playbook_selected,comments,honeylive) VALUES ('$_POST[jobname]','$_SESSION[username]', NOW(),'$_POST[playbook]','$_POST[comments]','YES')";
    
        if (mysqli_query($db, $sql)) {
            header('Location: schedule.php?task=1');
        } else {
            header('Location: schedule.php?task=2');
        }
        mysqli_close($db);


    }
?>