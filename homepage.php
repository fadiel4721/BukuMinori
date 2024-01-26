<?php
session_start(); // Mulai sesi

// Pengecekan apakah pengguna telah login
if (!isset($_SESSION['ceklogin']) || $_SESSION['ceklogin'] !== true) {
    header("Location: index.php"); // Redirect ke halaman login jika belum login
    exit();
}

require 'koneksi.php';

function getTamuCountByPeriod($period)
{
    global $koneksi;

    $query = "";

    switch ($period) {
        case 'hari':
            $query = "SELECT COUNT(*) as total FROM history WHERE DATE(waktu_datang) = CURDATE()";
            break;
        case 'minggu':
            $query = "SELECT COUNT(*) as total FROM history WHERE YEARWEEK(waktu_datang, 1) = YEARWEEK(CURDATE(), 1)";
            break;
        case 'bulan':
            $query = "SELECT COUNT(*) as total FROM history WHERE MONTH(waktu_datang) = MONTH(CURDATE()) AND YEAR(waktu_datang) = YEAR(CURDATE())";
            break;
        case 'keseluruhan':
            $query = "SELECT COUNT(*) as total FROM history";
            break;
        default:
            break;
    }

    if ($query !== "") {
        $result = mysqli_query($koneksi, $query);

        if ($result) {
            $row = mysqli_fetch_assoc($result);
            return $row['total'];
        }
    }

    return 0;
}

// Fungsi tambahan untuk minggu ini
function getTamuCountThisWeek()
{
    global $koneksi;

    $query = "SELECT COUNT(*) as total FROM history WHERE YEARWEEK(waktu_datang, 1) = YEARWEEK(CURDATE(), 1)";

    $result = mysqli_query($koneksi, $query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        return $row['total'];
    }

    return 0;
}

// Fungsi tambahan untuk bulan ini
function getTamuCountThisMonth()
{
    global $koneksi;

    $query = "SELECT COUNT(*) as total FROM history WHERE MONTH(waktu_datang) = MONTH(CURDATE()) AND YEAR(waktu_datang) = YEAR(CURDATE())";

    $result = mysqli_query($koneksi, $query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        return $row['total'];
    }

    return 0;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- boxicon css -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <link rel="stylesheet" href="css/admin.css">
</head>

<body>
    <?php include 'sidebar.php'; ?>
    <section class="home">
        <div class="text">
            <i class='bx bx-calendar'></i> Statistik Tamu
        </div>
        <div class="table-container">
            <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4"></h1>
            </div>
            <table class="table table-bordered" id="table1">
                <tr>
                    <td>
                        <i class='bx bx-user'></i> Hari Ini
                    </td>
                    <td>: <a href="detail.php?tanggal=<?php echo date('Y-m-d'); ?>"><?php echo getTamuCountByPeriod('hari'); ?></a></td>
                </tr>
                <tr>
                    <td><i class='bx bx-trending-up'></i></i> Minggu Ini</td>
                    <td>: <a href="detail_minggu.php?tanggal=<?php echo date('Y-m-d'); ?>"><?php echo getTamuCountThisWeek(); ?></a></td>
                </tr>
                <tr>
                    <td><i class='bx bxs-objects-vertical-bottom'></i> Bulan Ini</td>
                    <td>: <a href="detail_bulan.php?tanggal=<?php echo date('Y-m-d'); ?>"><?php echo getTamuCountThisMonth(); ?></a></td>
                </tr>
                <tr>
                    <td><i class='bx bx-calendar-week'></i> Keseluruhan</td>
                    <td>: <?php echo getTamuCountByPeriod('keseluruhan'); ?></td>
                </tr>
            </table>
        </div>
    </section>

    <script src="js/script.js"></script>
</body>

</html>
