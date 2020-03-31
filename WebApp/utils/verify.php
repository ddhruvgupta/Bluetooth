<?php 

include "connection.php";

if (isset($_GET['key']) && isset($_GET['email'])){
	$hash = $_GET['key'];
	$email = $_GET['email'];

	$sql = "select hash from users where email = :email";
	$statement = $pdo->prepare($sql);
	$statement->execute(array(':email'=>$email));

	$res = $statement->fetch(PDO::FETCH_ASSOC);

	if(isset($res['hash']) && $res['hash'] == $hash){
		$sql = "update users set active = 1 where email = :email";
		$statement = $pdo->prepare($sql);
		$statement->execute(array(':email'=>$email));
		header("location: ../index.php");
		return;
	}

}else{
	echo "string";
	echo "<script>window.close();</script>";
}

?>