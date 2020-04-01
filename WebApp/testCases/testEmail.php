<?php
session_start();

try{
	if($_SERVER['HTTP_HOST'] == "localhost"){
	$_SESSION['root'] =  $_SERVER['HTTP_HOST']."/projects/bluetooth";
}else{
	$_SESSION['root'] =  $_SERVER['HTTP_HOST']."/WebApp";
}



include "../utils/emailVerification.php";
emailVerify("bluetooth.project.test@gmail.com", 1);
}catch(Exception $e) {
    $errors[] = $e->getMessage(); //Boring error messages from anything else!
    print_r($errors);
}


?>