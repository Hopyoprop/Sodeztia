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

exec("sudo cp -a /home/honeypots/$honeypot /home/$honeypot");
chdir("/home/$honeypot/");
exec("sudo vagrant up --provision 2>&1",$msg,$error);

if ($error==1){
    $file = fopen('../logs/errors.log','a+');
   
    for ($i=0;$i<sizeof($msg);$i++){
        fwrite($file,date("D M j H:i:s Y") . ' [:error] ' .$msg[$i].PHP_EOL);
    }
    fclose($file);
    header('Location: schedule.php?task=2');
}
else {
        $id = mt_rand(0,mt_getrandmax());
        //Else task if Running is Successful
        $sql = "INSERT INTO completed_tasks (id,nameoftask, user, taskexecutedtime,playbook_selected,comments,honeylive) VALUES ($id,'$_POST[jobname]','$_SESSION[username]', NOW(),'$_POST[playbook]','$_POST[comments]','YES')";
    
        if (mysqli_query($db, $sql)) {
            header('Location: schedule.php?task=1');
        } else {
            header('Location: schedule.php?task=2');
        }
        mysqli_close($db);

    }
}else {
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}
?>