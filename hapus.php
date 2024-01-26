<!DOCTYPE html>
<html lang="en">

<head>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <?php

    // Fungsi untuk menghapus data tamu
    function hapus($id)
    {
        global $koneksi;

        // Lakukan operasi penghapusan data tamu berdasarkan id_tamu
        $query = "DELETE FROM tamu WHERE id_tamu = '$id'";
        $result = mysqli_query($koneksi, $query);

        // Cek apakah operasi penghapusan berhasil
        if ($result) {
            return mysqli_affected_rows($koneksi);
        } else {
            return -1; // Mengembalikan nilai negatif jika terjadi kesalahan
        }
    }

    // Ambil data dari sini
    require 'koneksi.php';

    // Ambil id_tamu dari parameter GET
    $id = $_GET["id_tamu"];

    // Panggil fungsi hapus dengan parameter id_tamu
    if (hapus($id) > 0) {
        echo "
    <script>
      Swal.fire({
        title: 'Anda Yakin',
        text: 'Anda tidak akan dapat mengembalikan ini!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya,Hapus Aja !'
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
    ?>
</body>

</html>