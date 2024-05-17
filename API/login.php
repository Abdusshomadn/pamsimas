<?php
error_reporting(-1);
ini_set('display_errors', 'On');
date_default_timezone_set('Asia/Jakarta');

require_once 'DbHandler.php';

// Membuat objek DbHandler
$db = new DbHandler();

// Mengambil data yang dikirimkan melalui POST
$id = $_POST["id"];
$password = $_POST["password"];

// Memanggil fungsi login dari objek DbHandler
$db->login($id, $password);
