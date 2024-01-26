<?php
session_start();

// Pengecekan apakah pengguna telah login
if (!isset($_SESSION['ceklogin']) || $_SESSION['ceklogin'] !== true) {
    header("Location: index.php"); // Redirect ke halaman login jika belum login
    exit();
}

require 'koneksi.php';

// Ambil username dari sesi yang sudah login
$username = $_SESSION['username'];

// Ambil ID admin dari tabel user
$queryGetAdminID = "SELECT id_admin FROM admin WHERE id_user IN (SELECT id_user FROM user WHERE username = '$username')";
$resultGetAdminID = mysqli_query($koneksi, $queryGetAdminID);

if (!$resultGetAdminID) {
    die("Error in fetching admin ID: " . mysqli_error($koneksi));
}

$rowAdminID = mysqli_fetch_assoc($resultGetAdminID);
$idAdmin = $rowAdminID['id_admin'];

// Upload foto profil
if (isset($_FILES['profilFoto'])) {
    $file_name = $_FILES['profilFoto']['name'];
    $file_size = $_FILES['profilFoto']['size'];
    $file_tmp = $_FILES['profilFoto']['tmp_name'];
    $file_type = $_FILES['profilFoto']['type'];
    
    $extensions = array("jpeg", "jpg", "png");

    $temp = explode(".", $file_name);
    $file_ext = end($temp);

    if (in_array($file_ext, $extensions) === false) {
        $_SESSION['error_message'] = "Extension not allowed, please choose a JPEG or PNG file.";
        header("Location: edit_profil.php");
        exit();
    }

    if ($file_size > 2097152) {
        $_SESSION['error_message'] = "File size must be less than 2 MB";
        header("Location: edit_profil.php");
        exit();
    }

    $upload_dir = "uploads/"; // Ganti dengan path direktori upload yang sesuai

    $new_file_name = "profil_" . $idAdmin . "." . $file_ext;
    $upload_path = $upload_dir . $new_file_name;

    move_uploaded_file($file_tmp, $upload_path);
    
    // Simpan path foto profil ke tabel profil
    $queryUpdateProfil = "UPDATE profil SET foto_profil = '$upload_path' WHERE id_admin = '$idAdmin'";
    $resultUpdateProfil = mysqli_query($koneksi, $queryUpdateProfil);

    if (!$resultUpdateProfil) {
        $_SESSION['error_message'] = "Error in updating profil information: " . mysqli_error($koneksi);
    }

    // Redirect ke halaman profil setelah berhasil mengganti foto
    header("Location: profil.php");
    exit();
} else {
    // Jika tidak ada file yang diunggah, berikan pesan kesalahan
    $_SESSION['error_message'] = "No file selected.";
    header("Location: edit_profil.php");
    exit();
}
?>
