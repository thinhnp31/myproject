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

				<hr>

				<div class="row">
					<div class="col-lg-4">
						<div class="list-group">
							<div class="list-group-item list-group-item-action" id="BOM_files_menu">BOM & Chi phí</div>
							<div class="list-group-item list-group-item-action" id="CAD_files_menu">Bản vẽ kỹ thuật</div>
							<div class="list-group-item list-group-item-action" id="Topology_files_menu">Sơ đồ mạng</div>
							<div class="list-group-item list-group-item-action" id="Documents_files_menu">Tài liệu</div>			
							<div class="list-group-item list-group-item-action" id="Other_files_menu">Các file khác</div>					
						</div>
					</div>
						
					<div class="col-lg-8 border-left" id="BOM_files_container" style="display:none">
						<div class="row">
							<?php 
								$dir = "./uploads/" . $project_id . "/BOM";
								$files = array_diff(scandir($dir), array('..', '.'));
								foreach ($files as $index => $file_name) {
									if ($index % 3 == 2) {
										echo "</div><div class='row'>";
									}
									$full_dir = $dir . "/" . $file_name;
									$ext = pathinfo($full_dir, PATHINFO_EXTENSION);
									$src = "./includes/images/icons/" . $ext . "_icon.png";
							?>
									<div class="col-lg-4 mb-2 text-center">			
										<img src='<?php echo $src;?>'" height="100" alt="Card Img Cap">
										<form method="POST" action="delete_file.php">
											<input type="hidden" name="file_name" value="<?php echo $full_dir; ?>">
											<input type="hidden" name="project_id" value="<?php echo $project_id; ?>">
											<button class="close" style="position: relative; right: 30px; bottom: 100px; color: red; font-size: 40px;" type="submit" name="submit"><span>&times;</span></button>
										</form>
										<div class="text-center">
											<a href="<?php echo $full_dir; ?>"><?php echo $file_name;?></a>											
										</div>
									</div>
							<?php
								}
							?>
						</div>				
					</div>

					<div class="col-lg-8 border-left" id="CAD_files_container" style="display:none">
						<div class="row">
							<?php 
								$dir = "./uploads/" . $project_id . "/CAD";
								$files = array_diff(scandir($dir), array('..', '.'));
								foreach ($files as $index => $file_name) {
									if ($index % 3 == 2) {
										echo "</div><div class='row'>";
									}
									$full_dir = $dir . "/" . $file_name;
									$ext = pathinfo($full_dir, PATHINFO_EXTENSION);
									$src = "./includes/images/icons/" . $ext . "_icon.png";
							?>
									<div class="col-lg-4 mb-2 text-center">			
										<img src='<?php echo $src;?>'" height="100" alt="Card Img Cap">
										<form method="POST" action="delete_file.php">
											<input type="hidden" name="file_name" value="<?php echo $full_dir; ?>">
											<input type="hidden" name="project_id" value="<?php echo $project_id; ?>">
											<button class="close" style="position: relative; right: 30px; bottom: 100px; color: red; font-size: 40px;" type="submit" name="submit"><span>&times;</span></button>
										</form>
										<div class="text-center">
											<a href="<?php echo $full_dir; ?>"><?php echo $file_name;?></a>
										</div>
									</div>
							<?php
								}
							?>
						</div>				
					</div>

					<div class="col-lg-8 border-left" id="Topology_files_container" style="display:none">
						<div class="row">
							<?php 
								$dir = "./uploads/" . $project_id . "/Topology";
								$files = array_diff(scandir($dir), array('..', '.'));
								foreach ($files as $index => $file_name) {
									if ($index % 3 == 2) {
										echo "</div><div class='row'>";
									}
									$full_dir = $dir . "/" . $file_name;
									$ext = pathinfo($full_dir, PATHINFO_EXTENSION);
									$src = "./includes/images/icons/" . $ext . "_icon.png";
							?>
									<div class="col-lg-4 mb-2 text-center">			
										<img src='<?php echo $src;?>'" height="100" alt="Card Img Cap">
										<form method="POST" action="delete_file.php">
											<input type="hidden" name="file_name" value="<?php echo $full_dir; ?>">
											<input type="hidden" name="project_id" value="<?php echo $project_id; ?>">
											<button class="close" style="position: relative; right: 30px; bottom: 100px; color: red; font-size: 40px;" type="submit" name="submit"><span>&times;</span></button>
										</form>
										<div class="text-center">
											<a href="<?php echo $full_dir; ?>"><?php echo $file_name;?></a>
										</div>
									</div>
							<?php
								}
							?>
						</div>				
					</div>

					<div class="col-lg-8 border-left" id="Documents_files_container" style="display:none">
						<div class="row">
							<?php 
								$dir = "./uploads/" . $project_id . "/Documents";
								$files = array_diff(scandir($dir), array('..', '.'));
								foreach ($files as $index => $file_name) {
									if ($index % 3 == 2) {
										echo "</div><div class='row'>";
									}
									$full_dir = $dir . "/" . $file_name;
									$ext = pathinfo($full_dir, PATHINFO_EXTENSION);
									$src = "./includes/images/icons/" . $ext . "_icon.png";
							?>
									<div class="col-lg-4 mb-2 text-center">			
										<img src='<?php echo $src;?>'" height="100" alt="Card Img Cap">
										<form method="POST" action="delete_file.php">
											<input type="hidden" name="file_name" value="<?php echo $full_dir; ?>">
											<input type="hidden" name="project_id" value="<?php echo $project_id; ?>">
											<button class="close" style="position: relative; right: 30px; bottom: 100px; color: red; font-size: 40px;" type="submit" name="submit"><span>&times;</span></button>
										</form>
										<div class="text-center">
											<a href="<?php echo $full_dir; ?>"><?php echo $file_name;?></a>
										</div>
									</div>
							<?php
								}
							?>
						</div>				
					</div>

					<div class="col-lg-8 border-left" id="Other_files_container" style="display:none">
						<div class="row">
							<?php 
								$dir = "./uploads/" . $project_id . "/Other";
								$files = array_diff(scandir($dir), array('..', '.'));
								foreach ($files as $index => $file_name) {
									if ($index % 3 == 2) {
										echo "</div><div class='row'>";
									}
									$full_dir = $dir . "/" . $file_name;
									$ext = pathinfo($full_dir, PATHINFO_EXTENSION);
									$src = "./includes/images/icons/" . $ext . "_icon.png";
							?>
									<div class="col-lg-4 mb-2 text-center">			
										<img src='<?php echo $src;?>'" height="100" alt="Card Img Cap">
										<form method="POST" action="delete_file.php">
											<input type="hidden" name="file_name" value="<?php echo $full_dir; ?>">
											<input type="hidden" name="project_id" value="<?php echo $project_id; ?>">
											<button class="close" style="position: relative; right: 30px; bottom: 100px; color: red; font-size: 40px;" type="submit" name="submit"><span>&times;</span></button>
										</form>

										<div class="text-center">
											<a href="<?php echo $full_dir; ?>"><?php echo $file_name;?></a>
										</div>
									</div>
							<?php
								}
							?>
						</div>				
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

	<script>
		$("#BOM_files_menu").click(() => {
			$("#BOM_files_container").show();
			$("#BOM_files_menu").addClass("active");
			$("#CAD_files_container").hide();
			$("#CAD_files_menu").removeClass("active");
			$("#Topology_files_container").hide();
			$("#Topology_files_menu").removeClass("active");
			$("#Documents_files_container").hide();
			$("#Documents_files_menu").removeClass("active");
			$("#Other_files_container").hide();
			$("#Other_files_menu").removeClass("active");
		});

		$("#CAD_files_menu").click(() => {
			$("#BOM_files_container").hide();
			$("#BOM_files_menu").removeClass("active");
			$("#CAD_files_container").show();
			$("#CAD_files_menu").addClass("active");
			$("#Topology_files_container").hide();
			$("#Topology_files_menu").removeClass("active");
			$("#Documents_files_container").hide();
			$("#Documents_files_menu").removeClass("active");
			$("#Other_files_container").hide();
			$("#Other_files_menu").removeClass("active");
		});

		$("#Topology_files_menu").click(() => {
			$("#BOM_files_container").hide();
			$("#BOM_files_menu").removeClass("active");
			$("#CAD_files_container").hide();
			$("#CAD_files_menu").removeClass("active");
			$("#Topology_files_container").show();
			$("#Topology_files_menu").addClass("active");
			$("#Documents_files_container").hide();
			$("#Documents_files_menu").removeClass("active");
			$("#Other_files_container").hide();
			$("#Other_files_menu").removeClass("active");
		});

		$("#Documents_files_menu").click(() => {
			$("#BOM_files_container").hide();
			$("#BOM_files_menu").removeClass("active");
			$("#CAD_files_container").hide();
			$("#CAD_files_menu").removeClass("active");
			$("#Topology_files_container").hide();
			$("#Topology_files_menu").removeClass("active");
			$("#Documents_files_container").show();
			$("#Documents_files_menu").addClass("active");
			$("#Other_files_container").hide();
			$("#Other_files_menu").removeClass("active");
		});

		$("#Other_files_menu").click(() => {
			$("#BOM_files_container").hide();
			$("#BOM_files_menu").removeClass("active");
			$("#CAD_files_container").hide();
			$("#CAD_files_menu").removeClass("active");
			$("#Topology_files_container").hide();
			$("#Topology_files_menu").removeClass("active");
			$("#Documents_files_container").hide();
			$("#Documents_files_menu").removeClass("active");
			$("#Other_files_container").show();
			$("#Other_files_menu").addClass("active");
		});
	</script>

</body>
</html>

<?php
	$conn->close();
?>