<?php
/*
This webservice will support a POST request from a raspberry pi and reply with an updated list of mac addresses to check.


*/

//include "utils/connection.php";


// process data in the post
// will contain a dictionary {'MAC': 1 / 0}
if(isset($_POST['data'])){

	$data = $_POST['data'];
	$response = 1;
	echo "$data";
	deliver_response(200,"SUCCESS", $response);

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