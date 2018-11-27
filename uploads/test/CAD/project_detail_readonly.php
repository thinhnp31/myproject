<?php 
	session_start();

	require_once "includes/php/_connectdb.php";

	if (!isset($_SESSION['email'])) {
		header("Location: ./login.php");
	}

	$project_id = $_GET['project_id'];

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

</head>

<body>
	<?php 
		require_once "includes/php/_navbar.php";
	?>

	<div class="container">
		<?php
			$stmt = $conn->prepare("SELECT * FROM projects WHERE project_id = ?");
			$stmt->bind_param("i", $project_id);
			$stmt->execute();
			$result = $stmt->get_result();
			$row = $result->fetch_assoc();
			$status = $row['status'];
			if ($status == "presales") {
		?>
				<div class="row mt-4">
					<div class="col-lg-8 pr-4 border-right">
													
						<div class="row">
							<div class="col">									
								<h3><?php echo $row['project_name']; ?></h3>
							</div>
						</div>

						<div class="row">
							<div class="col text-left mb-5">
								Người tạo : <?php echo $row['created_by']; ?>
							</div>
						</div>

						<div class="form-group">
							<label>Yêu cầu :</label>
							<textarea class="form-control-plaintext border" name="requirement" rows="10" readonly><?php echo $row['requirement']; ?></textarea>
						</div>

						<div class="row my-4">
							<div class="col-8">
								Phụ trách kỹ thuật 
							</div>
							<div class="col-4">
								<?php echo $row['engineer_name'];?>
							</div>
						</div>

						<div class="row my-4">
							<div class="col-8">
								Phụ trách kinh doanh
							</div>
							<div class="col-4">
								<?php echo $row['am_name'];?>
							</div>
						</div>							

						<div class="row my-4">
							<div class="col-8">
								Nhóm
							</div>
							<div class="col-4">
								<?php echo $row['category'];?>
							</div>
						</div>
						
						<div class="row my-4">
							<div class="col-8">
								Địa điểm
							</div>
							<div class="col-4">
								<?php echo $row['location'];?>
							</div>
						</div>

						<div class="row my-4">
							<div class="col-8">
									Việc tiếp theo
							</div>
							<div class="col-4">
								<?php echo $row['next_action'];?>
							</div>
						</div>
					</div>			

					<div class="col-lg-4">
						
						<label class="text-danger mt-4">Các công việc chính: </label>
						<ul class="list-group">
						<?php 
							$history = $row['history'];

							if (preg_match('/BOM/i', $history))
								$bom = 'done';
							else 
								$bom = 'notdone';

							if (preg_match('/vật tư/i', $history))
								$vattu = 'done';
							else 
								$vattu = 'notdone';

							if (preg_match('/khảo sát/i', $history))
								$survey = 'done';
							else 
								$survey = 'notdone';

							if (preg_match('/chi phí triển khai/i', $history))
								$install_cost = 'done';
							else 
								$install_cost = 'notdone';

							if (preg_match('/mô tả kỹ thuật/i', $history))
								$proposal = 'done';
							else 
								$proposal = 'notdone';

							if (preg_match('/slide/i', $history))
								$slide = 'done';
							else 
								$slide = 'notdone';

							if ($bom == 'notdone')
								echo "<li class='list-group-item d-flex justify-content-between align-items-center'>Gửi BOM thiết bị<label class='switch'><input type='checkbox' disabled><span class='slider round'></span></label></li>";
							else 
								echo "<li class='list-group-item d-flex justify-content-between align-items-center'>Gửi BOM thiết bị<label class='switch'><input type='checkbox' disabled checked><span class='slider round'></span></label></li>";

							if ($vattu == 'notdone')
								echo "<li class='list-group-item d-flex justify-content-between align-items-center'>Gửi danh mục vật tư<label class='switch'><input type='checkbox' disabled><span class='slider round'></span></label></li>";
							else 
								echo "<li class='list-group-item d-flex justify-content-between align-items-center'>Gửi danh mục vật tư<label class='switch'><input type='checkbox' disabled checked><span class='slider round'></span></label></li>";

							if ($survey == 'notdone')
								echo "<li class='list-group-item d-flex justify-content-between align-items-center'>Khảo sát<label class='switch'><input type='checkbox' disabled><span class='slider round'></span></label></li>";
							else 
								echo "<li class='list-group-item d-flex justify-content-between align-items-center'>Khảo sát<label class='switch'><input type='checkbox' disabled checked><span class='slider round'></span></label></li>";

							if ($install_cost == 'notdone')
								echo "<li class='list-group-item d-flex justify-content-between align-items-center'>Tính chi phí triển khai<label class='switch'><input type='checkbox' disabled><span class='slider round'></span></label></li>";
							else 
								echo "<li class='list-group-item d-flex justify-content-between align-items-center'>Tính chi phí triển khai<label class='switch'><input type='checkbox' disabled checked><span class='slider round'></span></label></li>";

							if ($proposal == 'notdone')
								echo "<li class='list-group-item d-flex justify-content-between align-items-center'>Viết mô tả kỹ thuật<label class='switch'><input type='checkbox' disabled><span class='slider round'></span></label></li>";
							else 
								echo "<li class='list-group-item d-flex justify-content-between align-items-center'>Viết mô tả kỹ thuật<label class='switch'><input type='checkbox' disabled checked><span class='slider round'></span></label></li>";

							if ($slide == 'notdone')
								echo "<li class='list-group-item d-flex justify-content-between align-items-center'>Slide trình bày<label class='switch'><input type='checkbox' disabled><span class='slider round'></span></label></li>";
							else 
								echo "<li class='list-group-item d-flex justify-content-between align-items-center'>Slide trình bày<label class='switch'><input type='checkbox' disabled checked><span class='slider round'></span></label></li>";
						?>
						</ul>

						<hr>

						<label class="text-danger">Nhắc nhở : </label>
						<ul class="list-group">
						<?php 
							$history = $row['history'];

							if (preg_match('/BOM/i', $history))
								$bom = 'done';
							else 
								$bom = 'notdone';

							if (preg_match('/vật tư/i', $history))
								$vattu = 'done';
							else 
								$vattu = 'notdone';

							if (preg_match('/khảo sát/i', $history))
								$survey = 'done';
							else 
								$survey = 'notdone';

							if (preg_match('/chi phí triển khai/i', $history))
								$install_cost = 'done';
							else 
								$install_cost = 'notdone';

							if (preg_match('/mô tả kỹ thuật/i', $history))
								$proposal = 'done';
							else 
								$proposal = 'notdone';

							if (preg_match('/slide/i', $history))
								$slide = 'done';
							else 
								$slide = 'notdone';

							if ($bom == 'notdone')
								echo "<li class='list-group-item d-flex justify-content-between align-items-center'>Gửi BOM thiết bị</li>";
							if ($vattu == 'notdone')
								echo "<li class='list-group-item d-flex justify-content-between align-items-center'>Gửi danh mục vật tư'></li>";
							if ($survey == 'notdone')
								echo "<li class='list-group-item d-flex justify-content-between align-items-center'>Khảo sát</li>";
							if ($install_cost == 'notdone')
								echo "<li class='list-group-item d-flex justify-content-between align-items-center'>Tính chi phí triển khai</li>";
							if ($proposal == 'notdone')
								echo "<li class='list-group-item d-flex justify-content-between align-items-center'>Viết mô tả kỹ thuật</li>";
							if ($slide == 'notdone')
								echo "<li class='list-group-item d-flex justify-content-between align-items-center'>Slide trình bày</li>";
						?>
						</ul>
						<hr>
						<label>Ghi chú:</label>
						<textarea class="form-control-plaintext border" readonly rows="10"><?php echo $row['note']; ?></textarea>
						<hr>

						<label>Lịch sử :</label>
						<textarea class="form-control-plaintext border" readonly rows="10"><?php echo $row['history']; ?></textarea>
					</div>
				</div>
		<?php 
			} else {
		?>
			<div class="text-center mt-4">
				<h1><?php echo $row['project_name']; ?></h1><br>
			  <h2>Dự án đã chuyển sang giai đoạn Post Sales</h2>
			</div>
		<?php
			}
		?>
	</div>

	<?php 
		require_once "includes/php/_footer.php";
	?>

</body>
</html>

<?php
	$conn->close();
?>