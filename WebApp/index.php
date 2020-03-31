<?php
session_start();

  if(!isset($_SESSION['success'])){
    header("location: utils/login.php");
    return;
  }


  if($_SESSION['role']=='admin'){
  	$list = "
	<ul>
		<li><a href='viewDevices.php'>View All Devices</a></li>
		<li><a href='add.php'>Add a new device to track</a></li>
		<li><a href='view.php'>View Faculty Availability</a></li>
	</ul>
  	";
  }elseif ($_SESSION['role']=='student') {
  	$list = "
	<ul>
		<li><a href='view.php'>View Faculty Availability</a></li>
	</ul>
  	";
  }elseif ($_SESSION['role']=='faculty') {
  	$list = "
  	<ul>
    <li><a href='viewDevices.php'>View All Devices</a></li>
		<li><a href='add.php'>Add a new device to track</a></li>
		<li><a href='view.php'>View Faculty Availability</a></li>
	</ul>
  	";
	}

?>

<html>
<body>
 <?php  
 echo($list); 
  echo("<a href='utils/logout.php'>LOGOUT</a>");
 ?>
</body>
</html>