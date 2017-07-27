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
chdir("/home/$honeypot/");
exec("vagrant destroy 2>&1",$msg,$error);
exec("sudo rm -r -f /home/$honeypot/ 2>&1",$msg,$error);

if ($error==1){
    $file = fopen('../logs/errors.log','a+');
   
    for ($i=0;$i<sizeof($msg);$i++){
        fwrite($file,date("D M j H:i:s Y") . ' [:error] ' .$msg[$i].PHP_EOL);
    }
    fclose($file);
    header('Location: destroytask.php?task=2');
}
    
else {
        //Else task if Running is Successful
        $sql = "UPDATE completed_tasks SET honeylive='NO' WHERE ID=$_POST[id]";
    
        if (mysqli_query($db, $sql)) {
            header('Location: destroytask.php?task=1');
        } else {
            header('Location: destroytask.php?task=2');
        }
        mysqli_close($db);

    }
}
else {
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}
?>