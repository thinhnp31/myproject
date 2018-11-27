<?php
	$server = 'localhost';
	$username = 'myproject';
	$password = 'Ctin@123';
	$database = 'myproject';

	$conn = new mysqli($server, $username, $password, $database);

	if ($conn->connection_error) {
		die("Error while connecting to DB : " . $conn->connection_error);
	}
?>