<?php




if (isset($_SERVER['HTTP_HOST']))
{
    if($_SERVER['HTTP_HOST'] == "localhost")
    {
    	try {
			$pdo = new PDO('mysql:host=localhost;port=3306;dbname=networking_project', 'newuser', 'password');
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			// echo "localhost";
		}catch(PDOException $e) {		echo 'Connection failed: ' . $e->getMessage();	}
    }
    else
    {
    	try {
        $pdo = new PDO('mysql:host=aadpq5p4cixao6.cncrlycnpzwi.us-east-2.rds.amazonaws.com;port=3306;dbname=networking_project', 'root', 'abcd1234');
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		echo $_SERVER['HTTP_HOST'];
		} catch(PDOException $e){	echo 'Connection failed: ' . $e->getMessage();	}
    }
}


?>
