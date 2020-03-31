<?php


  function check($username, $pass){
    include "connection.php";
    $salt = 'XyZzy12*_';

    $check = hash('md5', $salt.$pass);
    $stmt = $pdo->prepare('SELECT * FROM users WHERE email = :em AND password = :pw AND active = 1');
    $stmt->execute(array( ':em' => $username, ':pw' => $check));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if($row===false){
      return(0);
    } else {
      $_SESSION['fname'] = $row['fname'];
      $_SESSION['lname'] = $row['lname'];
      $_SESSION['email'] = $row['email'];
      $_SESSION['role'] = $row['role'];
      return(1);
    };

  }
?>
