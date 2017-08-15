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
    //Else task if Running is Successful
    $sql = "INSERT INTO comments VALUES ('$_SESSION[username]','$_POST[comment]',NOW())";
    
    if (mysqli_query($db, $sql)) {
        header('Location: index.php?task=1');
    } else {
        header('Location: index.php?task=2');
    }
    mysqli_close($db);

}else {
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}
?>