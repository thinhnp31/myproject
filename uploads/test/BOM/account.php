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
		$email = $_SESSION['email'];		
		$current_password = md5($_POST['current_password']);
		$stmt = $conn->prepare("SELECT * FROM admin WHERE email = ? AND password = ?");
		$stmt->bind_param("ss",$email, $current_password);
		$stmt->execute();
		$result = $stmt->get_result();
		if ($result->num_rows > 0) {			
			$password = md5($_POST['password']);
			$stmt = $conn->prepare("UPDATE admin SET password = ? WHERE email = ? ");
			$stmt->bind_param("ss", $password, $email);
			$stmt->execute();
			$msg = "Đổi mật khẩu thành công";
			$msg_type = "success";
		} else {
			$msg = "Mật khẩu hiện tại không đúng";
			$msg_type = "danger";
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
		require_once "./includes/php/_navbar.php";
		require_once "./includes/php/_message.php";
	?>
	<div class="row" style="height: 300px"></div>
	<div class="row">
		<div class="col">
		</div>
		<div class="col border border-primary p-4">
			<div class="text-center"><img src="./includes/images/ctin-logo5.jpg"></div>
			<div class="text-center mt-4"><h3>Đổi mật khẩu</h3></div>

			<form method="POST" action="#" onsubmit="return form_validate()">
				<div class="form-group mt-4">
					<label>Mật khẩu hiện tại :</label>
					<input type="password" class="form-control" name="current_password" required>
				</div>

				<div class="form-group">
					<label>Mật khẩu :</label>
					<input type="password" class="form-control" name="password" id="password" required>
					<small class="form-text text-muted">Ít nhất 8 ký tự</small>
				</div>
				<div class="form-group">
					<label>Nhập lại mật khẩu :</label>
					<input type="password" class="form-control" id="confirmed_password" required>
				</div>	
				<small id="passwordHelper" class="form-text text-danger"></small>

				<div class="col text-center mt-4">
					<button type="submit" class="btn btn-lg btn-primary text-white" name="submit">Đổi mật khẩu</button>
				</div>

				
			</form>
		</div>
		<div class="col">
		</div>
	</div>

	<?php 
		require_once "includes/php/_footer.php";
	?>
	
	<script type="text/javascript">
		form_validate = function() {
			let password = $("#password").val();
			let confirmed_password = $("#confirmed_password").val();
			if (password.length < 8) {
				$("#passwordHelper").html("Độ dài mật khẩu không đủ");
				$("#password").addClass("border");
				$("#password").addClass("border-danger");
				return false;
			} else {			
				if (password != confirmed_password) {
					$("#passwordHelper").html("Mật khẩu không khớp");
					$("#password").addClass("border");
					$("#password").addClass("border-danger");
					$("#confirmed_password").addClass("border");
					$("#confirmed_password").addClass("border-danger");
					return false;
				}
				else {
					return true;
				}
			}
		}
	</script>
</body>
</html>

<?php
	$conn->close();
?>