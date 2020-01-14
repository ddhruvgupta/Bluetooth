<?php 
session_start();
include "connection.php";
include "flashMessages.php";
include "bootstrap.php";


function validateMac($mac)
{
	return (preg_match('/([a-fA-F0-9]{2}[:|\-]?){6}/', $mac) == 1);
}

function validateEmail($email){
	if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
		return 1;
	}else 
	return 0;
}


function validateInput(){
	if(validateEmail($_POST['email'])==1 && validateMac($_POST['mac'])==1)
		return 1;
	else{
		$_SESSION['error'] = "Please check your input - Invalid Email / MAC Address";
		return 0;
	} 
}



if(isset($_POST['add'])){

	if(validateInput()==1){
		$sql = "insert into device (fname,lname,device_name,mac,email) values (:fname,:lname,:dname,:mac,:email)";
		$stmt = $pdo->prepare($sql);
		$stmt->execute( array(':fname'=>$_POST['fname'],':lname'=>$_POST['lname'],':dname'=>$_POST['dname'],':mac'=>$_POST['mac'],':email'=>$_POST['email']  )	);

		$sql = "insert into current_availability (mac) values (:mac)";
		$stmt = $pdo->prepare($sql);
		$stmt->execute( array(':mac'=>$_POST['mac']));

		$_SESSION['insert'] = 'Successfully Added';

	}else{
		header('location: add.php');
		return;
	}
	
}

if(isset($_POST['cancel'])){
	header('location: index.php');
		return;
}

?>

<html>
<head>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="macEdit.js"></script>
	
</head>
<body>
	<?php if(isset($error)) echo $error; ?>
	<div class="container">
		<center><h1>Enter New Device Details</h1></center>
		<form method="POST">
			<table class='table table-striped table-bordered' id='term-view'>
				<tbody>
					<tr>
						<td><label for="fname">First Name:</label></td>
						<td><input type="text" name="fname"></td>
					</tr>

					<tr>
						<td><label for="lname">Last Name:</label></td>
						<td><input type="text" name="lname"></td>
					</tr>

					<tr>
						<td><label for="lname">Device Name:</label></td>
						<td><input type="text" name="dname"></td>
					</tr>

					<tr>
						<td><label for="fname">Bluetooth Address:</label></td>
						<td><input type="text" name="mac" id="mac" maxlength="17" onkeyup="doInsert(this)"></td>
					</tr>

					<tr>
						<td><label for="fname">Email Address:</label></td>
						<td><input type="text" name="email"></td>
					</tr>


				</tbody>
			</table>



			<center>
				<input type="submit" name="add" value="Add">
				<input type="submit" name="cancel" value="Cancel">
			</center>
		</form>
	</div>
</body>
</html>
