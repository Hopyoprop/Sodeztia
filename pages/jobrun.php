<?php
session_start();

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '1qwer$#@!');
define('DB_DATABASE', 'tasks');
$db=mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE) or die("Failed to connect to MySQL: " . mysql_error()); 

$output="";
//Run Vagrant and Ansible Commands here
/*$output = shell_exec('ls -la');

echo "<pre>$output</pre>";
*/


//if(!empty($output)){ Remove for now till integrate with backend
    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        
        if ($_POST["servergroup"]=="-"){
            $server=$_POST["serverindividual"];
        }
        else if ($_POST["serverindividual"]=="-"){
            $server=$_POST["servergroup"];
        }
        else {
            $server=$_POST["servergroup"];
        }
        
        $sql = "INSERT INTO completed_tasks (nameoftask, user, taskexecutedtime,server_selected,playbook_selected,comments) VALUES ('$_POST[jobname]','$_SESSION[username]', NOW(),'$server','$_POST[playbook]','$_POST[comments]')";
    
        if (mysqli_query($db, $sql)) {
            header('Location: schedule.php?task=1');
        } else {
            header('Location: schedule.php?task=2');
        }
        mysqli_close($db);


    }
//}
?>