<?php

if (isset($_SERVER['HTTP_HOST']))
{
    if($_SERVER['HTTP_HOST'] == "localhost")
    {
        $root =  realpath($_SERVER["CONTEXT_DOCUMENT_ROOT"]);
        define("ROOT",$root."/WebApp");
        $root = ROOT;

try {
        $pdo = new PDO('mysql:host=localhost;port=3306;dbname=aa11m73hlheg2u6', 'dgupta3', 'Welcome1!');
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}


        // include "connection.php";
        // include "test.php";
        // $_SESSION['displ'] = 1;

    }
    else
    {

    	try {
        	$pdo = new PDO('mysql:host=localhost;port=3306;dbname=aa11m73hlheg2u6', 'dgupta3', 'Welcome1!');
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (PDOException $e) {
    		echo 'Connection failed: ' . $e->getMessage();
		}

    }
}else{
	
	$pdo = new PDO('mysql:host=localhost;port=3306;dbname=aa11m73hlheg2u6', 'dgupta3', 'Welcome1!');
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

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
