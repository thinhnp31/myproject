<?php 
	session_start();

	require_once "includes/php/_connectdb.php";

	if (!isset($_SESSION['email'])) {
		header("Location: ./login.php");
	}

	$project_id = $_GET['project_id'];
	$stmt = $conn->prepare("SELECT * FROM projects WHERE project_id = ?");
	$stmt->bind_param("i", $project_id);
	$stmt->execute();
	$result = $stmt->get_result();
	$row = $result->fetch_assoc();

	if ($row['created_by'] != $_SESSION['email']) {
		header("Location: ./project_detail_readonly.php?project_id=" . $project_id);
	} else {
		if (isset($_GET['submit'])) {
			switch ($_GET['submit']) {
				case 'Thêm':
					if (isset($_GET['done_action']) && ($_GET['done_action'] != "")) {
						$done_action = $_GET['done_action'];				
						$stmt = $conn->prepare("SELECT * FROM projects WHERE project_id = ?");
						$stmt->bind_param("i", $project_id);
						$stmt->execute();
						$result = $stmt->get_result();
						$row = $result->fetch_assoc();
						$history = $row['history'];
						$history = date("d-m-Y") . " : " . $done_action . "\n" . $history;
						$stmt = $conn->prepare("UPDATE projects SET history = ? WHERE project_id = ?");
						$stmt->bind_param("si", $history, $project_id);
						$stmt->execute();
					} 
					if (isset($_GET['next_action']) && ($_GET['next_action'] != "")) {
						$next_action = $_GET['next_action'];	
						$stmt = $conn->prepare("UPDATE projects SET next_action = ? WHERE project_id = ?");
						$stmt->bind_param("si", $next_action, $project_id);
						$stmt->execute();
					}
					header("Location: ./project_detail.php?project_id=" . $project_id);
					break;
				case 'Xong':
					$done_action = $_GET['done_action'];				
					$stmt = $conn->prepare("SELECT * FROM projects WHERE project_id = ?");
					$stmt->bind_param("i", $project_id);
					$stmt->execute();
					$result = $stmt->get_result();
					$row = $result->fetch_assoc();
					$history = $row['history'];
					$history = date("d-m-Y") . " : " . $done_action . "\n" . $history;
					$stmt = $conn->prepare("UPDATE projects SET history = ? WHERE project_id = ?");
					$stmt->bind_param("si", $history, $project_id);
					$stmt->execute();
					header("Location: ./project_detail.php?project_id=" . $project_id);
					break;
				case 'Hoàn thành':
					$next_action = $_GET['next_action'];				
					$stmt = $conn->prepare("SELECT * FROM projects WHERE project_id = ?");
					$stmt->bind_param("i", $project_id);
					$stmt->execute();
					$result = $stmt->get_result();
					$row = $result->fetch_assoc();
					$history = $row['history'];
					$history = date("d-m-Y") . " : " . $next_action . "\n" . $history;
					$stmt = $conn->prepare("UPDATE projects SET history = ? WHERE project_id = ?");
					$stmt->bind_param("si", $history, $project_id);
					$stmt->execute();
					$stmt = $conn->prepare("UPDATE projects SET next_action = '' WHERE project_id = ?");
					$stmt->bind_param("i", $project_id);
					$stmt->execute();
					header("Location: ./project_detail.php?project_id=" . $project_id);
					break;
				case 'Cập nhật':
					$engineer_name = $_GET['engineer_name'];
					$am_name = $_GET['am_name'];
					$done_action = $_GET['done_action'];	
					$next_action = $_GET['next_action'];		
					$category  = $_GET['category'];
					$location = $_GET['location'];
					$requirement = $_GET['requirement'];
					$customer = $_GET['customer'];

					$stmt = $conn->prepare("SELECT * FROM projects WHERE project_id = ?");
					$stmt->bind_param("i", $project_id);
					$stmt->execute();
					$result = $stmt->get_result();
					$row = $result->fetch_assoc();
					$history = $row['history'];
					$history = date("d-m-Y") . " : Thay đổi thông tin dự án\n" . $history;
					if ($done_action != "") 
						$history = date("d-m-Y") . " : " . $done_action . "\n" . $history;
					$stmt = $conn->prepare("UPDATE projects SET engineer_name = ?, am_name = ?, next_action = ?, history = ?, category = ?, location = ?, requirement = ?, customer = ? WHERE project_id = ?");
					$stmt->bind_param("ssssssssi", $engineer_name, $am_name, $next_action, $history, $category, $location, $requirement, $customer, $project_id);
					$stmt->execute();
					header("Location: ./project_detail.php?project_id=" . $project_id);
					break;
				case 'Chuyển sang Post-Sales':
					$stmt = $conn->prepare("UPDATE projects SET status = 'postsales'");
					$stmt->execute();
					header("Location: ./project_detail.php?project_id=" . $project_id);
					break;
				case 'Xóa':
					$stmt = $conn->prepare("DELETE FROM projects WHERE project_id = ?");
					$stmt->bind_param("i", $project_id);
					$stmt->execute();
					header("Location: ./projects.php");
					break;
				case 'Sửa':
					$note = $_GET['note'];
					$stmt = $conn->prepare("UPDATE projects SET note = ? WHERE project_id = ?");
					$stmt->bind_param("si", $note, $project_id);
					$stmt->execute();
					header("Location: ./project_detail.php?project_id=" . $project_id);
					break;
				default:
					# code...
					break;
			}
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

						<form>
							<input type="hidden" name="project_id" value="<?php echo $project_id; ?>">
							
							<div class="row">
								<div class="col">									
									<h3><?php echo $row['project_name']; ?></h3>
								</div>
							</div>

							<div class="row mb-5">
								<div class="col text-left">
									Người tạo : <?php echo $row['created_by']; ?>
								</div>
							</div>

							<div class="form-group">
								<label>Yêu cầu :</label>
								<textarea class="form-control" name="requirement" rows="10"><?php echo $row['requirement']; ?></textarea>
							</div>

							<div class="form-group">
								<label>Phụ trách kỹ thuật :</label>
								<select name="engineer_name" class="form-control">
									<?php
										$stmt2 = $conn->prepare("SELECT * FROM engineers");
										$stmt2->execute();
										$result2 = $stmt2->get_result();
										if ($result2->num_rows > 0) {
											while ($row2 = $result2->fetch_assoc()) {							
												if ($row2['engineer_name'] == $row['engineer_name']) {
													echo "<option value='" . $row2['engineer_name'] . "' selected>" . $row2['engineer_name'] . "</option>";						
												} else {
													echo "<option value='" . $row2['engineer_name'] . "'>" . $row2['engineer_name'] . "</option>";		
												}
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
										$stmt2 = $conn->prepare("SELECT * FROM am");
										$stmt2->execute();
										$result2 = $stmt2->get_result();
										if ($result2->num_rows > 0) {
											while ($row2 = $result2->fetch_assoc()) {							
												if ($row2['am_name'] == $row['am_name']) {
													echo "<option value='" . $row2['am_name'] . "' selected>" . $row2['am_name'] . "</option>";						
												} else {
													echo "<option value='" . $row2['am_name'] . "'>" . $row2['am_name'] . "</option>";		
												}
											}
										}
									?>
									<option value="Không rõ">Không rõ</option>
								</select>
							</div>

							<div class="form-group">
								<label>Nhóm :</label>
								<select name="category" class="form-control">
									<?php
										$stmt2 = $conn->prepare("SELECT * FROM categories");
										$stmt2->execute();
										$result2 = $stmt2->get_result();
										if ($result2->num_rows > 0) {
											while ($row2 = $result2->fetch_assoc()) {							
												if ($row2['category'] == $row['category']) {
													echo "<option value='" . $row2['category'] . "' selected>" . $row2['category'] . "</option>";						
												} else {
													echo "<option value='" . $row2['category'] . "'>" . $row2['category'] . "</option>";		
												}
											}
										}
									?>
								</select>
							</div>

							<div class="form-group">
								<label>Địa điểm :</label>
								<select name="location" class="form-control">
									<?php
										$stmt2 = $conn->prepare("SELECT * FROM locations");
										$stmt2->execute();
										$result2 = $stmt2->get_result();
										if ($result2->num_rows > 0) {
											while ($row2 = $result2->fetch_assoc()) {							
												if ($row2['location'] == $row['location']) {
													echo "<option value='" . $row2['location'] . "' selected>" . $row2['location'] . "</option>";						
												} else {
													echo "<option value='" . $row2['location'] . "'>" . $row2['location'] . "</option>";		
												}
											}
										}
									?>
								</select>
							</div>

							<div class="form-group">
								<label>Khách hàng :</label>
								<select name="customer" class="form-control">
									<?php
										$stmt2 = $conn->prepare("SELECT * FROM customers");
										$stmt2->execute();
										$result2 = $stmt2->get_result();
										if ($result2->num_rows > 0) {
											while ($row2 = $result2->fetch_assoc()) {							
												if ($row2['customer'] == $row['customer']) {
													echo "<option value='" . $row2['customer'] . "' selected>" . $row2['customer'] . "</option>";						
												} else {
													echo "<option value='" . $row2['customer'] . "'>" . $row2['customer'] . "</option>";		
												}
											}
										}
									?>
								</select>
							</div>

							<div class="form-group">
								<label>Việc đã thực hiện :</label>
								<div class="form-group row">
									<div class="col-lg-10">
										<input type="text" class="form-control" name="done_action">
									</div>
									<div class="col-lg-2">
										<input type="submit" class="btn btn-primary" name="submit" value="Thêm">
									</div>
								</div>
							</div>

							<div class="form-group">
								<label>Việc tiếp theo :</label>
								<div class="form-group row">
									<div class="col-lg-8">
										<input type="text" class="form-control" name="next_action" value="<?php echo $row['next_action']?>">
									</div>
									<div class="col-lg-2">
										<input type="submit" class="btn btn-primary" name="submit" value="Thêm">
									</div>
									<div class="col-lg-2">
										<input type="submit" class="btn btn-success" name="submit" value="Hoàn thành">
									</div>
								</div>
							</div>

							<div class="row mt-5">
								<div class="col-lg-4">
									<input class="btn btn-lg btn-primary" type="submit" name="submit" value="Cập nhật">
								</div>
								<div class="col-lg-4 text-center">
									<input class="btn btn-lg btn-success ml-4" type="submit" name="submit" value="Chuyển sang Post-Sales">
								</div>
								<div class="col-lg-4 text-right">
									<input class="btn btn-lg btn-danger ml-4" type="submit" name="submit" value="Xóa">
								</div>
							</div>
						</form>
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
						

						<label class="text-danger mt-4">Nhắc nhở : </label>
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
								echo "<li class='list-group-item d-flex justify-content-between align-items-center'><form class='form-inline' action='#'><input type='hidden' name='project_id' value='".$project_id."'><input type='text' readonly class='form-control-plaintext' name='done_action' value='Gửi BOM thiết bị'><button type='submit' name='submit' value='Xong' class='badge badge-primary badge-pill'>Xong</button></form></li>";
							if ($vattu == 'notdone')
								echo "<li class='list-group-item d-flex justify-content-between align-items-center'><form class='form-inline' action='#'><input type='hidden' name='project_id' value='".$project_id."'><input type='text' readonly class='form-control-plaintext' name='done_action' value='Gửi danh mục vật tư'><button type='submit' name='submit' value='Xong' class='badge badge-primary badge-pill'>Xong</button></form></li>";
							if ($survey == 'notdone')
								echo "<li class='list-group-item d-flex justify-content-between align-items-center'><form class='form-inline' action='#'><input type='hidden' name='project_id' value='".$project_id."'><input type='text' readonly class='form-control-plaintext' name='done_action' value='Khảo sát'><button type='submit' name='submit' value='Xong' class='badge badge-primary badge-pill'>Xong</button></form></li>";
							if ($install_cost == 'notdone')
								echo "<li class='list-group-item d-flex justify-content-between align-items-center'><form class='form-inline' action='#'><input type='hidden' name='project_id' value='".$project_id."'><input type='text' readonly class='form-control-plaintext' name='done_action' value='Tính chi phí triển khai'><button type='submit' name='submit' value='Xong' class='badge badge-primary badge-pill'>Xong</button></form></li>";
							if ($proposal == 'notdone')
								echo "<li class='list-group-item d-flex justify-content-between align-items-center'><form class='form-inline' action='#'><input type='hidden' name='project_id' value='".$project_id."'><input type='text' readonly class='form-control-plaintext' name='done_action' value='Viết mô tả kỹ thuật'><button type='submit' name='submit' value='Xong' class='badge badge-primary badge-pill'>Xong</button></form></li>";
							if ($slide == 'notdone')
								echo "<li class='list-group-item d-flex justify-content-between align-items-center'><form class='form-inline' action='#'><input type='hidden' name='project_id' value='".$project_id."'><input type='text' readonly class='form-control-plaintext' name='done_action' value='Slide trình bày'><button type='submit' name='submit' value='Xong' class='badge badge-primary badge-pill'>Xong</button></form></li>";
						?>
						</ul>

						<form method="GET" action="#">
							<label class="mt-4">Ghi chú:</label>
							<input type="hidden" name="project_id" value="<?php echo $project_id;?>">
							<textarea class="form-control-plaintext border" rows="5" name=note><?php echo $row['note']; ?></textarea>
							<div class="mt-4 text-right"><input type="submit" class="btn btn-primary" name="submit" value="Sửa"></div>
						</form>

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
	</div>d

	<?php 
		require_once "includes/php/_footer.php";
	?>

</body>
</html>

<?php
	$conn->close();
?>