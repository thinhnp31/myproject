<?php 
session_start();

require_once "includes/php/_connectdb.php";

if (!isset($_SESSION['email'])) {
	header("Location: ./login.php");
}

if (isset($_GET['submit'])) {
	switch ($_GET['submit']) {
		case 'Tạo':
		$project_name = $_GET['project_name'];
		$engineer_name = $_GET['engineer_name'];
		$am_name = $_GET['am_name'];
		$category = $_GET['category'];
		$location = $_GET['location'];
		$customer = $_GET['customer'];
		$now = date("d-m-Y");
		$history = $now . " : Tạo dự án";
		$stmt = $conn->prepare("INSERT INTO projects(project_name, engineer_name, am_name, history, category, location, created_by, customer) VALUES(?, ?, ?, ?, ?, ?, ?, ?) ");
		$stmt->bind_param("ssssssss", $project_name, $engineer_name, $am_name, $history, $category, $location, $_SESSION['email'], $customer);
		$stmt->execute();

		$stmt = $conn->prepare("SELECT * FROM categories WHERE category = ?");
		$stmt->bind_param("s", $category);
		$stmt->execute();			
		$result = $stmt->get_result();
		if ($result->num_rows <= 0) {
			$stmt = $conn->prepare("INSERT INTO categories(category) VALUES(?) ");
			$stmt->bind_param("s", $category);
			$stmt->execute();
		}

		$stmt = $conn->prepare("SELECT * FROM locations WHERE location = ?");
		$stmt->bind_param("s", $location);
		$stmt->execute();			
		$result = $stmt->get_result();
		if ($result->num_rows <= 0) {
			$stmt = $conn->prepare("INSERT INTO locations(location) VALUES(?) ");
			$stmt->bind_param("s", $location);
			$stmt->execute();
		}

		$stmt = $conn->prepare("SELECT * FROM customers WHERE customer = ?");
		$stmt->bind_param("s", $customer);
		$stmt->execute();			
		$result = $stmt->get_result();
		if ($result->num_rows <= 0) {
			$stmt = $conn->prepare("INSERT INTO customers(customer) VALUES(?) ");
			$stmt->bind_param("s", $customer);
			$stmt->execute();
		}

		break;					
		default:
				# code...
		break;
	}
	header("Location: ./projects.php");
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>CTIN PROJECTS</title>
	<meta charset="utf-8">

	<link rel="shortcut icon" type="image/x-icon" href="favicon.ico">

	<link rel="stylesheet" href="includes/css/bootstrap.min.css">
	<link rel="stylesheet" href="includes/css/toggle.css">
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
		<div class="row">
			<div class="col-lg-10" id="col_projects">
				<table class="table">
					<thead>
						<tr>
							<th>#</th>
							<th>Tên dự án</th>
							<th>PT Kỹ thuật</th>
							<th>PT Kinh Doanh</th>
							<th>Nhóm</th>
							<th></th>
						</tr>						
					</thead>

					<tbody>
						<?php
						$stmt = $conn->prepare("SELECT * FROM projects ORDER BY project_id DESC");
						$stmt->execute();
						$result = $stmt->get_result();
						if ($result->num_rows > 0) {
							while ($row = $result->fetch_assoc()) {
								?>
								<tr>
									<td><?php echo $row['project_id'];?></td>
									<td><?php echo $row['project_name'];?></td>
									<td><?php echo $row['engineer_name'];?></td>
									<td><?php echo $row['am_name'];?></td>
									<td><?php echo $row['category'];?></td>
									<td>
										<form method="GET" action="./project_detail.php">
											<input type="hidden" name="project_id" value="<?php echo $row['project_id'];?>">
											<input type="submit" name="submit" class="btn btn-primary" value="Chi tiết">
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

			<div class="col-lg-2" id="col_create_project">
				<div class="text-right"><button id="create_project" class="btn btn-success mt-4">Tạo dự án</button></div>
				<form id="form_create_project" method="GET" action="#" class="mt-4">
					<div class="form-group">
						<label>Tên dự án :</label>
						<input type="text" class="form-control" name="project_name" required>
					</div>
					<div class="form-group">
						<label>Phụ trách kỹ thuật :</label>
						<select name="engineer_name" class="form-control">
							<?php
							$stmt = $conn->prepare("SELECT * FROM engineers");
							$stmt->execute();
							$result = $stmt->get_result();
							if ($result->num_rows > 0) {
								while ($row = $result->fetch_assoc()) {
									?>
									<option value="<?php echo $row['engineer_name'];?>"><?php echo $row['engineer_name'];?></option>
									<?php
								}
							}
							?>
							<option value="Không rõ">Không rõ</option>
						</select>
					</div>
					<div class="form-group">
						<label>Phụ trách kinh doanh :</label>
						<select name="am_name" class="form-control">
							<?php
							$stmt = $conn->prepare("SELECT * FROM am");
							$stmt->execute();
							$result = $stmt->get_result();
							if ($result->num_rows > 0) {
								while ($row = $result->fetch_assoc()) {
									?>
									<option value="<?php echo $row['am_name'];?>"><?php echo $row['am_name'];?></option>
									<?php
								}
							}
							?>
							<option value="Không rõ">Không rõ</option>
						</select>
					</div>
					<div class="row">
						<div class="col-3">
							<label >Nhóm</label>
						</div>
						<div class="col-8">
							
							<select name="category" class="form-control" id="category" required>
								<?php
								$stmt = $conn->prepare("SELECT * FROM categories");
								$stmt->execute();
								$result = $stmt->get_result();
								if ($result->num_rows > 0) {
									while ($row = $result->fetch_assoc()) {
										?>
										<option value="<?php echo $row['category'];?>"><?php echo $row['category'];?></option>
										<?php
									}
								}
								?>
							</select>
						</div>
						<div class="col-1">
							<span id="new_category" class="ml-4"><img src="./includes/images/add_icon.jpeg" height="30px"></span>
						</div>
					</div>

					<div class="row mt-4">
						<div class="col-3">
							<label >Địa điểm</label>
						</div>
						<div class="col-8">
							
							<select name="location" class="form-control" id="location" required>
								<?php
								$stmt = $conn->prepare("SELECT * FROM locations");
								$stmt->execute();
								$result = $stmt->get_result();
								if ($result->num_rows > 0) {
									while ($row = $result->fetch_assoc()) {
										?>
										<option value="<?php echo $row['location'];?>"><?php echo $row['location'];?></option>
										<?php
									}
								}
								?>
							</select>
						</div>
						<div class="col-1">
							<span id="new_location" class="ml-4"><img src="./includes/images/add_icon.jpeg" height="30px"></span>
						</div>
					</div>

					<div class="row mt-4">
						<div class="col-3">
							<label >K/hàng</label>
						</div>
						<div class="col-8">
							
							<select name="customer" class="form-control" id="customer" required>
								<?php
								$stmt = $conn->prepare("SELECT * FROM customers");
								$stmt->execute();
								$result = $stmt->get_result();
								if ($result->num_rows > 0) {
									while ($row = $result->fetch_assoc()) {
										?>
										<option value="<?php echo $row['customer'];?>"><?php echo $row['customer'];?></option>
										<?php
									}
								}
								?>
							</select>
						</div>
						<div class="col-1">
							<span id="new_customer" class="ml-4"><img src="./includes/images/add_icon.jpeg" height="30px"></span>
						</div>
					</div>

					<div class="text-center mt-4"><input type="submit" class="btn btn-primary" name="submit" value="Tạo"></div>
				</form>
			</div>
		</div>
	</div>

	<?php 
	require_once "includes/php/_footer.php";
	?>

	<script type="text/javascript">
		$("#create_project").click(() => {
			$("#form_create_project").show();
			$("#col_projects").removeClass("col-lg-10");
			$("#col_projects").addClass("col-lg-8");
			$("#col_create_project").removeClass("col-lg-2");
			$("#col_create_project").addClass("col-lg-4");
		});

		$("#new_category").click(() => {
			$("#category").replaceWith($('<input type="text" name="category" class="form-control ml-2" id="category" required>'));
		});

		$("#new_location").click(() => {
			$("#location").replaceWith($('<input type="text" name="location" class="form-control ml-2" id="location" required>'));
		});

		$("#new_customer").click(() => {
			$("#customer").replaceWith($('<input type="text" name="customer" class="form-control ml-2" id="customer" required>'));
		});
	</script>
</body>
</html>

<?php
$conn->close();
?>