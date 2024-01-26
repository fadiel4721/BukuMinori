<?php
session_start(); // Mulai sesi

// Pengecekan apakah pengguna telah login
if (!isset($_SESSION['ceklogin']) || $_SESSION['ceklogin'] !== true) {
    header("Location: index.php"); // Redirect ke halaman login jika belum login
    exit();
}

require 'koneksi.php';
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

    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fc;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .welcome-container {
            text-align: center;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #4e73df;
        }
    </style>
</head>

<body>
    <?php include 'sidebar.php'; ?>
    <section class="home">
        <div class="text">
            <div class="table-container">
                <div class="text-center welcome-container">
                    <h1>Selamat Datang di Halaman Admin Buku Tamu PT Minori</h1>
                    <img src="img/Lepa.gif" alt="Logo PT Minori" style="max-width: 100%; height: auto; margin-top: 20px;">
                </div>
            </div>
        </div>
    </section>

    <script src="js/script.js"></script>
</body>

</html>
