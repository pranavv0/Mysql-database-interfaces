<html>
<body>
<?php
   session_start();
   $_SESSION["host"] = $_POST["host"];
   #$_SESSION["host"] = "localhost";
   $_SESSION["port"] = $_POST["port"];
   #$_SESSION["port"] = 5432;
   $_SESSION["dbname"] = $_POST["dbname"];
   #$_SESSION["dbname"] = "postgres";
   $_SESSION["user"] = $_POST["user"];
   #$_SESSION["user"] = "postgres";
   $_SESSION["password"] = $_POST["password"];
   #$_SESSION["password"] = "Deepak@1997";
    $db=pg_connect("host = {$_SESSION["host"]} port = {$_SESSION["port"]} dbname = {$_SESSION["dbname"]} user = {$_SESSION["user"]} password = {$_SESSION["password"]}");
    if(!$db) {
       echo "Authentication failed : Error ";
       echo"<form action = '3.php' method = 'post'>
            <input type='submit' Value='click here to validate again'>
            </form>";
    } else {
       echo "Authentication successfull : Congratulations ";
       echo "<form action = 'as.php' method = 'post'>
                 <input type='submit' Value='click here to proceed'>
                 </form>";
     }
?>
</body>
</html>
