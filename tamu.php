<?php
session_start(); // Mulai sesi

// Pengecekan apakah pengguna telah login
if (!isset($_SESSION['ceklogin']) || $_SESSION['ceklogin'] !== true) {
    header("Location: index.php"); // Redirect ke halaman login jika belum login
    exit();
}

require 'koneksi.php';

// Fungsi untuk melakukan pencarian
function cari($keyword)
{
    global $koneksi;
    $query = "SELECT t.*, s.nama_status
              FROM tamu t
              JOIN status s ON t.id_status = s.id_status
              WHERE t.nama_tamu LIKE '%$keyword%' OR t.no_hp LIKE '%$keyword%' OR t.alamat LIKE '%$keyword%'";

    $result = mysqli_query($koneksi, $query);

    if (!$result) {
        die("Query error: " . mysqli_error($koneksi));
    }

    return $result;
}

// Buat query untuk mengambil data tamu dan status dengan paginasi
$limit = 10; // Jumlah data per halaman
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$query = "SELECT t.*, s.nama_status
          FROM tamu t
          JOIN status s ON t.id_status = s.id_status
          ORDER BY t.id_tamu
          LIMIT $limit OFFSET $offset";

// Jika tombol cari ditekan, panggil fungsi cari
if (isset($_POST["cari"])) {
    $result = cari($_POST["keyword"]);
} else {
    // Jika tidak, eksekusi query seperti biasa
    $result = mysqli_query($koneksi, $query);

    // Cek apakah query berhasil dieksekusi
    if (!$result) {
        die("Query error: " . mysqli_error($koneksi));
    }
}

if (isset($_POST["submit"])) {
    $checkedIds = isset($_POST['kedatangan']) ? $_POST['kedatangan'] : [];

    foreach ($checkedIds as $idTamu) {
        $updateQuery = "UPDATE tamu SET kedatangan = 1 WHERE id_tamu = $idTamu";
        $updateResult = mysqli_query($koneksi, $updateQuery);

        if (!$updateResult) {
            die("Update error: " . mysqli_error($koneksi));
        }
    }

    // Setelah pembaruan, redirect atau lakukan tindakan lain yang diinginkan
    header("Location: tamu.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- boxicon css -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <!-- My style -->
    <link rel="stylesheet" href="css/admin.css">
</head>

<body>
    <?php include 'sidebar.php' ?>
    <section class="home">
        <div class="text"><i class='bx bx-user'></i>Tamu Minori</div>
        <div class="search-container">
            <label for="search" id="kata">Search:</label>
            <form action="" method="post">
                <input type="text" id="search" name="keyword" placeholder="Masukkan pencarian..." autocomplete="">
                <button type="submit" name="cari">Cari!</button>
            </form>
        </div>
        <div class="table-container">
            <form action="" method="post">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th hidden>Id Tamu</th>
                            <th>Status</th>
                            <th>Nama Tamu</th>
                            <th>Jenis Kelamin</th>
                            <th>NO HP</th>
                            <th>Email</th>
                            <th>Alamat</th>
                            <th>Kedatangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        while ($result && $row = mysqli_fetch_assoc($result)) {
                        ?>
                            <tr>
                                <td><?php echo $no; ?></td>
                                <td hidden><?php echo $row['id_tamu']; ?></td>
                                <td><?php echo $row['nama_status']; ?></td>
                                <td><?php echo $row['nama_tamu']; ?></td>
                                <td><?php echo $row['jk']; ?></td>
                                <td><?php echo $row['no_hp']; ?></td>
                                <td><?php echo $row['email_tamu']; ?></td>
                                <td><?php echo $row['alamat']; ?></td>
                                <td>
                                    <input type="checkbox" name="kedatangan[]" value="<?php echo $row['id_tamu']; ?>" <?php echo $row['kedatangan'] == 1 ? 'checked' : ''; ?>>
                                    <?php echo $row['kedatangan'] == 1 ? 'Sudah Bertamu' : 'Belum Bertamu'; ?>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <div class="edit"><a href="edit_tamu.php?id_tamu=<?= $row["id_tamu"]; ?>">Edit </a></div>
                                        <div class="hapus"><a href="hapus.php?id_tamu=<?= $row["id_tamu"]; ?>">Hapus</a></div>
                                    </div>
                                </td>
                            </tr>
                        <?php
                            $no++;
                        }
                        ?>
                    </tbody>
                </table>
                <div class="pagination">
                    <?php
                    // Hitung jumlah halaman
                    $total_rows_query = "SELECT COUNT(*) as total FROM tamu";
                    $total_rows_result = mysqli_query($koneksi, $total_rows_query);
                    $total_rows = mysqli_fetch_assoc($total_rows_result)['total'];
                    $total_pages = ceil($total_rows / $limit);

                    // Tampilkan tombol Previous Page jika tidak di halaman pertama
                    if ($page > 1) {
                        echo '<a href="?page=' . ($page - 1) . '">Halaman sebelumnya</a>';
                    }

                    // Tampilkan tombol Next Page jika tidak di halaman terakhir
                    if ($page < $total_pages) {
                        echo '<a href="?page=' . ($page + 1) . '">Halaman selanjutnya</a>';
                    }
                    ?>
                </div>
                <button type="submit" name="submit">Update Kedatangan</button>
            </form>
        </div>
    </section>

    <style>
        .pagination {
            display: flex;
            justify-content: flex-end;
            margin-top: 10px;
            /* Sesuaikan dengan jarak yang diinginkan */
        }

        .pagination a {
            margin-left: 10px;
            /* Sesuaikan dengan jarak antar tombol */
        }
    </style>

    <script src="js/script.js"></script>
    <style>
        .action-buttons {
            display: flex;
        }

        .edit,
        .hapus {
            margin-right: 10px;
            /* Sesuaikan dengan jarak antar tombol */
        }
    </style>
</body>

</html>