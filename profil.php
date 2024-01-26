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
$queryInfoAdmin = "SELECT admin.id_admin, jabatan.id_jabatan, admin.nama_admin, jabatan.nama_jabatan, profil.foto_profil
                  FROM admin 
                  JOIN jabatan ON admin.id_jabatan = jabatan.id_jabatan 
                  JOIN user ON admin.id_user = user.id_user
                  LEFT JOIN profil ON admin.id_admin = profil.id_admin
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
$profilFoto = isset($rowInfoAdmin['foto_profil']) ? $rowInfoAdmin['foto_profil'] : "path/to/default/photo.jpg";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- boxicon css -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="css/profil.css"> <!-- Tambahkan file CSS profil -->
</head>

<body>
    <?php include 'sidebar.php'; ?>
    <section class="home">
        <div class="profil-container">
            <div class="profil-info">
                <div class="profil-foto">
                    <img src="<?php echo $profilFoto; ?>" alt="Profil Foto">
                    <!-- Form untuk mengganti foto profil (tambahkan fungsi penggantian sesuai kebutuhan) -->
                    <form action="edit_profil.php" method="post" enctype="multipart/form-data">
                        <input type="file" name="profilFoto" accept="image/*">
                        <button type="submit">Edit Foto</button>
                    </form>
                    <a href="registrasiadm.php">Registrasi Admin?</a>
                </div>

                <div class="profil-text">
                    <h2><?php echo $namaAdmin; ?></h2>
                    <p><?php echo $namaJabatan; ?></p>
                </div>
            </div>
        </div>
    </section>

    <script src="js/script.js"></script>
</body>

</html>
