<?php 
	
	if (!isset($_SESSION['email'])) {
		header("Location: ./login.php");
	}
	
	require_once "PHPMailer/src/Exception.php";
	require_once "PHPMailer/src/OAuth.php";
	require_once "PHPMailer/src/PHPMailer.php";
	require_once "PHPMailer/src/POP3.php";
	require_once "PHPMailer/src/SMTP.php";

	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	$mail = new PHPMailer(true);
		$mail->isSMTP();
		$mail->Host = "smtp.gmail.com";
		$mail->SMTPAuth = true;
		$mail->Username = "sictin2018@gmail.com";
		$mail->Password = "aabyrswmtogmxryy";
		$mail->SMTPSecure = "tls";
		$mail->Port = 587;

		$mail->setFrom("sictin2018@gmail.com", "SI CTIN Admin (noreply)");
		$mail->addAddress("phuthinhbk31@gmail.com");

		$mail->isHTML(true);
		$mail->Subject = "test";
		$mail->Body = "This email is for testing purpose";
		$mail->send();
		echo "Mail sent!";
	
?>