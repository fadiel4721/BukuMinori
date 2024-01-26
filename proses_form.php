<?php
session_start(); // Mulai session

require 'koneksi.php';

if (isset($_POST['kirim'])) {
    // Variabel dari formulir
    $nama_admin = $_POST['nama_admin'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $Jk_admin = $_POST['Jk_admin'];
    $no_hp_adm = $_POST['no_hp_adm'];
    $email_adm = $_POST['email_adm'];
    $alamat_admin = $_POST['alamat_admin'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $nama_jabatan = $_POST['nama_jabatan'];

    // Hash password sebelum disimpan ke database
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert ke tabel 'user'
    $queryUser = "INSERT INTO user (username, password)
                  VALUES ('$username', '$hashedPassword')";

    // Eksekusi query untuk tabel 'user'
    $resultUser = mysqli_query($koneksi, $queryUser);

    // Cek apakah query 'user' berhasil dieksekusi
    if (!$resultUser) {
        die("Error in inserting user data: " . mysqli_error($koneksi));
    }

    // Ambil ID terakhir yang di-generate oleh query INSERT ke tabel 'user'
    $lastUserID = mysqli_insert_id($koneksi);

    // Ambil ID dan Nama jabatan dari tabel jabatan berdasarkan nama jabatan
    $queryJabatan = "SELECT id_jabatan, nama_jabatan FROM jabatan WHERE nama_jabatan = '$nama_jabatan'";
    $resultJabatan = mysqli_query($koneksi, $queryJabatan);

    // Cek apakah query 'jabatan' berhasil dieksekusi
    if (!$resultJabatan) {
        die("Error in fetching jabatan data: " . mysqli_error($koneksi));
    }

    // Ambil ID dan Nama jabatan dari hasil query
    $rowJabatan = mysqli_fetch_assoc($resultJabatan);
    if (!$rowJabatan) {
        die("No matching jabatan found for name: $nama_jabatan");
    }

    $jabatanID = $rowJabatan['id_jabatan'];
    $jabatanNama = $rowJabatan['nama_jabatan'];

    // Insert ke tabel 'admin' dengan menggunakan ID yang diambil sebelumnya dan data lainnya
    $queryAdmin = "INSERT INTO admin (id_user, nama_admin, Jk_admin, tanggal_lahir, no_hp_adm, id_jabatan, nama_jabatan, alamat_admin, email_adm)
                   VALUES ('$lastUserID', '$nama_admin', '$Jk_admin', '$tanggal_lahir', '$no_hp_adm', '$jabatanID', '$jabatanNama', '$alamat_admin', '$email_adm')";

    // Eksekusi query untuk tabel 'admin'
    $resultAdmin = mysqli_query($koneksi, $queryAdmin);

    // Cek apakah query 'admin' berhasil dieksekusi
    if (!$resultAdmin) {
        die("Error in inserting admin data: " . mysqli_error($koneksi));
    }

    // Ambil ID terakhir yang di-generate oleh query INSERT ke tabel 'admin'
    $lastAdminID = mysqli_insert_id($koneksi);

    // Insert ke tabel 'profil' dengan menggunakan ID admin yang diambil sebelumnya dan data lainnya
    $queryProfil = "INSERT INTO profil (id_admin, id_jabatan, nama_admin, nama_jabatan)
                    VALUES ('$lastAdminID', '$jabatanID', '$nama_admin', '$jabatanNama')";

    // Eksekusi query untuk tabel 'profil'
    $resultProfil = mysqli_query($koneksi, $queryProfil);

    // Cek apakah query 'profil' berhasil dieksekusi
    if (!$resultProfil) {
        die("Error in inserting profil data: " . mysqli_error($koneksi));
    }

    // Tampilkan pesan sukses dan redirect
    echo '<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>';
    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
    echo '<script>
            $(document).ready(function() {
                Swal.fire({
                    icon: "success",
                    title: "Registrasi Berhasil!",
                    showConfirmButton: false,
                    timer: 3000
                }).then(function() {
                    window.location.href = "index.php";
                });
            });
          </script>';
}
?>
