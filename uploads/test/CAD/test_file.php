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
	

	<div class="container">
		<div class="row">
			<div class="col-lg-4">
				<div class="list-group">
					<a class="list-group-item list-group-item-action <?php if (isset($_GET['dir']) && $_GET['dir'] == 'bom') echo "active";?>" href="./test_file.php?dir=bom">BOM</a>
					<a class="list-group-item list-group-item-action <?php if (isset($_GET['dir']) && $_GET['dir'] == 'cad') echo "active";?>"  href="./test_file.php?dir=cad">CAD</a>
					<a class="list-group-item list-group-item-action <?php if (isset($_GET['dir']) && $_GET['dir'] == 'documents') echo "active";?>" href="./test_file.php?dir=documents">Documents</a>
					<a class="list-group-item list-group-item-action <?php if (isset($_GET['dir']) && $_GET['dir'] == 'topology') echo "active";?>" href="./test_file.php?dir=topology">Topology</a>
				</div>
			</div>
			<div class="col-lg-8">
				<?php 
					$files = array_diff(scandir("."), array('..', '.'));
					foreach ($files as $index => $file_name) {
						echo $index . ": " . $file_name . "<br>";
					}
				?>
			</div>
		</div>
	</div>
</body>
</html>