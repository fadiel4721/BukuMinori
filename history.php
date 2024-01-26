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

    // Buat query untuk mengambil data history
    $query = "SELECT h.*, s.nama_status, t.nama_tamu
              FROM history h
              JOIN status s ON h.id_status = s.id_status
              JOIN tamu t ON h.id_tamu = t.id_tamu
              WHERE h.id_history LIKE '%$keyword%' OR h.keperluan LIKE '%$keyword%'";

    // Eksekusi query
    $result = mysqli_query($koneksi, $query);

    // Cek apakah query berhasil dieksekusi
    if (!$result) {
        die("Query error: " . mysqli_error($koneksi));
    }

    return $result;
}

// Buat query untuk mengambil data history dengan paginasi
$limit = 10; // Jumlah data per halaman
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$query = "SELECT h.*, s.nama_status, t.nama_tamu, t.kedatangan
          FROM history h
          JOIN status s ON h.id_status = s.id_status
          JOIN tamu t ON h.id_tamu = t.id_tamu
          ORDER BY  h.id_history
          LIMIT $limit OFFSET $offset";

// Ketika tombol cari ditekan
if (isset($_POST["cari"])) {
    $result = cari($_POST["keyword"]);
} else {
    // Jika tidak ada pencarian, ambil semua data
    $result = mysqli_query($koneksi, $query);

    // Cek apakah query berhasil dieksekusi
    if (!$result) {
        die("Query error: " . mysqli_error($koneksi));
    }
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
    <?php include 'sidebar.php'; ?>
    <section class="home">
        <div class="text"><i class='bx bx-notepad'></i>History Tamu</div>
        <div class="search-container">
            <label for="search" id="kata">Search:</label>
            <form action="" method="post">
                <input type="text" id="search" name="keyword" placeholder="Masukkan pencarian..." autocomplete="">
                <button type="submit" name="cari">Cari!</button>
            </form>
        </div>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th hidden>Id History</th>
                        <th hidden>Id Status</th>
                        <th hidden>Id Tamu</th>
                        <th>Keperluan</th>
                        <th width="150">Tanggal</th>
                        <th>Waktu Datang</th>
                        <th>Waktu Pulang</th>
                        <th>Status Kedatangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Loop through the result set
                    $no = 1;
                    while ($row = mysqli_fetch_assoc($result)) {
                        // Memeriksa status pengajuan
                        $status_pengajuan = $row['kedatangan'] == '1' ? 'Sudah Bertamu' : 'Belum Bertamu';
                    ?>
                        <tr>
                            <td><?php echo $no; ?></td>
                            <td hidden><?php echo $row['id_history']; ?></td>
                            <td hidden><?php echo $row['id_status']; ?></td>
                            <td hidden><?php echo $row['id_tamu']; ?></td>
                            <td><?php echo $row['keperluan']; ?></td>
                            <td><?php echo $row['tanggal']; ?></td>
                            <td><?php echo $row['waktu_datang']; ?></td>
                            <td><?php echo $row['waktu_pulang']; ?></td>
                            <td><?php echo $status_pengajuan; ?></td>
                            <td>
                                <div class="action-buttons">
                                    <div class="edit"><a href="edit_history.php?id_history=<?= $row["id_history"]; ?>">Edit </a></div>
                                    <div class="hapus"><a href="hapus2.php?id_history=<?= $row["id_history"]; ?>">Hapus</a></div>
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
                $total_rows_query = "SELECT COUNT(*) as total FROM history";
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