<?php

try {
        $pdo = new PDO('mysql:host=aadpq5p4cixao6.cncrlycnpzwi.us-east-2.rds.amazonaws.com;port=3306;dbname=networking_project', 'root', 'abcd1234');
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}



/*
$test_sql = "Select * from current_availability";
$stmt = $pdo->prepare($test_sql);
$stmt->execute();

while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
	print_r ($row);

}

*/
?>
