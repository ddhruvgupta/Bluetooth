<?php 
if(isset($_SESSION['insert']) ){
	$error =  "<div class='col-md-4 col-md-offset-5'><p class='text-success'>".$_SESSION['insert']."</p></div></br>";
	unset($_SESSION['insert']);
}

if(isset($_SESSION['error']) ){
	$error =  "<div class='col-md-4 col-md-offset-5'><p class='text-danger'>".$_SESSION['error']."</p></div></br>";
	unset($_SESSION['error']);
}

?>