<?php
session_start();

if (!isset($_SESSION['ceklogin']) || $_SESSION['ceklogin'] !== true) {
    header("Location: index.php");
    exit();
}

require 'koneksi.php';

// Dapatkan parameter id_tamu dari URL
$id_tamu = isset($_GET['email']) ? $_GET['email'] : null;

// Query untuk mendapatkan keperluan kunjungan berdasarkan id_tamu
// $query = "SELECT keperluan FROM history WHERE id_tamu = '$id_tamu'";
$query = "SELECT history.*, tamu.* FROM history RIGHT JOIN tamu ON history.id_tamu = tamu.id_tamu WHERE tamu.email_tamu = '$id_tamu' ";
$result = mysqli_query($koneksi, $query);

if (!$result) {
    die("Query error: " . mysqli_error($koneksi));
}

// Menyimpan hasil query ke dalam array
$dataKeperluan = [];
while ($row = mysqli_fetch_assoc($result)) {
    $dataKeperluan[] = $row['keperluan'];
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

    <!-- My style -->
    <link rel="stylesheet" href="css/admin.css">
</head>

<body>
    <?php include 'sidebar.php'; ?>
    <section class="home">
        <div class="text"><i class='bx bx-notepad'></i> Detail Kunjungan</div>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Keperluan Kunjungan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    foreach ($dataKeperluan as $keperluan) {
                        echo "<tr>
                                <td>{$no}</td>
                                <td>{$keperluan}</td>
                            </tr>";
                        $no++;
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </section>
</body>

</html>