<?php

// mengaktifkan session pada php
session_start();

// menghubungkan php dengan koneksi database
include "./config/db_connection.php";

// menangkap data yang dikirim dari form login
$username = $_POST['username'];
$password = $_POST['password'];


// menyeleksi data user dengan username dan password yang sesuai
$sql = mysqli_query($conn, "select * from user where username='$username' and password='$password'");
$data = mysqli_fetch_array($sql);
// menghitung jumlah data yang ditemukan
$cek = mysqli_num_rows($sql);
// cek apakah username dan password di temukan pada database
if ($cek > 0) {

	// cek jika user login sebagai admin
	if ($data['level'] == "admin") {
		// buat session login dan username
		$_SESSION['username'] = $username;
		$_SESSION['level'] = "admin";
		// alihkan ke halaman dashboard pimpinan
		header("location:./admin/admin_home_page.php?page=dashboard");

	} else if ($data['level'] == "petugas") {
		// buat session login dan username
		$_SESSION['username'] = $username;
		$_SESSION['level'] = "petugas";
		header("location:./petugas/petugas_home_page.php?page=dashboard");

	} else {
		$_SESSION['salah'] = 'salah';
		header("location:index.php");
	}

} else {
	$_SESSION['salah'] = 'salah';
	header("location:index.php");
}
