<?php
require 'koneksi.php';
$status = 'SELECT * FROM status';
$exec = mysqli_query($koneksi, $status);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSS -->
    <link rel="stylesheet" href="css/tamu.css">

    <!-- Box icon -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <!-- Iconscout CSS -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

    <style>
        /* Added style for the login button */
        .login-button {
            margin-right: 20px;
            text-decoration: none;
            color: #333;
            font-weight: bold;
        }
    </style>

    <title>Form Tamu</title>
</head>

<body>
    <div class="container">
    <a href="index.php" class="login-button">Login</a>
        <header> 
            Registrasi Tamu
            <span class="image">
                <img src="img/Lepa.gif" alt="logo">
            </span>
        </header>

        <form action="proses_form2.php" method="POST">
            <div class="form first">
                <div class="details personal">
                    <span class="title">Lengkapi Form Dibawah!</span>
                    <div class="fields">
                        
                        <div class="input-field">
                            <label>Nama Lengkap</label>
                            <input type="text" placeholder="Masukkan nama" name="nama_tamu" required>
                        </div>

                        <div class="input-field">
                            <label>Status</label>
                            <select name="nama_status" required>
                                <option value="" disabled selected>Pilih Status</option>
                                <?php
                                while ($data = mysqli_fetch_array($exec)) {
                                    echo "<option value='$data[id_status]'>$data[nama_status]</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="input-field">
                            <label>Tanggal</label>
                            <input type="date" placeholder="Tanggal Bertamu" name="tanggal" required>
                        </div>

                        <div class="input-field">
                            <label>Keperluan</label>
                            <input type="text" placeholder="Tulis Keperluan" name="keperluan" required>
                        </div>

                        <div class="input-field">
                            <label>NO HP</label>
                            <input type="number" placeholder="Masukkan No HP" name="no_hp" required>
                        </div>

                        <div class="input-field">
                            <label>Email</label>
                            <input type="email" placeholder="Masukkan Email" name="email_tamu" required>
                        </div>

                        <div class="input-field">
                            <label>Jenis Kelamin</label>
                            <select name="jk" required>
                                <option value="" disabled selected>Pilih jenis kelamin</option>
                                <option value="Laki-Laki">Laki-Laki</option>
                                <option value="Perempuan">Perempuan</option>

                            </select>
                        </div>

                        <div class="input-field">
                            <label>Alamat</label>
                            <input type="text" placeholder="Masukkan Alamat" name="alamat" required>
                        </div>

                        <div class="input-field">
                            <label>Waktu Datang</label>
                            <input type="datetime-local" name="waktu_datang" required>
                        </div>

                        <div class="input-field">
                            <label>Waktu Pulang</label>
                            <input type="datetime-local" name="waktu_pulang" required>
                        </div>
                    </div>
                    </div>
                    <div class="buttons">
                        <div class="nextBtn">
                            <button type="reset"> <span class="btnText">Batal</span>
                            </button>
                        </div>

                        <button class="nextBtn" name="kirim" type="submit">
                            <span class="btnText">Kirim</span>
                            <i class="uil uil-navigator"></i>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</body>

</html>
