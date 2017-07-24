<?php 
session_start();

   define('DB_SERVER', 'localhost');
   define('DB_USERNAME', 'root');
   define('DB_PASSWORD', '1qwer$#@!');
   define('DB_DATABASE', 'tasks');
   $db=mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE) or die("Failed to connect to MySQL: " . mysql_error()); 

    $valid=0;

    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        $_SESSION["authErr"]="";
        if (empty($_POST["username"])){
           $_SESSION["nameErr"] = "Username is required";
           $_SESSION["username"] = $_POST["username"];
           $_SESSION["authErr"]="";
            header('Location: login.php');
        }else {
            $_SESSION["nameErr"] = "";
            $_SESSION["username"] = test_input($_POST["username"]);
            $valid++;
        }
        if (empty($_POST["password"])){
            $_SESSION["passErr"] = "Password is required";
            $_SESSION["password"] = $_POST["password"];
            $_SESSION["authErr"]="";
            header('Location: login.php');

        }else {
            $_SESSION["passErr"] = "";
            $_SESSION["password"] = test_input($_POST["password"]);
            $valid++;
        }
    }


      $sql = "SELECT ID FROM users WHERE name = '$_SESSION[username]' and password = '$_SESSION[password]'";
      $result = mysqli_query($db,$sql);
      $row = mysqli_fetch_array($result,MYSQLI_ASSOC);

     $count = mysqli_num_rows($result);    

    if($count == 1 && $valid==2) {
        $_SESSION["password"]="";
        header('Location: index.php');
      }else{
         mysqli_close($db);
         $_SESSION["authErr"] = "Your Login Name or Password is invalid";
         header('Location: login.php');
      }

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
?>