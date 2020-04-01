<?php

// session_start();

	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;

function emailVerify($email, $hash){



	require_once('C:\xampp\htdocs\projects\bluetooth\PHPMailer\PHPMailer.php');
	require_once('C:\xampp\htdocs\projects\bluetooth\PHPMailer\SMTP.php');
	require_once('C:\xampp\htdocs\projects\bluetooth\PHPMailer\Exception.php');



echo (extension_loaded('openssl')?'SSL loaded':'SSL not loaded')."\n";

$mail = new PHPMailer(true);

try{
$mail->SMTPDebug = SMTP::DEBUG_SERVER;
$mail->SMTPOptions = array(
                  'ssl' => array(
                      'verify_peer' => false,
                      'verify_peer_name' => false,
                      'allow_self_signed' => true
                  )
              );
$mail->isSMTP();
$mail->Host = gethostbyname('smtp.gmail.com');
$mail->SMTPAuth = true;
$mail->SMTPSecure = "tls";
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->Port = 587;
$mail->Username = "bluetooth.project.test@gmail.com";
$mail->Password = "Welcome1234!";
$mail->Subject = "Account Verification";
$mail->setFrom("bluetooth.project.test@gmail.com");
$mail->Body = ($_SESSION['root']."/utils/verify?key=".$hash."&email=".$email);
$mail->addAddress($email);

if ($mail->Send()){
	echo "success";
}else{
	echo "failure\n";
	// print_r($mail);
}

$mail->smtpClose();
}catch (phpmailerException $e) {
    $errors[] = $e->errorMessage(); //Pretty error messages from PHPMailer
} catch (Exception $e) {
    $errors[] = $e->getMessage(); //Boring error messages from anything else!
}


}


?>