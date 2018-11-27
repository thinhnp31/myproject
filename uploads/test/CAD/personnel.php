<?php 
	session_start();

	require_once "includes/php/_connectdb.php";
	
	if (!isset($_SESSION['email'])) {
		header("Location: ./login.php");
	}

	if (isset($_GET['submit'])) {
		switch ($_GET['submit']) {
			case 'Thêm':
				$name = $_GET['name'];
				$role = $_GET['role'];
				$email = $_GET['email'];
				$phone = $_GET['phone'];
				if ($role == "engineer") {
					$stmt = $conn->prepare("INSERT INTO engineers(engineer_name, engineer_email, engineer_phone) VALUES(?,?,?)");
					$stmt->bind_param("sss", $name, $email, $phone);
					$stmt->execute();
				} else {
					$stmt = $conn->prepare("INSERT INTO am(am_name, am_email, am_phone) VALUES(?,?,?)");
					$stmt->bind_param("sss", $name, $email, $phone);
					$stmt->execute();
				}
				break;
			case 'Xóa':
				if (isset($_GET['engineer_id'])) {
					$engineer_id = $_GET['engineer_id'];
					$stmt = $conn->prepare("DELETE FROM engineers WHERE engineer_id = ?");
					$stmt->bind_param("i", $engineer_id);
					$stmt->execute();
				} else {
					$am_id = $_GET['am_id'];
					$stmt = $conn->prepare("DELETE FROM am WHERE am_id = ?");
					$stmt->bind_param("i", $am_id);
					$stmt->execute();
				}
			default:
				# code...
				break;
		}
		header("Location: ./personnel.php");
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

	<script>
		$(document).ready(() => {
			$("#form_create_project").hide();
		});
	</script>

</head>

<body>
	<?php 
		require_once "includes/php/_navbar.php";
	?>

	<div class="container">
		<table class="table">
			<thead>
				<tr>
					<th scope="col">Họ và tên</th>
					<th scope="col">Vai trò</th>
					<th scope="col">E-mail</th>
					<th scope="col">Điện thoại</th>
					<th scope="col"></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<form method="GET" action="#">
						<td><input type="text" name="name" class="form-control" required></td>
						<td>
							<select name="role" class="form-control">
								<option value="engineer">Phụ trách kỹ thuật</option>
								<option value="am">Phụ trách kinh doanh</option>
							</select>							
						</td>
						<td><input type="email" name="email" required></td>
						<td><input type="text" pattern="[0][0-9]{9}" title="10 chữ số, bắt đầu bằng số 0" name="phone" required></td>
						<td><input type="submit" class="btn btn-success" name="submit" value="Thêm"></td>
					</form>
				</tr>
				<?php
					$stmt = $conn->prepare("SELECT * FROM engineers");
					$stmt->execute();
					$result = $stmt->get_result();
					if ($result->num_rows > 0) {
						while ($row = $result->fetch_assoc()) {
				?>
							<tr>
								<td><?php echo $row['engineer_name']?></td>
								<td>Phụ trách kỹ thuật</td>
								<td><?php echo $row['engineer_email']?></td>
								<td><?php echo $row['engineer_phone']?></td>
								<td>
									<form method="GET" action="#">
										<input type="hidden" name="engineer_id" value="<?php echo $row['engineer_id']; ?>">
										<input type="submit" class="btn btn-danger" name="submit" value="Xóa">
									</form>
								</td>
							</tr>
				<?php
						}
					}
				?>
				<tr></tr>
				<?php
					$stmt = $conn->prepare("SELECT * FROM am");
					$stmt->execute();
					$result = $stmt->get_result();
					if ($result->num_rows > 0) {
						while ($row = $result->fetch_assoc()) {
				?>
							<tr>
								<td><?php echo $row['am_name']?></td>
								<td>Phụ trách kinh doanh</td>
								<td><?php echo $row['am_email']?></td>
								<td><?php echo $row['am_phone']?></td>
								<td>
									<form method="GET" action="#">
										<input type="hidden" name="am_id" value="<?php echo $row['am_id']; ?>">
										<input type="submit" class="btn btn-danger" name="submit" value="Xóa">
									</form>
								</td>
							</tr>
				<?php
						}
					}
				?>
			</tbody>
		</table>
	</div>

	<?php 
		require_once "includes/php/_footer.php";
	?>

	<script type="text/javascript">
		$("#create_project").click(() => {
			$("#form_create_project").show();
		});
	</script>
</body>
</html>

<?php
	$conn->close();
?>