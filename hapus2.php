<!DOCTYPE html>
<html lang="en">

<head>
  <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
<?php
// history.php

// Ambil data dari sini
require 'koneksi.php';

// Ambil id_history dari parameter GET
$id_history = $_GET["id_history"];

// Panggil fungsi hapus dengan parameter id_history
if (hapus($id_history)) {
    echo "
    <script>
      Swal.fire({
        title: 'Anda Yakin?',
        text: 'Anda tidak akan dapat mengembalikan ini!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Hapus aja!'
      }).then((result) => {
        if (result.isConfirmed) {
          Swal.fire({
            title: 'Deleted!',
            text: 'File Anda Sudah Terhapus.',
            icon: 'success'
          }).then(() => {
            // Redirect to tamu.php after successful deletion
            window.location.href = 'tamu.php';
          });
        }
      });
    </script>";
  } else {
    echo "
    <script>
      Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'Data failed to be deleted.'
      }).then(() => {
        // Redirect to tamu.php after failed deletion
        window.location.href = 'tamu.php';
      });
    </script>";
  }


// Fungsi untuk menghapus data history dan tamu
function hapus($id_history)
{
    global $koneksi;

    // Ambil id_tamu berdasarkan id_history
    $queryGetIdTamu = "SELECT id_tamu FROM history WHERE id_history = '$id_history'";
    $resultGetIdTamu = mysqli_query($koneksi, $queryGetIdTamu);

    // Cek apakah query untuk mendapatkan id_tamu berhasil dieksekusi
    if (!$resultGetIdTamu) {
        return false;
    }

    // Ambil id_tamu dari hasil query
    $row = mysqli_fetch_assoc($resultGetIdTamu);
    $id_tamu = $row['id_tamu'];

    // Lakukan operasi penghapusan data tamu berdasarkan id_tamu
    $queryTamu = "DELETE FROM tamu WHERE id_tamu = '$id_tamu'";
    $resultTamu = mysqli_query($koneksi, $queryTamu);

    // Lakukan operasi penghapusan data history berdasarkan id_history
    $queryHistory = "DELETE FROM history WHERE id_history = '$id_history'";
    $resultHistory = mysqli_query($koneksi, $queryHistory);

    // Cek apakah kedua operasi penghapusan berhasil
    if ($resultTamu && $resultHistory) {
        return true;
    } else {
        return false; // Mengembalikan nilai false jika terjadi kesalahan
    }
}
?>
