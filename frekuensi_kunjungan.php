<?php
session_start(); // Mulai sesi

// Pengecekan apakah pengguna telah login
if (!isset($_SESSION['ceklogin']) || $_SESSION['ceklogin'] !== true) {
    header("Location: index.php"); // Redirect ke halaman login jika belum login
    exit();
}

require 'koneksi.php';

// Fungsi untuk mendapatkan frekuensi kunjungan dengan paginasi
function getFrekuensiKunjungan($page, $limit)
{
    global $koneksi;

    // Hitung offset berdasarkan halaman dan limit
    $offset = ($page - 1) * $limit;

    // Query untuk mengambil data tamu dan history dengan paginasi
    $query = "SELECT t.id_tamu, t.nama_tamu, t.nama_status, t.no_hp, t.jk, t.alamat, t.email_tamu,
                     COUNT(h.id_history) AS jumlah_kunjungan
              FROM tamu t
              LEFT JOIN history h ON t.id_tamu = h.id_tamu
              GROUP BY t.nama_tamu, t.nama_status, t.no_hp, t.jk, t.alamat, t.email_tamu
              ORDER BY jumlah_kunjungan ASC, t.email_tamu
              LIMIT $limit OFFSET $offset";

    $result = mysqli_query($koneksi, $query);

    // Menyimpan hasil query ke dalam array
    $dataFrekuensi = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $dataFrekuensi[] = $row;
    }

    return $dataFrekuensi;
}

// Set jumlah data per halaman
$limit = 10;

// Set halaman default jika tidak ada parameter halaman
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Memanggil fungsi untuk mendapatkan data frekuensi kunjungan dengan paginasi
$frekuensiKunjungan = getFrekuensiKunjungan($page, $limit);
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

    <style>
        /* Add your additional styles here */
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
</head>

<body>
    <?php
    include 'sidebar.php'
    ?>
    <section class="home">
        <div class="text"><i class='bx bx-notepad'></i>Frekuensi Kunjungan</div>
        <div class="table-container">
            <input type="button" value="Export Excel" onclick="window.open('laporan-excel.php')">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Email Tamu</th>
                        <th hidden>id_tamu</th>
                        <th>Status</th>
                        <th>Jenis Kelamin</th>
                        <th>Alamat</th>
                        <th>Jumlah Kunjungan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    foreach ($frekuensiKunjungan as $data) {
                        echo "<tr>
                                <td>{$no}</td>
                                <td>{$data['email_tamu']}</td>
                                <td hidden>{$data['id_tamu']}</td>
                                <td>{$data['nama_status']}</td>
                                <td>{$data['jk']}</td>
                                <td>{$data['alamat']}</td>
                                <td><a href='detail_kunjungan.php?email={$data['email_tamu']}'>{$data['jumlah_kunjungan']}</a></td>
                            </tr>";
                        $no++;
                    }
                    ?>
                </tbody>
            </table>

            <!-- Menampilkan tombol paginasi -->
            <div class="pagination">
                <?php
                $total_rows_query = "SELECT COUNT(DISTINCT nama_tamu) as total FROM tamu";
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
</body>

</html>