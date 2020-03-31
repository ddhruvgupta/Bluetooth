<?php
/*
This webservice will support a get request where it will accept the name of a faculty member and return availability with a time stamp of last available
*/

include "utils/connection.php";



if(isset($_GET['name'])){

	$name = $_GET['name'];

	$available = -1;
	$fname = null;
	$lname = null;
	$email = null;


	if(!empty($_GET['name'])){

	$sql = "SELECT * FROM device WHERE CONCAT( fname,  ' ', lname ) LIKE  :name  ";

	// $sql = "select * from device where fname = 'Dhruv'";


	$sql = "
	Select device.fname, device.lname, device.email, max(ca.availability) as availability, ca.last_modified 
	from current_availability ca join device on device.mac = ca.mac
	WHERE CONCAT( fname,  ' ', lname ) LIKE  :name
	group by device.email
	";

	$stmt = $pdo->prepare($sql);
	$stmt->execute(array(':name' => "%$name%" ));

	// print_r($stmt) ;
	// print_r($name) ;


	// while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
	// print_r ($row);
	// }
	$response = $stmt->fetchAll(PDO::FETCH_ASSOC);
	deliver_response(200,"SUCCESS", $response);
	// echo $row;
}else{
	$response['fname'] = "";
	$response['lname'] = "";
	$response['email'] = "";
	$response['available'] = -1;

	deliver_response(400,"no search string provided", $response);
}

}else{
	//return invalid 
	// echo "string";
	$response['fname'] = "";
	$response['lname'] = "";
	$response['email'] = "";
	$response['available'] = -1;

	deliver_response(400,"invalid request", $response);
	
}


function deliver_response($status, $status_message, $data){
	header("Conent-Type:application/json; charset=UTF-8");
	header("HTTP/1.1 $status $status_message");
	header("Access-Control-Allow-Origin: *");
	header("Access-Control-Max-Age: 3600");

	$response['status'] = $status;
	$response['status_message'] = $status_message;
	$response['data'] = $data;

	$json_response = json_encode($response);
	echo $json_response;

}


?>