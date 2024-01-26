<?php
session_start();

if (!isset($_SESSION['ceklogin']) || $_SESSION['ceklogin'] !== true) {
    header("Location: index.php");
    exit();
}

require 'koneksi.php';

// Dapatkan parameter tanggal dari URL
$tanggal = isset($_GET['tanggal']) ? $_GET['tanggal'] : date('Y-m-d');

// Query untuk mendapatkan detail tamu pada tanggal tertentu
$query = "SELECT history.*, tamu.nama_tamu, tamu.jk, tamu.no_hp, tamu.alamat, tamu.email_tamu
          FROM history 
          INNER JOIN tamu ON history.id_tamu = tamu.id_tamu
          WHERE DATE(history.waktu_datang) = '$tanggal'";

$result = mysqli_query($koneksi, $query);

if (!$result) {
    die("Query error: " . mysqli_error($koneksi));
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css/admin.css">
</head>

<body>
    <?php include 'sidebar.php'; ?>
    <section class="home">
        <div class="text">
            <i class='bx bx-calendar'></i> Detail Tamu Hari Ini (<?php echo $tanggal; ?>)
        </div>
        <div class="table-container">
            <!-- Tampilkan detail di sini, misalnya dalam sebuah tabel -->
            <?php if (mysqli_num_rows($result) > 0) : ?>
                <table class="table table-bordered" id="table1">
                    <!-- Header tabel di sini -->
                    <tr>
                        <th>Nama Tamu</th>
                        <th>Jenis Kelamin</th>
                        <th>No. HP</th>
                        <th>Alamat</th>
                        <th>Email</th>
                        <th>Keperluan</th>
                        <th>Tanggal</th>
                        <th>Waktu Datang</th>
                        <th>Waktu Pulang</th>
                        <!-- Tambahkan kolom lain sesuai kebutuhan -->
                    </tr>
                    <!-- Tampilkan data dari hasil JOIN -->
                    <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                        <tr>
                            <td><?php echo $row['nama_tamu']; ?></td>
                            <td><?php echo $row['jk']; ?></td>
                            <td><?php echo $row['no_hp']; ?></td>
                            <td><?php echo $row['alamat']; ?></td>
                            <td><?php echo $row['email_tamu']; ?></td>
                            <td><?php echo $row['keperluan']; ?></td>
                            <td><?php echo $row['tanggal']; ?></td>
                            <td><?php echo $row['waktu_datang']; ?></td>
                            <td><?php echo $row['waktu_pulang']; ?></td>
                            <!-- Tambahkan kolom lain sesuai kebutuhan -->
                        </tr>
                    <?php endwhile; ?>
                </table>
            <?php else : ?>
                <p>Tidak ada data untuk tanggal ini.</p>
            <?php endif; ?>
        </div>
    </section>
    <script src="js/script.js"></script>
</body>

</html>
