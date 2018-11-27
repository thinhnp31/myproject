<?php 
	session_start();

	require_once "includes/php/_connectdb.php";

	if (!isset($_SESSION['email'])) {
		header("Location: ./login.php");
	}

	$project_id = $_POST['project_id'];
	$file_name = $_POST['file_name'];
	$stmt = $conn->prepare("SELECT * FROM projects WHERE project_id = ?");
	$stmt->bind_param("i", $project_id);
	$stmt->execute();
	$result = $stmt->get_result();
	$row = $result->fetch_assoc();

	if ($row['created_by'] != $_SESSION['email']) {
		$msg = "Bạn không có quyền xóa file này";
		$msg_type = "danger";
		header("Location: ./project_detail.php?project_id=" . $project_id . "&msg=" . $msg . "&msg_type=" . $msg_type);
	} else {
		if (unlink($file_name)) {
			$msg = "Xóa file thành công";
			$msg_type = "success";
			header("Location: ./project_detail.php?project_id=" . $project_id . "&msg=" . $msg . "&msg_type=" . $msg_type);
		} else {
			$msg = "Lỗi xóa file";
			$msg_type = "danger";
			header("Location: ./project_detail.php?project_id=" . $project_id . "&msg=" . $msg . "&msg_type=" . $msg_type);
		}
		
	}
?>