// input file
$(document).ready(function () {
    bsCustomFileInput.init();
});

// datatables
$(function () {
    $("#example1").DataTable({
        "responsive": true,
        "autoWidth": false,
    });
});

// tampilan waktu
function tampilkanWaktu() {
    var waktu = new Date();
    var jam = waktu.getHours();
    var menit = waktu.getMinutes();
    var detik = waktu.getSeconds();
    var hari = waktu.toLocaleDateString('id-ID', { weekday: 'long' });
    var tanggal = waktu.getDate();
    var bulan = waktu.toLocaleDateString('id-ID', { month: 'long' });
    var tahun = waktu.getFullYear();

    // Format jam, menit, detik dengan tambahan nol jika kurang dari 10
    var jamFormat = padZero(jam);
    var menitFormat = padZero(menit);
    var detikFormat = padZero(detik);

    // Menampilkan informasi waktu pada elemen dengan id "waktu-container"
    var waktuContainer = document.getElementById('waktu-container');
    waktuContainer.innerHTML = hari + ', ' + tanggal + ' ' + bulan + ' ' + tahun + ' ' + jamFormat + ':' + menitFormat + ':' + detikFormat;

    // Menjalankan fungsi tampilkanWaktu setiap 1 detik
    setTimeout(tampilkanWaktu, 1000);
}

// Fungsi untuk menambahkan nol pada angka jika kurang dari 10
function padZero(angka) {
    return angka < 10 ? '0' + angka : angka;
}

// Memanggil fungsi tampilkanWaktu untuk pertama kali
tampilkanWaktu();

// konfirmasi hapus
$(document).ready(function () {
    $(document).on('click', '.alert_notif', function (e) {
        e.preventDefault(); // Mencegah tautan asli dari berfungsi

        var getLink = $(this).attr('href'); // Mengambil URL dari tautan yang diklik

        // Menampilkan dialog konfirmasi menggunakan SweetAlert
        Swal.fire({
            title: "Yakin hapus data?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Ya',
            cancelButtonColor: '#3085d6',
            cancelButtonText: "Batal"
        }).then((result) => {
            // Jika pengguna menekan tombol "Ya", maka arahkan ke URL yang diambil sebelumnya
            if (result.isConfirmed) {
                window.location.href = getLink;
            }
        });
    });
});

// input rt otomatis
$(document).ready(function () {
    $('#namaPelanggan').on('change', function () {
        var selectedPelangganId = $(this).val();

        // Kirim permintaan AJAX ke server untuk mendapatkan nilai RT
        $.ajax({
            url: 'pemakaian/get_rt.php', // Ganti dengan URL yang sesuai
            method: 'POST',
            data: { pelangganId: selectedPelangganId },
            dataType: 'json',
            success: function (response) {
                // Setel nilai RT berdasarkan respons dari server
                $('#rtInput').val(response.rt);
            },
            error: function () {
                alert('Gagal mengambil data RT.');
            }
        });
    });
});

// input meteran dan tagihan otomatis
$(document).ready(function () {
    // Fungsi ini akan dijalankan ketika nilai meter sekarang berubah
    $("#meterSekarang").on('keyup', function () {
        // Ambil nilai meter lalu
        var meterLalu = $("#meterLalu").val();

        // Ambil nilai meter sekarang
        var meterSekarang = $(this).val();

        // Hitung dan set nilai jumlah pakai
        var jumlahPakai = (meterSekarang !== '' && meterLalu !== '') ? meterSekarang - meterLalu : 0;
        $("#jumlahPakai").val(jumlahPakai);

        // Fungsi ini akan dijalankan ketika pilihan pelanggan berubah
        var idPelanggan = $("#namaPelanggan").val();

        // Lakukan request AJAX untuk mendapatkan data pemakaian terakhir
        $.ajax({
            url: "pemakaian/get_meter_values.php",
            method: "POST",
            data: { idPelanggan: idPelanggan },
            dataType: "json",
            success: function (data) {
                // Set nilai meter lalu ke input meterLalu
                $("#meterLalu").val(data.meter_sekarang_terakhir);

                // Hitung dan set nilai jumlah pakai
                var meterSekarang = $("#meterSekarang").val();
                var meterLalu = data.meter_sekarang_terakhir;
                var jumlahPakai = (meterSekarang !== '' && meterLalu !== '') ? meterSekarang - meterLalu : 0;
                $("#jumlahPakai").val(jumlahPakai);

                // Lakukan perhitungan tarif berdasarkan aturan yang Anda tentukan
                var harga1 = $("#harga1").val();
                var harga2 = $("#harga2").val();
                var harga3 = $("#harga3").val();
                var harga4 = $("#harga4").val();

                // Menghitung tarif berdasarkan jumlah pakai
                var tarif1 = Math.min(20, jumlahPakai) * harga1;
                var tarif2 = Math.min(20, Math.max(0, jumlahPakai - 20)) * harga2;
                var tarif3 = Math.min(20, Math.max(0, jumlahPakai - 40)) * harga3;
                var tarif4 = Math.max(0, jumlahPakai - 60) * harga4;

                // Mengisi nilai tarif pada input
                $("#tarif1").val(tarif1);
                $("#tarif2").val(tarif2);
                $("#tarif3").val(tarif3);
                $("#tarif4").val(tarif4);

                // Jumlahkan jumlah tagihan
                var jumlahTagihan = tarif1 + tarif2 + tarif3 + tarif4;
                $("#jumlahTagihan").val(jumlahTagihan);

            },
            error: function () {
                console.log("Gagal mengambil data pemakaian terakhir.");
            }
        });
    });

    // Fungsi ini akan dijalankan ketika pilihan pelanggan berubah
    $("#namaPelanggan").change(function () {
        // Memanggil fungsi setiap kali pilihan pelanggan berubah
        $("#meterSekarang").trigger("keyup");
    });
});

// edit meteran dan tagihan otomatis
$(document).ready(function () {
    // Fungsi ini akan dijalankan ketika nilai meter sekarang berubah
    $("#editmeterSekarang").on('keyup', function () {
        // Ambil nilai meter lalu
        var meterLalu = $("#editmeterLalu").val();

        // Ambil nilai meter sekarang
        var meterSekarang = $(this).val();

        // Hitung dan set nilai jumlah pakai
        var jumlahPakai = (meterSekarang !== '' && meterLalu !== '') ? meterSekarang - meterLalu : 0;
        $("#editjumlahPakai").val(jumlahPakai);

        // Lakukan perhitungan tarif berdasarkan aturan yang Anda tentukan
        var harga1 = $("#harga1").val();
        var harga2 = $("#harga2").val();
        var harga3 = $("#harga3").val();
        var harga4 = $("#harga4").val();

        // Menghitung tarif berdasarkan jumlah pakai
        var tarif1 = Math.min(20, jumlahPakai) * harga1;
        var tarif2 = Math.min(20, Math.max(0, jumlahPakai - 20)) * harga2;
        var tarif3 = Math.min(20, Math.max(0, jumlahPakai - 40)) * harga3;
        var tarif4 = Math.max(0, jumlahPakai - 60) * harga4;

        // Mengisi nilai tarif pada input
        $("#edittarif1").val(tarif1);
        $("#edittarif2").val(tarif2);
        $("#edittarif3").val(tarif3);
        $("#edittarif4").val(tarif4);

        // Jumlahkan jumlah tagihan
        var jumlahTagihan = tarif1 + tarif2 + tarif3 + tarif4;
        $("#editjumlahTagihan").val(jumlahTagihan);
    });
});

// form validasi input pelanggan
$(document).ready(function () {
    $('#inputPlg').validate({
        rules: {
            nik: {
                required: true,
            },
            nama: {
                required: true,
            },
            gender: {
                required: true,
            },
            rt: {
                required: true,
            },
            tlp: {
                required: true,
            },
            password: {
                required: true,
                minlength: 5
            },
        },
        messages: {
            nik: {
                required: "Masukkan NIK !"
            },
            nama: {
                required: "Masukkan Nama Pelanggan !"
            },
            gender: {
                required: "Pilih Gender !"
            },
            rt: {
                required: "Pilih RT !"
            },
            tlp: {
                required: "Masukkan No Telepon !"
            },
            password: {
                required: "Masukkan Password !",
                minlength: "Masukkan Password Minimal 5 Karakter"
            },

        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        }
    });
});

// 