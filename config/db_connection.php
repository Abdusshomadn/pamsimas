<?php
$hostname = "localhost";

$user_db = "root";
$pass_db = "";
$db_name = "tirta_pandan_ayu";

$conn = new mysqli($hostname, $user_db, $pass_db);


if ($conn->connect_error) {
	die ("Connection failed: " . $conn->connect_error);
}
mysqli_select_db($conn, $db_name);

