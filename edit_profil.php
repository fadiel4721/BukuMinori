<?php
session_start();

// Pengecekan apakah pengguna telah login
if (!isset($_SESSION['ceklogin']) || $_SESSION['ceklogin'] !== true) {
    header("Location: index.php"); // Redirect ke halaman login jika belum login
    exit();
}

require 'koneksi.php';

// Ambil username dari sesi yang sudah login
$username = $_SESSION['username'];

// Query untuk mengambil informasi admin dan jabatan
$queryInfoAdmin = "SELECT admin.id_admin, jabatan.id_jabatan, admin.nama_admin, jabatan.nama_jabatan 
                  FROM admin 
                  JOIN jabatan ON admin.id_jabatan = jabatan.id_jabatan 
                  JOIN user ON admin.id_user = user.id_user
                  WHERE user.username = '$username'";

$resultInfoAdmin = mysqli_query($koneksi, $queryInfoAdmin);

if (!$resultInfoAdmin) {
    die("Error in fetching admin information: " . mysqli_error($koneksi));
}

// Ambil data hasil query
$rowInfoAdmin = mysqli_fetch_assoc($resultInfoAdmin);
$idAdmin = $rowInfoAdmin['id_admin'];
$idJabatan = $rowInfoAdmin['id_jabatan'];
$namaAdmin = $rowInfoAdmin['nama_admin'];
$namaJabatan = $rowInfoAdmin['nama_jabatan'];

// Ambil path foto profil dari tabel 'profil'
$queryGetProfilFoto = "SELECT foto_profil FROM profil WHERE id_admin = '$idAdmin'";
$resultGetProfilFoto = mysqli_query($koneksi, $queryGetProfilFoto);

// Periksa apakah $rowProfilFoto tidak null sebelum mengakses propertinya
if ($rowProfilFoto = mysqli_fetch_assoc($resultGetProfilFoto)) {
    $profilFoto = $rowProfilFoto['foto_profil'];
} else {
    // Tangani kasus di mana $rowProfilFoto bernilai null (misalnya, tetapkan nilai default)
    $profilFoto = "path/to/default/photo.jpg";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="path/to/your/css/style.css"> <!-- Ganti dengan path CSS yang sesuai -->
    <title>Edit Profil</title>
</head>

<body>
    <h2>Edit Profil</h2>

    <!-- Form untuk mengganti foto profil -->
    <form action="proses_edit_profil.php" method="post" enctype="multipart/form-data">
        <label for="profilFoto">Choose File:</label>
        <input type="file" name="profilFoto" id="profilFoto" accept="image/*" required>
        <button type="submit">Upload</button>
    </form>

    <?php
    // Tampilkan pesan kesalahan jika ada
    if (isset($_SESSION['error_message'])) {
        echo '<p style="color: red;">' . $_SESSION['error_message'] . '</p>';
        unset($_SESSION['error_message']);
    }
    ?>

    <!-- Link kembali ke halaman profil -->
    <a href="profil.php">Kembali ke Profil</a>
</body>

</html>
