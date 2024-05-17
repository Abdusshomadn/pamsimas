<?php

class DbHandler
{
    public function login($id, $password)
    {
        require_once '../config/db_connection.php';

        // Prepared statement untuk mencegah SQL Injection
        $sql = "SELECT * FROM pelanggan WHERE id_pelanggan=? AND password=?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $id, $password);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (!$result) {
            // Penanganan kesalahan jika terjadi kesalahan dalam kueri
            header('Content-Type: application/json');
            echo '{"message" : "Terjadi kesalahan dalam kueri"}';
            exit();
        }

        if ($result->num_rows > 0) {
            header('Content-Type: application/json');
            $data = array();
            $row = $result->fetch_assoc();
            $jk = ($row['jenis_kelamin'] == 'L') ? 'Laki-Laki' : 'Perempuan';

            $temp['id'] = $row['id_pelanggan'];
            $temp['nik'] = $row['nik'];
            $temp['nama'] = $row['nama_pelanggan'];
            $temp['jk'] = $jk;
            $temp['rt'] = $row['rt'];
            $temp['telepon'] = $row['no_telepon'];
            $temp['password'] = $row['password'];

            $data[] = $temp;

            echo '{ "message" : "Berhasil" ,"results":' . json_encode($data) . '}';
        } else {
            header('Content-Type: application/json');
            echo '{"message" : "Email atau password salah"}';
        }
    }

    public function getTagihan($id)
    {
        require_once '../config/db_connection.php';
        require_once '../tanggal_indo.php';

        // Jalankan query SQL
        $sql = "SELECT * FROM tagihan AS t
        INNER JOIN pemakaian AS pm ON t.id_pemakaian = pm.id_pemakaian
        INNER JOIN pelanggan AS pl ON pm.id_pelanggan = pl.id_pelanggan
        WHERE pl.id_pelanggan='" . $id . "'
        ORDER BY t.created_at DESC";
        // Mengambil tagihan untuk pelanggan dengan ID tertentu
        $result = $conn->query($sql); // Menjalankan query SQL dan menyimpan hasilnya

        if ($result->num_rows > 0) {
            header('Content-Type: application/json');
            $data = array();
            // Jangan panggil $result->fetch_assoc() di sini
            while ($row = $result->fetch_assoc()) { // Loop melalui hasil query
                $t = date('Y-m-d', strtotime($row['created_at']));
                $tgl = tanggal_indo($t, true);

                $temp['id'] = $row['id_pelanggan'];
                $temp['nama'] = $row['nama_pelanggan'];
                $temp['jumlahPakai'] = $row['jumlah_pakai'];
                $temp['tarif1'] = "Rp. " . number_format($row['tarif1']) . " ,-";
                $temp['tarif2'] = "Rp. " . number_format($row['tarif2']) . " ,-";
                $temp['tarif3'] = "Rp. " . number_format($row['tarif3']) . " ,-";
                $temp['tarif4'] = "Rp. " . number_format($row['tarif4']) . " ,-";
                $temp['tagihan'] = "Rp. " . number_format($row['jumlah_tagihan']) . " ,-";
                $temp['periode'] = date('F Y', strtotime($row['periode']));
                $temp['tanggal'] = $tgl;
                $temp['status'] = $row['status'];

                $data[] = $temp;
            }
            echo '{"message" : "Berhasil","results":' . json_encode($data) . '}';
        } else {
            header('Content-Type: application/json');
            echo '{"results" : "0"}';
        }
    }

    public function getPemakaian($id)
    {
        require_once '../config/db_connection.php';
        require_once '../tanggal_indo.php';

        // Jalankan query SQL
        $sql = "SELECT * FROM pemakaian AS pm 
        INNER JOIN pelanggan AS pl ON pm.id_pelanggan = pl.id_pelanggan
        WHERE pl.id_pelanggan='" . $id . "'
        ORDER BY pm.tanggal_pemakaian DESC";
        // Mengambil tagihan untuk pelanggan dengan ID tertentu
        $result = $conn->query($sql); // Menjalankan query SQL dan menyimpan hasilnya

        if ($result->num_rows > 0) {
            header('Content-Type: application/json');
            $data = array();
            // Jangan panggil $result->fetch_assoc() di sini
            while ($row = $result->fetch_assoc()) { // Loop melalui hasil query

                $temp['id'] = $row['id_pemakaian'];
                $temp['nama'] = $row['nama_pelanggan'];
                $temp['meterLalu'] = $row['meter_lalu'] . " m3";
                $temp['meterSekarang'] = $row['meter_sekarang'] . " m3";
                $temp['jumlahPakai'] = $row['jumlah_pakai'] . " m3";
                $temp['periode'] = date('F Y', strtotime($row['periode']));
                $temp['tanggal'] = date('d-F-Y', strtotime($row['tanggal_pemakaian']));

                $data[] = $temp;
            }
            echo '{"message" : "Berhasil","results":' . json_encode($data) . '}';
        } else {
            header('Content-Type: application/json');
            echo '{"results" : "0"}';
        }
    }

    public function tambahKeluhan($idPelanggan, $keluhan)
    {
        require_once '../config/db_connection.php';

        // Periksa apakah parameter tidak boleh NULL dan tidak boleh kosong
        if (
            $idPelanggan == NULL || $keluhan == NULL ||
            empty(trim($idPelanggan)) || empty(trim($keluhan))
        ) {
            // Jika ada parameter yang tidak valid, kembalikan pesan kesalahan dalam format JSON
            return '{"message" : "Semua Field Harus Terisi dan Valid"}';
        } else {
            // Persiapkan kueri SQL dengan menggunakan binding parameter
            $sql = "INSERT INTO keluhan (id_pelanggan, keluhan) VALUES (?, ?)";

            // Persiapkan statement SQL
            $stmt = $conn->prepare($sql); // Menggunakan $conn langsung karena tidak menggunakan kelas

            // Bind parameter ke statement
            $stmt->bind_param("ss", $idPelanggan, $keluhan); // Gunakan variabel lokal yang telah diinisialisasi

            // Eksekusi statement
            if ($stmt->execute()) {
                // Jika penyimpanan berhasil, kembalikan pesan sukses dalam format JSON
                return '{"message" : "Berhasil Menyimpan Keluhan"}';
            } else {
                // Jika ada kesalahan dalam penyimpanan, kembalikan pesan kesalahan dalam format JSON
                return '{"message" : "Gagal Menyimpan Keluhan"}';
            }
        }
    }

    public function getKeluhan($id)
    {
        require_once '../config/db_connection.php';
        require_once '../tanggal_indo.php';

        // Jalankan query SQL
        $sql = "SELECT * FROM keluhan AS k 
        INNER JOIN pelanggan AS p ON k.id_pelanggan = p.id_pelanggan
        WHERE k.id_pelanggan='" . $id . "'
        ORDER BY k.tanggal DESC";
        // Mengambil tagihan untuk pelanggan dengan ID tertentu
        $result = $conn->query($sql); // Menjalankan query SQL dan menyimpan hasilnya

        if ($result->num_rows > 0) {
            header('Content-Type: application/json');
            $data = array();
            // Jangan panggil $result->fetch_assoc() di sini
            while ($row = $result->fetch_assoc()) { // Loop melalui hasil query
                $t = date('Y-m-d', strtotime($row['tanggal']));
                $tgl = tanggal_indo($t, true);

                $temp['idKeluhan'] = $row['id_keluhan'];
                $temp['nama'] = $row['nama_pelanggan'];
                $temp['keluhan'] = $row['keluhan'];
                $temp['status'] = $row['status'];
                $temp['reply'] = $row['reply'];
                $temp['tanggal'] = $tgl;

                $data[] = $temp;
            }
            echo '{"message" : "Berhasil","results":' . json_encode($data) . '}';
        } else {
            header('Content-Type: application/json');
            echo '{"results" : "0"}';
        }
    }


}