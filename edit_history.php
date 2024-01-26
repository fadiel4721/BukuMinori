<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Tamu</title>
    <!-- CSS -->
    <link rel="stylesheet" href="css/edit.css">
    <script src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
<?php
require 'koneksi.php';

// Periksa apakah id_history diberikan pada parameter query
if (isset($_GET['id_history'])) {
    $id_history = $_GET['id_history'];

    // Query untuk mengambil data record yang akan diedit
    $query = "SELECT * FROM history WHERE id_history = $id_history";
    $result = mysqli_query($koneksi, $query);

    // Periksa apakah query berhasil dieksekusi
    if ($result) {
        $row = mysqli_fetch_assoc($result);
    } else {
        die("Kesalahan query: " . mysqli_error($koneksi));
    }
} else {
    // Jika id_history tidak diberikan, redirect ke halaman utama atau sesuaikan sesuai kebutuhan
    header("Location: history.php");
    exit();
}

// Handle pengiriman formulir untuk memperbarui record
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validasi dan sanitasi input field
    // Lakukan validasi dan sanitasi yang diperlukan di sini

    // Perbarui record di database
    $updated_keperluan = $_POST['keperluan'];
    $updated_tanggal = $_POST['tanggal'];
    $updated_waktu_datang = $_POST['waktu_datang'];
    $updated_waktu_pulang = $_POST['waktu_pulang'];

    // Format waktu sesuai dengan kebutuhan Anda
    $updated_waktu_datang = date("Y-m-d H:i:s", strtotime($updated_waktu_datang));
    $updated_waktu_pulang = date("Y-m-d H:i:s", strtotime($updated_waktu_pulang));

    $update_query = "UPDATE history SET 
                        keperluan = '$updated_keperluan', 
                        tanggal = '$updated_tanggal', 
                        waktu_datang = '$updated_waktu_datang', 
                        waktu_pulang = '$updated_waktu_pulang' 
                    WHERE id_history = $id_history";
    
    $update_result = mysqli_query($koneksi, $update_query);

    // Periksa apakah perbaruan berhasil
    if ($update_result) {
        echo "
        <script>
        Swal.fire({
            title: 'Do you want to save the changes?',
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: 'Save',
            denyButtonText: `Don\'t save`
          }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
              Swal.fire('Saved!', '', 'success').then(() => {
                // Redirect to tamu.php after successful edit
                window.location.href = 'tamu.php';
              });
            } else if (result.isDenied) {
              Swal.fire('Changes are not saved', '', 'info');
            }
          });
        </script>";
    } else {
        echo "
        <script>
            Swal.fire({
                title: 'Error',
                text: 'Data gagal diubah.',
                icon: 'error'
            });
        </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

  

    <!-- My style -->
    <link rel="stylesheet" href="css/edit_data.css">
</head>

<body>

    <section class="edit-history">
        <h2>Edit History Tamu</h2>
        <form action="" method="post">
            <label for="keperluan">Keperluan:</label>
            <input type="text" id="keperluan" name="keperluan" value="<?php echo $row['keperluan']; ?>" required>

            <label for="tanggal">Tanggal:</label>
            <input type="date" id="tanggal" name="tanggal" value="<?php echo $row['tanggal']; ?>" required>

            <label for="waktu_datang">Waktu Datang:</label>
            <input type="datetime-local" id="waktu_datang" name="waktu_datang" value="<?php echo date("Y-m-d\TH:i", strtotime($row['waktu_datang'])); ?>" required>

            <label for="waktu_pulang">Waktu Pulang:</label>
            <input type="datetime-local" id="waktu_pulang" name="waktu_pulang" value="<?php echo date("Y-m-d\TH:i", strtotime($row['waktu_pulang'])); ?>" required>

            <button type="submit">Simpan Perubahan</button>
        </form>
    </section>

    
</body>

</html>
