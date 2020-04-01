<?php
session_start();
include "./utils/bootstrap.php";
include "./utils/connection.php";
include "./utils/emailVerification.php";
// include "navbar.php";
// include "utils/bootstrap_js.php";


  //If insert if successful

if(isset($_POST['cancel'])){
  header("location: index.php");
  return;
}

if(isset($_POST['add']) ){


  $sql="insert into users( fname, lname, email, password,role, hash)
  values (:fname,:lname,:email,:password,:role, :hash)";


  $salt = "XyZzy12*_";
  $check = hash('md5', $salt.$_POST['pass1']);
  $email = $_POST['email'];
  $role = checkRole($email, $pdo);
  $hash = md5( rand(0,1000) );

  if($role == "invalid"){
    
    header("location: ./new_user.php");
    return;
  }

  emailVerify($email, $hash);

  
  $statement = $pdo->prepare($sql);
  $statement->execute(
    array(
      ':fname'=> $_POST['firstName'],
       ':lname'=> $_POST['lastName'],
       ':email'=>$email,
       ':password'=>$check, 
       ':role'=>$role,
       ':hash'=>$hash
    )
  );

  $_SESSION['insert'] = "New User Successfully Created - Please verify by Email";
  
  header("location: new_user.php");
  return;

}

function checkRole($email, $pdo){

  $sql = "select count(*) as count from users where email = :email";
  $stmt = $pdo->prepare($sql);
  $stmt->execute( array(':email' => $email ));

  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  if($result['count'] > 0){
    error_log(print_r($result, true));
    $_SESSION['error'] = "Email already in Use";
    return "invalid";
  }


  $email_host = array_slice(explode("@", $email), -1)[0];
  if($email_host == "student.gsu.edu"){
    return "student";
  }elseif($email_host == "gsu.edu"){
    return "faculty";
  }else{
    $_SESSION['error'] = "Invalid email address: .gsu emails only";
    return "invalid";

  }
      
}



?>

<html>
<head>
  <link href=" ./css/signin.css" rel="stylesheet">
  <script src="./js/validateNewUser.js"></script>
</head>
<body>

<!-- <div class="container">
  <div class="row"></br></div>
</div> -->

  <div class="container">

    <div class="row">
      <!-- <div class="col-12"></div> -->
      <div class="col">
        <div class="panel panel-default">
          <div class="panel-body"  >
            <form method="POST" class="form-signin">
<?php 

  if(isset($_SESSION['insert']) ){
    echo "<center><p class='text-success'>".$_SESSION['insert']."</p></center>";
    unset($_SESSION['insert']);
  }

  if(isset($_SESSION['error']) ){
    echo "<center><p class='text-danger'>".$_SESSION['error']."</p></center>";
    unset($_SESSION['error']);
  }

?>
              <div class="form-signin">
                <label for="firstName">First Name:</label>
                <input type="text" name="firstName" id="firstName" value="<?php if(isset($first)) echo $first;?>"><br/>
              </div>

              <div class="form-signin">
                <label for="lastName">Last Name:</label>
                <input type="text" name="lastName" id="lastName" value="<?php if(isset($last)) echo $last;?>"><br/>
              </div>

              <div class="form-signin">
                <label for="email">Username:</label>
                <input type="email" name="email" id="email" value="<?php if(isset($email)) {echo $email;}?>"><br/>
              </div>

              <div class="form-signin">
                <label for="pass1">Password:</label>
                <input type="password" name="pass1" id="pass1"><br/>
              </div>



              <div class="form-signin" >
                <input type="submit" name="add" value="Submit" class="btn btn-lg btn-primary btn-block" onclick="if(checkEmail() == false) event.preventDefault();">
                <input type="submit" name="cancel" class="btn btn-lg btn-primary btn-block" value="Cancel">
              </div>

            </form>

          </div>
        </div>
      </div>
    </div>

  </div>

</body>
</html>
