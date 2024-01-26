<?php
require 'koneksi.php';

header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename= laporan kunjungan excel.xls");



// Fungsi untuk mendapatkan frekuensi kunjungan
function getFrekuensiKunjungan()
{
    global $koneksi;

    // Query untuk mengambil data tamu dan history
    $query = "SELECT t.nama_tamu, t.nama_status, t.no_hp, t.jk, t.alamat, 
                     COUNT(h.id_history) AS jumlah_kunjungan
              FROM tamu t
              LEFT JOIN history h ON t.id_tamu = h.id_tamu
              GROUP BY t.nama_tamu, t.nama_status, t.no_hp, t.jk, t.alamat
              ORDER BY jumlah_kunjungan DESC, t.nama_tamu";

    $result = mysqli_query($koneksi, $query);

    // Menyimpan hasil query ke dalam array
    $dataFrekuensi = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $dataFrekuensi[] = $row;
    }

    return $dataFrekuensi;
}

// Memanggil fungsi untuk mendapatkan data frekuensi kunjungan
$frekuensiKunjungan = getFrekuensiKunjungan();
?>

</head>

<body>
    <style>
        #judul {
            text-align: center;
            font-size: 14pt;
            font-weight: bold;
            margin-bottom: 20px;
        }

        table {
            border-collapse: collapse;
        }

        th {
            padding: 5px;
            text-align: center;
        }

        td {
            padding-left: 5px;
            padding-right: 5px;
        }
    </style>
    <section class="home">
        <div id="judul">Frekuensi Kunjungan</div>
        <div class="table-container">
            <table border="1" align="center">
                <thead>
                    <tr>
                        <th width="50">No</th>
                        <th width="100">Nama Tamu</th>
                        <th width="200">Status</th>
                        <th width="50">No HP</th>
                        <th width="100">Jenis Kelamin</th>
                        <th width="100">Alamat</th>
                        <th width="200">Jumlah Kunjungan</th>
                    </tr>

                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    foreach ($frekuensiKunjungan as $data) {
                        echo "<tr>
                        <td>{$no}</td>
                        <td>{$data['nama_tamu']}</td>
                        <td>{$data['nama_status']}</td>
                        <td>{$data['no_hp']}</td>
                        <td>{$data['jk']}</td>
                        <td>{$data['alamat']}</td>
                        <td>{$data['jumlah_kunjungan']}</td>
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