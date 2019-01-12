<?php 
	session_start();

	require_once "includes/php/_connectdb.php";

	if (isset($_SESSION['email']))
		header("Location: ./index.php");

	if (isset($_POST['submit'])) {
		$email = $_POST['email'];
		$password = md5($_POST['password']);
		$stmt = $conn->prepare("SELECT * FROM admin WHERE email = ? AND password = ?");
		$stmt->bind_param("ss", $email, $password);
		$stmt->execute();
		$result = $stmt->get_result();
		if ($result->num_rows > 0) {
			$_SESSION['email'] = $email;
			header("Location: ./index.php");
		} else {
			$msg = "Thông tin đăng nhập không đúng";
			$msg_type = "danger";
		}
	} else {
		if (isset($_GET['msg'])) {
			$msg = $_GET['msg'];
			$msg_type = $_GET['msg_type'];
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
			<div class="text-center mt-4"><h3>Đăng nhập</h3></div>
			<form method="POST" action="#">
				<div class="form-group">
					<label>Email :</label>
					<input type="email" class="form-control" name="email" required>
				</div>
				<div class="form-group">
					<label>Mật khẩu :</label>
					<input type="password" class="form-control" name="password" required>
				</div>
				<div class="form-row">
					<a href="password_recovery.php">Quên mật khẩu?</a>
				</div>
				<div class="form-row mt-4">
					<div class="col text-center">
						<input type="submit" class="btn btn-lg btn-primary" name="submit" value="Đăng nhập">
					</div>
					<div class="col text-center">
						<a class="btn btn-lg btn-success text-white" href="signup.php">Đăng ký</a>
					</div>
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
