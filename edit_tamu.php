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

    // Fungsi untuk mengambil data tamu berdasarkan ID
    function getTamuById($id)
    {
        global $koneksi;
        $query = "SELECT t.*, s.nama_status
                  FROM tamu t
                  JOIN status s ON t.id_status = s.id_status
                  WHERE t.id_tamu = $id";
        $result = mysqli_query($koneksi, $query);
        return mysqli_fetch_assoc($result);
    }

    // Fungsi untuk mengambil data status
    function getStatusOptions($selectedStatus)
    {
        global $koneksi;
        $query = "SELECT * FROM status";
        $result = mysqli_query($koneksi, $query);

        $options = "";
        while ($row = mysqli_fetch_assoc($result)) {
            $selected = ($row['id_status'] == $selectedStatus) ? 'selected' : '';
            $options .= "<option value='{$row['id_status']}' $selected>{$row['nama_status']}</option>";
        }

        return $options;
    }

    // Fungsi untuk mengedit data tamu
    function editTamu($data)
    {
        global $koneksi;

        $id_tamu = $data["id_tamu"];
        $nama_tamu = htmlspecialchars($data["nama_tamu"]);
        $id_status = htmlspecialchars($data["id_status"]);
        $jk = htmlspecialchars($data["jk"]);
        $no_hp = htmlspecialchars($data["no_hp"]);
        $email_tamu = htmlspecialchars($data["email_tamu"]);
        $alamat = htmlspecialchars($data["alamat"]);

        $query = "UPDATE tamu SET
                    nama_tamu = '$nama_tamu',
                    id_status = '$id_status',
                    jk = '$jk',
                    no_hp = '$no_hp',
                    email_tamu = '$email_tamu',
                    alamat = '$alamat'
                    WHERE id_tamu = $id_tamu";

        mysqli_query($koneksi, $query);

        return mysqli_affected_rows($koneksi);
    }

    // Ambil data dari URL
    $id = $_GET["id_tamu"];

    // Ambil data tamu berdasarkan ID
    $ctm = getTamuById($id);

    if (isset($_POST["submit"])) {
        if (editTamu($_POST) > 0) {
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

    <h1>Edit Data Tamu</h1>

    <!-- Form -->
    <form action="" method="post">
        <input type="hidden" name="id_tamu" value="<?= $ctm["id_tamu"] ?>">
        <ul>
            <li>
                <label for="nama">Masukkan Nama Tamu: </label>
                <input type="text" name="nama_tamu" id="nama" required value="<?= $ctm["nama_tamu"] ?>">
            </li>
            <li>
                <label for="id_status">Pilih Status: </label>
                <select name="id_status" id="id_status" required>
                    <?= getStatusOptions($ctm['id_status']); ?>
                </select>
            </li>
            <li>
                <label for="jk">Jenis Kelamin: </label>
                <input type="text" name="jk" id="jk" required value="<?= $ctm["jk"] ?>">
            </li>
            <li>
                <label for="no_hp">Masukkan NO HP: </label>
                <input type="number" name="no_hp" id="no_hp" required value="<?= $ctm["no_hp"] ?>">
            </li>
            <li>
                <label for="email_tamu">Masukkan Email: </label>
                <input type="email" name="email_tamu" id="email_tamu" required value="<?= $ctm["email_tamu"] ?>">
            </li>
            <li>
                <label for="alamat">Alamat: </label>
                <input type="text" name="alamat" id="alamat" required value="<?= $ctm["alamat"] ?>">
            </li>
            <li>
                <button type="submit" name="submit">Kirim</button>
            </li>
        </ul>
    </form>
    <!-- Form end -->
</body>

</html>
