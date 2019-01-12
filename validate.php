<?php 
	session_start();

	require_once "includes/php/_connectdb.php"; 
	
	if (isset($_POST['submit'])) {		
		$confirmed_code = $_POST['confirmed_code'];
		$email = $_POST['email'];
		$stmt = $conn->prepare("SELECT * FROM code WHERE email = ?");
		$stmt->bind_param("s", $email);
		$stmt->execute();
		$result = $stmt->get_result();
		$row = $result->fetch_assoc();
		$password = $row['password'];
		$code = $row['code'];
		if ($code == $confirmed_code) {
			$stmt = $conn->prepare("INSERT INTO admin (email, password) VALUES (?, ?)");
			$stmt->bind_param("ss", $email, $password);
			$stmt->execute();

			$stmt = $conn->prepare("DELETE FROM code WHERE email = ?");
			$stmt->bind_param("s", $email);
			$stmt->execute();
			header("Location: login.php?msg=Đăng ký thành công&msg_type=success");
		} else {
			$msg = "Code không đúng";
			$msg_type = "danger";
			$stmt = $conn->prepare("DELETE FROM code WHERE email = ?");
			$stmt->bind_param("s", $email);
			$stmt->execute();
			header("Location: login.php?msg=".$msg."&msg_type=".$msg_type);
		}
	} else {
		$email = $_GET['email'];
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
			<div class="text-center mt-4"><h3>Xác nhận</h3></div>

			<div class="text-center mt-4">Vui lòng nhập mã xác nhận mà chúng tôi đã gửi qua Email của bạn.</div>

			<form method="POST" action="#">
				<div class="form-group">
					<label>Code :</label>
					<input type="text" class="form-control" name="confirmed_code" required>
				</div>
				<input type="hidden" name="email" value="<?php echo $email?>">
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