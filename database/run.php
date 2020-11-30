<html>
<body>
<?php
session_start();
$want=$_POST["want"];
$sql = $_POST["sql"];
$db=pg_connect("host = {$_SESSION["host"]} port = {$_SESSION["port"]} dbname = {$_SESSION["dbname"]} user = {$_SESSION["user"]} password = {$_SESSION["password"]}");
$ret = pg_query($db, $sql);
if($want==1) {
if(!$ret) {
      echo pg_last_error($db);
   } else {
      echo "Table created successfully\n";
   }
}

if($want==2) {
if(!$ret) {
      echo pg_last_error($db);
   } else {
      echo "Records created successfully\n";
   }
}

if($want==3) {
if(!$ret) {
      echo pg_last_error($db);
      exit;
   } 
  $arr = pg_fetch_all($ret);
  foreach($arr[0] as $y => $y_value) {
    echo "<strong><strong><i>$y</i></strong></strong>";
    echo"&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp";
  }
  echo "<br><br><br>";
  $num=(count($arr[0]));
  while($row = pg_fetch_row($ret)) {
    for ($x = 0; $x < $num; $x++) {
      echo $row[$x];
      echo"&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp";
    }
    echo "<br>";
  } 
}

if($want==4) {
if(!$ret) {
      echo pg_last_error($db);
      exit;
   } else {
      echo "Record updated successfully\n";
   }
}
if($want==5) {
if(!$ret) {
      echo pg_last_error($db);
      exit;
   } else {
      echo "Record deleted successfully\n";
   }
}
$want=0;
?>
<form action="run.php" method="post">
  <br><br><br><h2> Enter what to do next : </h2>
  <input type="radio" name="next" value="1">Perform Next Operation<br>
  <input type="radio" name="next" value="2">Quit theSession"<br><br>
  <input type="submit" value="submit">
</form>
<?php
   $next=$_POST["next"];
   if($next==1) {
    echo"<form action='as.php' method='post'>
           <input type='submit' value='Click here to enter query'>
         </form>";
   }
   if($next==2) {
           session_unset();
           session_destroy();
           echo " You are signed off";
           echo "Please close the current tab for security reason";
   }
?>
</html>
</body>