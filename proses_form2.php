<!DOCTYPE html>
<head> 
<script
  src="https://code.jquery.com/jquery-3.7.1.js"
  integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
  crossorigin="anonymous"></script>
</head>
<body>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> 
</body>
</html><?php
require 'koneksi.php';

if (isset($_POST['kirim'])) {
    // Variabel dari formulir
    $nama_tamu = $_POST["nama_tamu"];
    $jenis_kelamin = $_POST["jk"];
    $tanggal_bertamu = $_POST["tanggal"];
    $status1 = $_POST["nama_status"];
    $status = "SELECT nama_status FROM status where id_status ='$status1'";
    $exec = mysqli_fetch_array(mysqli_query($koneksi, $status));
    $keperluan = $_POST['keperluan'];
    $no_hp_tamu = $_POST['no_hp'];
    $alamat_tamu = $_POST['alamat'];
    $email_tamu = $_POST['email_tamu'];
    $waktu_datang = $_POST['waktu_datang'];
    $waktu_pulang = $_POST['waktu_pulang'];

    // Insert ke tabel 'tamu'
    $queryTamu = "INSERT INTO tamu (id_status,nama_tamu,nama_status, jk,  no_hp, alamat, email_tamu)
                  VALUES ('$status1','$nama_tamu','$exec[nama_status]', '$jenis_kelamin','$no_hp_tamu', '$alamat_tamu','$email_tamu')";

    // Eksekusi query untuk tabel 'tamu'
    $resultTamu = mysqli_query($koneksi, $queryTamu);

    // Ambil ID terakhir yang di-generate oleh query INSERT ke tabel 'tamu'
    $lastTamuID = mysqli_insert_id($koneksi);

    // Insert ke tabel 'history' dengan menggunakan ID yang diambil sebelumnya dan data lainnya
    $queryHistory = "INSERT INTO history (id_tamu, id_status,keperluan,tanggal, waktu_datang, waktu_pulang)
                     VALUES ('$lastTamuID', '$status1','$keperluan','$tanggal_bertamu','$waktu_datang', '$waktu_pulang')";

    // Eksekusi query untuk tabel 'history'
    $resultHistory = mysqli_query($koneksi, $queryHistory);

    // Cek apakah kedua query berhasil dieksekusi
    if ($resultTamu && $resultHistory) {
        echo "<script>
            Swal.fire({
                icon: 'success',
                title: 'Good Job!',
                text: 'Terima Kasih Telah Mengisi!',
                showConfirmButton: false,
                timer: 3000
            }).then(function() {
                window.location.href = 'form_tamu.php';
            });
        </script>";
    } else {
        // Jika gagal, hapus data yang sudah disimpan di tabel 'tamu'
        mysqli_query($koneksi, "DELETE FROM tamu WHERE id_tamu = $lastTamuID");
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Gagal menyimpan data.'
            });
        </script>";
    }
}
?>