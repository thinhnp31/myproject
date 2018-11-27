<?php 
	session_start();

	require_once "includes/php/_connectdb.php";

	if (!isset($_SESSION['email'])) {
		header("Location: ./login.php");
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>CTIN PROJECTS</title>
	<meta charset="utf-8">

	<link rel="shortcut icon" type="image/x-icon" href="favicon.ico"/>

	<link rel="stylesheet" href="includes/css/bootstrap.min.css">
	<script src="includes/js/jquery-3.3.1.min.js"></script>
	<script src="includes/js/popper.min.js"></script>
	<script src="includes/js/bootstrap.min.js"></script>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.js"></script>
</head>

<body>
	<?php 
		require_once "includes/php/_navbar.php";
	?>
	<?php 
		$stmt = $conn->prepare("SELECT * FROM projects");
		$stmt->execute();
		$result = $stmt->get_result();
		$total_projects = $result->num_rows;

		$stmt = $conn->prepare("SELECT * FROM projects WHERE status = 'postsales'");
		$stmt->execute();
		$result = $stmt->get_result();
		$total_postsales_projects = $result->num_rows;

		$now = date("Y-m-d");
		$six_month_ago = date("Y-m-d", strtotime($now . "- 6 months"));
		$stmt = $conn->prepare("SELECT * FROM projects WHERE status = 'presales' AND DATE(last_update) < ?");
		$stmt->bind_param("s", $six_month_ago);
		$stmt->execute();
		$result = $stmt->get_result();
		$total_forgotten_projects = $result->num_rows;
	?>
	<div class="container">
		<div class="row mt-4">
			<div class="col bg-danger text-white mx-2 p-2">
				<h4>Tổng số dự án : <?php echo $total_projects;?></h4>
			</div>
			<div class="col bg-success text-white mx-2 p-2">
				<h4>Số dự án PostSales: <?php echo $total_postsales_projects;?></h4>
			</div>
			<div class="col bg-secondary text-white mx-2 p-2">
				<h4>Dự án bị lãng quên : <?php echo $total_forgotten_projects;?></h4>
			</div>
		</div>

		<div class="row mt-4">
			<div class="col mr-2">				
				<div class="row border py-2">
					<div class="col-7">
						Phụ trách kỹ thuật nhiều dự án nhất  
					</div>
					<div class="col-4">
						<?php 
							$stmt = $conn->prepare("SELECT COUNT(project_name) AS count, engineer_name FROM projects GROUP BY engineer_name ORDER BY count DESC");
							$stmt->execute();
							$result = $stmt->get_result();
							$row = $result->fetch_assoc();
							echo $row['engineer_name'] ;
						?>
					</div>
					<div class="col-1">
						<?php echo " (". $row['count'] . ")"; ?>
					</div>			
				</div>
				<div class="row border py-2">
					<div class="col-7">
						Phụ trách kinh doanh nhiều dự án nhất 
					</div>
					<div class="col-4">
						<?php 
							$stmt = $conn->prepare("SELECT COUNT(project_name) AS count, am_name FROM projects GROUP BY am_name ORDER BY count DESC");
							$stmt->execute();
							$result = $stmt->get_result();
							$row = $result->fetch_assoc();
							echo $row['am_name'] ;
						?>
					</div>
					<div class="col-1">
						<?php echo " (". $row['count'] . ")"; ?>
					</div>						
				</div>
				<div class="row border py-2">
					<div class="col-7">
						Nhóm có nhiều dự án nhất 
					</div>
					<div class="col-4">
						<?php 
							$stmt = $conn->prepare("SELECT COUNT(category) AS count, category FROM projects GROUP BY category ORDER BY count DESC");
							$stmt->execute();
							$result = $stmt->get_result();
							$row = $result->fetch_assoc();
							echo $row['category'] ;
						?>
					</div>
					<div class="col-1">
						<?php echo " (". $row['count'] . ")"; ?>
					</div>						
				</div>
				<div class="row border py-2">
					<div class="col-7">
						Khu vực có nhiều dự án nhất 
					</div>
					<div class="col-4">
						<?php 
							$stmt = $conn->prepare("SELECT COUNT(location) AS count, location FROM projects GROUP BY location ORDER BY count DESC");
							$stmt->execute();
							$result = $stmt->get_result();
							$row = $result->fetch_assoc();
							echo $row['location'] ;
						?>
					</div>
					<div class="col-1">
						<?php echo " (". $row['count'] . ")"; ?>
					</div>						
				</div>
				<div class="row border py-2">
					<div class="col-7">
						Khách hàng có nhiều dự án nhất 
					</div>
					<div class="col-4">
						<?php 
							$stmt = $conn->prepare("SELECT COUNT(customer) AS count, customer FROM projects GROUP BY customer ORDER BY count DESC");
							$stmt->execute();
							$result = $stmt->get_result();
							$row = $result->fetch_assoc();
							echo $row['customer'] ;
						?>
					</div>
					<div class="col-1">
						<?php echo " (". $row['count'] . ")"; ?>
					</div>						
				</div>
			</div>

			<div class="col ml-2">
				<div class="row border py-2">
					<div class="col-7">
						Kỹ thuật có nhiều dự án Post Sales nhất  
					</div>
					<div class="col-4">
						<?php 
							$stmt = $conn->prepare("SELECT COUNT(project_name) AS count, engineer_name FROM projects WHERE status = 'postsales' GROUP BY engineer_name ORDER BY count DESC");
							$stmt->execute();
							$result = $stmt->get_result();
							$row = $result->fetch_assoc();
							echo $row['engineer_name'] ;
						?>
					</div>
					<div class="col-1">
						<?php echo " (". $row['count'] . ")"; ?>
					</div>			
				</div>
				<div class="row border py-2">
					<div class="col-7">
						AM có nhiều dự án Post Sales nhất  
					</div>
					<div class="col-4">
						<?php 
							$stmt = $conn->prepare("SELECT COUNT(project_name) AS count, am_name FROM projects WHERE status = 'postsales' GROUP BY am_name ORDER BY count DESC");
							$stmt->execute();
							$result = $stmt->get_result();
							$row = $result->fetch_assoc();
							echo $row['am_name'] ;
						?>
					</div>
					<div class="col-1">
						<?php echo " (". $row['count'] . ")"; ?>
					</div>						
				</div>
				<div class="row border py-2">
					<div class="col-7">
						Nhóm có nhiều dự án Post Sales nhất 
					</div>
					<div class="col-4">
						<?php 
							$stmt = $conn->prepare("SELECT COUNT(category) AS count, category FROM projects WHERE status = 'postsales' GROUP BY category ORDER BY count DESC");
							$stmt->execute();
							$result = $stmt->get_result();
							$row = $result->fetch_assoc();
							echo $row['category'] ;
						?>
					</div>
					<div class="col-1">
						<?php echo " (". $row['count'] . ")"; ?>
					</div>						
				</div>
				<div class="row border py-2">
					<div class="col-7">
						Khu vực có nhiều dự án Post Sales nhất 
					</div>
					<div class="col-4">
						<?php 
							$stmt = $conn->prepare("SELECT COUNT(location) AS count, location FROM projects WHERE status = 'postsales' GROUP BY location ORDER BY count DESC");
							$stmt->execute();
							$result = $stmt->get_result();
							$row = $result->fetch_assoc();
							echo $row['location'] ;
						?>
					</div>
					<div class="col-1">
						<?php echo " (". $row['count'] . ")"; ?>
					</div>						
				</div>
				<div class="row border py-2">
					<div class="col-7">
						K/hàng có nhiều dự án Post Sales nhất 
					</div>
					<div class="col-4">
						<?php 
							$stmt = $conn->prepare("SELECT COUNT(customer) AS count, customer FROM projects WHERE status = 'postsales' GROUP BY customer ORDER BY count DESC");
							$stmt->execute();
							$result = $stmt->get_result();
							$row = $result->fetch_assoc();
							echo $row['customer'] ;
						?>
					</div>
					<div class="col-1">
						<?php echo " (". $row['count'] . ")"; ?>
					</div>						
				</div>


			</div>			
		</div>

		<div class="row mt-4">
			<div class="col">
				<div class="text-center"><h3>Thống kê dự án theo tháng</h3></div>
				<canvas id="chart_project_month"></canvas>
			</div>
		</div>

		<div class="row mt-4">
			<div class="col border rounded mr-2">
				<div class="text-center mt-4"><h3>Thống kê dự án theo nhóm</h3></div>
				<canvas id="chart_project_category"></canvas>
			</div>

			<div class="col border rounded ml-2">
				<div class="text-center mt-4"><h3>Thống kê dự án theo khu vực</h3></div>
				<canvas id="chart_project_location"></canvas>
			</div>
		</div>

		<div class="row mt-4">
			<div class="col border rounded mr-2">
				<div class="text-center mt-4"><h3>Thống kê Phụ trách Kỹ thuật</h3></div>
				<canvas id="chart_project_engineer"></canvas>
			</div>

			<div class="col border rounded ml-2">
				<div class="text-center mt-4"><h3>Thống kê Phụ trách Kinh doanh</h3></div>
				<canvas id="chart_project_am"></canvas>
			</div>
		</div>

		<div class="row mt-4">
			<div class="col border rounded mr-2">
				<div class="text-center mt-4"><h3>Thống kê Nhóm khách hàng</h3></div>
				<canvas id="chart_project_customer"></canvas>
			</div>
		</div>
	</div>

	<?php 
		require_once "includes/php/_footer.php";
	?>

	<script>
		<?php 
			$stmt = $conn->prepare("SELECT MONTH(DATE(creation_date)) AS month, COUNT(project_id) AS count FROM projects WHERE YEAR(DATE(creation_date)) = '2018' GROUP BY MONTH(DATE(creation_date))");
			$stmt->execute();
			$result = $stmt->get_result();

			$project_month = [];
			for ($i = 1; $i <= 12; $i++)
				$project_month[$i] = 0;

			while ($row = $result->fetch_assoc()) {
				$project_month[$row['month']] = $row['count'];
			}

			$labels_month = "";
			for ($i = 1; $i <= 12; $i++)
				$labels_month .= "'" . $i . "', ";
			$labels_month = substr($labels_month, 0, -2);
			$labels_month = "[" . $labels_month . "]";

			$data_projects_month = "";
			for ($i = 1; $i <= 12; $i++)
				$data_projects_month .= "'" . $project_month[$i] . "', ";
			$data_projects_month = substr($data_projects_month, 0, -2);
			$data_projects_month = "[" . $data_projects_month . "]";
		?>

		var ctx_chart_project_month = document.getElementById("chart_project_month").getContext("2d");
		var chart_project_month = new Chart(ctx_chart_project_month, {
			type: "bar",
			data: {
				labels: <?php echo $labels_month; ?>,
				datasets: [{
					label: 'Số dự án',
					data: <?php echo $data_projects_month; ?>,
					backgroundColor: 'rgba(0, 0, 255, 0.8)',
					borderColor: 'rgba(0, 0, 255, 1)',
					borderWidth: 1
				}]				
			},
			options: {
				responsive: true,
				title: {
					display: false,
					text: "Thống kê dự án theo tháng"
				},
				scales: {
					xAxes: [{
						display: true,
						scaleLabel: {
							display: true,
							labelString: "Tháng"
						}
					}],
					yAxes: [{
						display: true,
						scaleLabel: {
							display: true,
							labelString: "Số dự án"
						}
					}]
				}
			}
		})
	</script>

	<script>
		<?php 
			$stmt = $conn->prepare("SELECT category, COUNT(project_id) AS count FROM projects WHERE YEAR(DATE(creation_date)) = '2018' GROUP BY category ORDER BY count DESC");
			$stmt->execute();
			$result = $stmt->get_result();

			$label_category = "";
			$data_projects_category = "";

			while ($row = $result->fetch_assoc()) {
				$label_category .= "'" . $row['category'] . "', ";
				$data_projects_category .= "'" . $row['count'] . "', ";
			}

			$label_category = substr($label_category, 0, -2);
			$label_category = "[" . $label_category . "]";
			$data_projects_category = substr($data_projects_category, 0, -2);
			$data_projects_category = "[" . $data_projects_category . "]";
		?>

		var ctx_chart_project_category = document.getElementById("chart_project_category").getContext("2d");
		var chart_project_category = new Chart(ctx_chart_project_category, {
			type: "pie",
			data: {
				labels: <?php echo $label_category; ?>,
				datasets: [{
					label: 'Số dự án',
					data: <?php echo $data_projects_category; ?>,
					backgroundColor: ['rgba(36, 113, 163, 1)',
														'rgba(23, 165, 137, 1)',
														'rgba(40, 180, 99, 1)',
														'rgba(212, 172, 13, 1)',
														'rgba(186, 74, 0, 1)',
														'rgba(203, 67, 53, 1)',
														'rgba(125, 60, 152, 1)'],
				}]				
			},
			options: {
				responsive: true
			}
		})
	</script>

	<script>
		<?php 
			$stmt = $conn->prepare("SELECT location, COUNT(project_id) AS count FROM projects WHERE YEAR(DATE(creation_date)) = '2018' GROUP BY location ORDER BY count DESC");
			$stmt->execute();
			$result = $stmt->get_result();

			$label_location = "";
			$data_projects_location = "";

			while ($row = $result->fetch_assoc()) {
				$label_location .= "'" . $row['location'] . "', ";
				$data_projects_location .= "'" . $row['count'] . "', ";
			}

			$label_location = substr($label_location, 0, -2);
			$label_location = "[" . $label_location . "]";
			$data_projects_location = substr($data_projects_location, 0, -2);
			$data_projects_location= "[" . $data_projects_location . "]";
		?>

		var ctx_chart_project_location = document.getElementById("chart_project_location").getContext("2d");
		var chart_project_location= new Chart(ctx_chart_project_location, {
			type: "pie",
			data: {
				labels: <?php echo $label_location; ?>,
				datasets: [{
					label: 'Số dự án',
					data: <?php echo $data_projects_location; ?>,
					backgroundColor: ['rgba(36, 113, 163, 1)',
														'rgba(23, 165, 137, 1)',
														'rgba(40, 180, 99, 1)',
														'rgba(212, 172, 13, 1)',
														'rgba(186, 74, 0, 1)',
														'rgba(203, 67, 53, 1)',
														'rgba(125, 60, 152, 1)'],
				}]				
			},
			options: {
				responsive: true
			}
		})
	</script>

	<script>
		<?php 
			$stmt = $conn->prepare("SELECT engineer_name, COUNT(project_id) AS count FROM projects WHERE YEAR(DATE(creation_date)) = '2018' GROUP BY engineer_name ORDER BY count DESC");
			$stmt->execute();
			$result = $stmt->get_result();

			$label_engineer = "";
			$data_projects_engineer = "";

			while ($row = $result->fetch_assoc()) {
				$label_engineer .= "'" . $row['engineer_name'] . "', ";
				$data_projects_engineer .= "'" . $row['count'] . "', ";
			}

			$label_engineer = substr($label_engineer, 0, -2);
			$label_engineer = "[" . $label_engineer . "]";
			$data_projects_engineer = substr($data_projects_engineer, 0, -2);
			$data_projects_engineer= "[" . $data_projects_engineer . "]";
		?>

		var ctx_chart_project_engineer = document.getElementById("chart_project_engineer").getContext("2d");
		var chart_project_engineer= new Chart(ctx_chart_project_engineer, {
			type: "pie",
			data: {
				labels: <?php echo $label_engineer; ?>,
				datasets: [{
					label: 'Số dự án',
					data: <?php echo $data_projects_engineer; ?>,
					backgroundColor: ['rgba(36, 113, 163, 1)',
														'rgba(23, 165, 137, 1)',
														'rgba(40, 180, 99, 1)',
														'rgba(212, 172, 13, 1)',
														'rgba(186, 74, 0, 1)',
														'rgba(203, 67, 53, 1)',
														'rgba(125, 60, 152, 1)'],
				}]				
			},
			options: {
				responsive: true
			}
		})
	</script>

	<script>
		<?php 
			$stmt = $conn->prepare("SELECT am_name, COUNT(project_id) AS count FROM projects WHERE YEAR(DATE(creation_date)) = '2018' GROUP BY am_name ORDER BY count DESC");
			$stmt->execute();
			$result = $stmt->get_result();

			$label_am = "";
			$data_projects_am = "";

			while ($row = $result->fetch_assoc()) {
				$label_am .= "'" . $row['am_name'] . "', ";
				$data_projects_am .= "'" . $row['count'] . "', ";
			}

			$label_am = substr($label_am, 0, -2);
			$label_am = "[" . $label_am . "]";
			$data_projects_am = substr($data_projects_am, 0, -2);
			$data_projects_am= "[" . $data_projects_am . "]";
		?>

		var ctx_chart_project_am = document.getElementById("chart_project_am").getContext("2d");
		var chart_project_am = new Chart(ctx_chart_project_am, {
			type: "pie",
			data: {
				labels: <?php echo $label_am; ?>,
				datasets: [{
					label: 'Số dự án',
					data: <?php echo $data_projects_am; ?>,
					backgroundColor: ['rgba(36, 113, 163, 1)',
														'rgba(23, 165, 137, 1)',
														'rgba(40, 180, 99, 1)',
														'rgba(212, 172, 13, 1)',
														'rgba(186, 74, 0, 1)',
														'rgba(203, 67, 53, 1)',
														'rgba(125, 60, 152, 1)'],
				}]				
			},
			options: {
				responsive: true
			}
		})
	</script>

	<script>
		<?php 
			$stmt = $conn->prepare("SELECT customer, COUNT(project_id) AS count FROM projects WHERE YEAR(DATE(creation_date)) = '2018' GROUP BY customer ORDER BY count DESC");
			$stmt->execute();
			$result = $stmt->get_result();

			$label_customer = "";
			$data_projects_customer = "";

			while ($row = $result->fetch_assoc()) {
				$label_customer .= "'" . $row['customer'] . "', ";
				$data_projects_customer .= "'" . $row['count'] . "', ";
			}

			$label_customer = substr($label_customer, 0, -2);
			$label_customer = "[" . $label_customer . "]";
			$data_projects_customer = substr($data_projects_customer, 0, -2);
			$data_projects_customer = "[" . $data_projects_customer . "]";
		?>

		var ctx_chart_project_customer = document.getElementById("chart_project_customer").getContext("2d");
		var chart_project_customer = new Chart(ctx_chart_project_customer, {
			type: "pie",
			data: {
				labels: <?php echo $label_customer; ?>,
				datasets: [{
					label: 'Số dự án',
					data: <?php echo $data_projects_customer; ?>,
					backgroundColor: ['rgba(36, 113, 163, 1)',
														'rgba(23, 165, 137, 1)',
														'rgba(40, 180, 99, 1)',
														'rgba(212, 172, 13, 1)',
														'rgba(186, 74, 0, 1)',
														'rgba(203, 67, 53, 1)',
														'rgba(125, 60, 152, 1)'],
				}]				
			},
			options: {
				responsive: true
			}
		})
	</script>


</body>
</html>

<?php
	$conn->close();
?>