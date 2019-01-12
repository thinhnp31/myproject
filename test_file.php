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
	<?php if (!mkdir("./test")) echo "Lỗi";?>
</body>
</html>