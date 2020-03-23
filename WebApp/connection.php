<?php

try {
        $pdo = new PDO('mysql:host=localhost;port=3306;dbname=networking_project', 'dgupta3', 'abcd1234');
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
