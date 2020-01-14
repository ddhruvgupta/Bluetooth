<?php

$pdo = new PDO('mysql:host=localhost;port=3306;dbname=networking_project', 'newuser', 'password');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

/*
$test_sql = "Select * from current_availability";
$stmt = $pdo->prepare($test_sql);
$stmt->execute();

while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
	print_r ($row);

}

*/
?>
