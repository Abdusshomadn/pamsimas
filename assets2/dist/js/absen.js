$(document).ready(function () {
    var video; // Deklarasikan variabel video di luar fungsi startVideo

    // Panggil fungsi startVideo saat tombol modal diklik
    $('#modal-absen').on('show.bs.modal', function () {
        startVideo();
    });

    // Panggil fungsi stopVideo saat modal ditutup
    $('#modal-absen').on('hidden.bs.modal', function () {
        stopVideo();
    });

    // Fungsi untuk memulai video saat tombol modal diklik
    function startVideo() {
        video = document.getElementById('video_absen'); // Inisialisasi video di sini
        navigator.mediaDevices.getUserMedia({ video: true })
            .then(function (stream) {
                video.srcObject = stream;
                video.play(); // Mulai pemutaran video
            })
            .catch(function (err) {
                console.log("Terjadi kesalahan: " + err);
            });
    }

    // Fungsi untuk menghentikan video
    function stopVideo() {
        if (video && video.srcObject) {
            var stream = video.srcObject;
            var tracks = stream.getTracks();

            tracks.forEach(function (track) {
                track.stop();
            });

            video.srcObject = null;
        }
    }

    // Capture photo from webcam
    $('#btnAbsenMasuk, #btnAbsenKeluar').click(function () {
        ambilFoto();

        // Set the action URL based on which button is clicked
        if ($(this).attr('id') == 'btnAbsenMasuk') {
            $('#formAbsen').attr('action', 'absen_masuk.php');
        } else {
            $('#formAbsen').attr('action', 'absen_keluar.php');
            stopVideo();
        }
        // Hentikan video setelah mengambil foto dan sebelum mengirim formulir
        stopVideo();
        // Submit the form
        $('#formAbsen').submit();
    });

    // Fungsi untuk mengambil foto dari video
    function ambilFoto() {
        var canvas = document.createElement('canvas');
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        var context = canvas.getContext('2d');
        context.drawImage(video, 0, 0, canvas.width, canvas.height);
        var foto = canvas.toDataURL('image/png');
        document.getElementById('foto_absen').value = foto;
        video.pause(); // Matikan video setelah mengambil foto
    }

    // Set current time and date
    var now = new Date();
    var jam = now.getHours() + ':' + ('0' + now.getMinutes()).slice(-2);
    var tanggal = now.toISOString().split('T')[0];
    $('#jam').val(jam);
    $('#tanggal').val(tanggal);
});
