<?php
	session_start();

	require_once "includes/php/_connectdb.php";

	if (!isset($_SESSION['email'])) {
		header("Location: ./login.php");
	}
			
	if (isset($_POST['submit']) and ($_POST['submit'] == "Upload")) {
		$project_id = $_POST['project_id'];
		$type = $_POST['type'];

		$target_dir = "./uploads/" . $project_id . "/" ;
		if (!file_exists($target_dir))
			mkdir($target_dir, 0700);
		$target_dir .= $type . "/";
		if (!file_exists($target_dir))
			mkdir($target_dir, 0700);

		$target_file = $target_dir . str_replace(" ", "_", basename($_FILES['fileToUpLoad']["name"]));
		$uploadOk = 1;
		$ext = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

		if (($ext != "doc") && ($ext != "docx") && ($ext != "ppt") && ($ext != "pptx") && ($ext != "xls") && ($ext != "xlsx") && ($ext != "pdf") && ($ext != "vsd") && ($ext != "vsdx") && ($ext != "dwg") && ($ext != "zip") && ($ext != "rar")) {
			$msg = "Lỗi Upload File: Định dạng file không phù hợp";
			$msg_type = "danger";
			header("Location: ./project_detail.php?project_id=".$project_id."&msg=".$msg."&msg_type=".$msg_type);
		}

		if (file_exists($target_file)) {
			$msg = "Lỗi Upload File: Tên file đã tồn tại";
			$msg_type = "danger";
			header("Location: ./project_detail.php?project_id=".$project_id."&msg=".$msg."&msg_type=".$msg_type);
		}

		if (move_uploaded_file($_FILES["fileToUpLoad"]["tmp_name"], $target_file)) {
			$msg = "Upload file thành công";
			$msg_type = "success";
			header("Location: ./project_detail.php?project_id=".$project_id."&msg=".$msg."&msg_type=".$msg_type);
		} else {
			$msg = "Lỗi Upload File: Có lỗi trong quá trình upload";
			$msg_type = "danger";
			header("Location: ./project_detail.php?project_id=".$project_id."&msg=".$msg."&msg_type=".$msg_type);
		}
	}
?>