<?php
require'koneksi.php';
$queryJabatan = "SELECT id_jabatan, nama_jabatan FROM jabatan";
$resultJabatan = mysqli_query($koneksi, $queryJabatan);
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css/registrasiadm.css">
    <title>Registrasi Admin</title>
</head>

<body>
    <div class="container">
        <div class="title"><a href="profil.php"><i class='bx bx-chevron-left-circle back'></i></a>Registrasi Admin</div>
        <form action="proses_form.php" method="POST">
            <div class="user-details">
                <div class="input-box">
                    <span class="details">Nama Lengkap</span>
                    <input type="text" name="nama_admin" placeholder="Masukkan nama lengkap" required>
                </div>
                <div class="input-box">
                    <span class="details">Jabatan</span>
                    <div class="select">
                        <select name="nama_jabatan" required>
                            <option value="" disabled selected>Pilih Jabatan</option>
                            <?php
                            while ($dataJabatan = mysqli_fetch_array($resultJabatan)) {
                                echo "<option value='" . $dataJabatan['nama_jabatan'] . "'>" . $dataJabatan['nama_jabatan'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <input type="hidden" name="id_jabatan" id="id_jabatan" value="">
                </div>
                <div class="input-box">
                    <span class="details">Tanggal Lahir</span>
                    <input style="width: 220px;" type="date" name="tanggal_lahir" id="tanggal" placeholder="Masukkan tanggal lahir" required>
                </div>
                <div class="input-box">
                    <span class="details">Email</span>
                    <input type="text" name="email_adm" placeholder="Masukkan email" required>
                </div>
                <div class="input-box">
                    <span class="details">No HP</span>
                    <input type="number" name="no_hp_adm" placeholder="Masukkan no hp" required>
                </div>
                <div class="input-box">
                    <span class="details">Alamat</span>
                    <input type="text" name="alamat_admin" placeholder="Masukkan alamat lengkap" required>
                </div>
                <div class="input-box">
                    <span class="details">Username</span>
                    <input type="text" name="username" placeholder="Masukkan username" required>
                </div>
                <div class="input-box">
                    <span class="details">Password</span>
                    <input type="password" name="password" placeholder="Masukkan password" required>
                </div>
                <div class="input-box">
                    <span class="details">Konfirmasi Password</span>
                    <input type="password" name="confirmpassword" placeholder="Konfirmasi password" required>
                </div>
            </div>
            <div class="gender-details">
                <input type="radio" name="Jk_admin" id="dot-1" value="Laki-Laki">
                <input type="radio" name="Jk_admin" id="dot-2" value="Perempuan">
                <span class="gender-title">Jenis Kelamin</span>
                <div class="category">
                    <label for="dot-1">
                        <span class="dot one"></span>
                        <span class="gender">Pria</span>
                    </label>
                    <label for="dot-2">
                        <span class="dot two"></span>
                        <span class="gender">Wanita</span>
                    </label>
                </div>
            </div>
            <div class="button">
                <input type="submit" name="kirim" value="Kirim">
            </div>
        </form>
        <script>
            document.querySelector('[name="nama_jabatan"]').addEventListener('change', function() {
                var selectedOption = this.options[this.selectedIndex];
                document.getElementById('id_jabatan').value = selectedOption.value;
            });
        </script>
    </div>
    
</body>

</html>
