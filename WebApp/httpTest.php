<?php
/*
This webservice will support a POST request from a raspberry pi and reply with an updated list of mac addresses to check.


*/

include "utils/connection.php";


// process data in the post
// will contain a dictionary {'MAC': 1 / 0}



if(isset($_POST['data'])){

	$sql = "SELECT mac FROM device"; 
	$stmt = $pdo->prepare($sql);
	$stmt->execute();
	$out = array();
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		array_push($out, $row["mac"]);
		//echo $row["mac"];
	}
	
	$result = json_encode($out);
	//print_r($result);
	deliver_response(200,"SUCCESS", $out);

	$data = json_decode($_POST['data'], true);
	updateMac($data);	

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

function updateMac($mac_array){
	include "utils/connection.php";
	// print_r($mac_array);

	if (is_array($mac_array) || is_object($mac_array))
	{
		foreach ($mac_array as $key => $value){
			
			//=============== Update Availability Information ===========================
			$sql = "update current_availability set availability=:avail where mac = :mac";
			$stmt = $pdo->prepare($sql);
			$stmt->execute(array(':avail'=>$value,':mac' => $key ));
			
			//=============== Update Log Information ===========================
			$sql = "insert into logs (mac,availability) values (:mac, :avail)";
			$stmt = $pdo->prepare($sql);
			$stmt->execute(array(':avail'=>$value,':mac' => $key ));


		}
	}



}


?>