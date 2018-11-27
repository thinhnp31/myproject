<?php 
	session_start();

	require_once "includes/php/_connectdb.php"; 
	require_once "PHPMailer/src/Exception.php";
	require_once "PHPMailer/src/OAuth.php";
	require_once "PHPMailer/src/PHPMailer.php";
	require_once "PHPMailer/src/POP3.php";
	require_once "PHPMailer/src/SMTP.php";

	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	
	if (isset($_POST['submit'])) {		
		$email = $_POST['email'];
		
		$stmt = $conn->prepare("SELECT * FROM admin WHERE email = ?");
		$stmt->bind_param("s", $email);
		$stmt->execute();
		$result = $stmt->get_result();
		if ($result->num_rows > 0) {			
			$password = uniqid();
			$stmt = $conn->prepare("UPDATE admin SET password = ? WHERE email = ?");
			$stmt->bind_param("ss", md5($password), $email);
			$stmt->execute();

			//Sending email :
			
			$mail = new PHPMailer(true);
			$mail->isSMTP();
			$mail->Host = "smtp.gmail.com";
			$mail->SMTPAuth = true;
			$mail->Username = "sictin2018@gmail.com";
			$mail->Password = "aabyrswmtogmxryy";
			$mail->SMTPSecure = "tls";
			$mail->Port = 587;

			$mail->setFrom("sictin2018@gmail.com", "SI CTIN Admin (noreply)");
			$mail->addAddress($email);

			$mail->isHTML(true);
			$mail->Subject = "Khôi phục mật khẩu";
			$mail->Body = "Mật khẩu mới của bạn là : " . $password;
			$mail->send();

			$msg = "Khôi phục mật khẩu thành công. Vui lòng kiểm tra Email";
			$msg_type = "success";
			header("Location: ./login.php?msg=" . $msg ."&msg_type=" . $msg_type);
		} else {
			$msg = "Email không tồn tại";
			$msg_type = "danger";
			header("Location: ./login.php?msg=" . $msg ."&msg_type=" . $msg_type);
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>CTIN PROJECTS</title>
	<meta charset="utf-8">

	<link rel="shortcut icon" type="image/x-icon" href="favicon.ico">

	<link rel="stylesheet" href="includes/css/bootstrap.min.css">
	<script src="includes/js/jquery-3.3.1.min.js"></script>
	<script src="includes/js/popper.min.js"></script>
	<script src="includes/js/bootstrap.min.js"></script>

	
</head>

<body>
	<?php
		require_once "./includes/php/_message.php";
	?>
	<div class="row" style="height: 300px"></div>
	<div class="row">
		<div class="col">
		</div>
		<div class="col border border-primary p-4">
			<div class="text-center"><img src="./includes/images/ctin-logo5.jpg"></div>
			<div class="text-center mt-4"><h3>Khôi phục mật khẩu</h3></div>

			<form method="POST" action="#">
				<div class="form-group">
					<label>Email :</label>
					<input type="text" class="form-control" name="email" required>
				</div>
				<div class="col text-center mt-4">
					<input type="submit" name="submit" class="btn btn-lg btn-success text-white" value="Xác nhận">
				</div>

				
			</form>
		</div>
		<div class="col">
		</div>
	</div>

	<?php 
		require_once "includes/php/_footer.php";
	?>
</body>
</html>

<?php
	$conn->close();
?>