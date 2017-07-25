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

exec("sudo cp -a /home/honeypots/$honeypot /home/$honeypot");
exec("sudo vagrant up --provision",$msg,$error);

if ($error==1){
    header('Location: schedule.php?task=2');
}
else {
        //Else task if Running is Successful
        $sql = "INSERT INTO completed_tasks (nameoftask, user, taskexecutedtime,playbook_selected,comments,honeylive) VALUES ('$_POST[jobname]','$_SESSION[username]', NOW(),'$honeypot','$_POST[comments]','YES')";
    
        if (mysqli_query($db, $sql)) {
            header('Location: schedule.php?task=1');
        } else {
            header('Location: schedule.php?task=2');
        }
        mysqli_close($db);

    }
}
?>