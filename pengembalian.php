<?php
$data = [
    "judul" => "Pengembalian",
    "penanda_beranda" => "",
    "penanda_keranjang" => "",
    "penanda_tambah_jasa" => "",
    "penanda_pengembalian" => "active",
    "penanda_laporan" => "",
    "penanda_masuk" => "",
];

include_once("core/aksi.php");
if (!login_admin()) header("Location: login.php");

include_once("templates/header.php");

?>

<div class="register-photo">
    <div class="form-container p-5 rounded bg-white">
        <h1 class="text-center">Pengembalian Sewa</h1>
        <div id="regenerateTable">
            <table id="example" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>No. Transaksi</th>
                        <th>Tanggal Transaksi</th>
                        <th>Data Penyewa</th>
                        <th>Tanggal Sewa</th>
                        <th>Metode Bayar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT DISTINCT tbl_penyewaan.id, tanggal_transaksi, nama, alamat, no_hp, tanggal_sewa, metode_bayar FROM tbl_penyewaan INNER JOIN tbl_detail_penyewaan ON tbl_penyewaan.id = tbl_detail_penyewaan.id WHERE tbl_detail_penyewaan.status_sewa = 'Belum Dikembalikan'";
                    $result = $conn->query($sql);
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["id"] . "</td>";
                        echo "<td>" . format_tanggal($row["tanggal_transaksi"]) . "</td>";
                        echo "<td>" . $row["nama"] . " | " . $row["alamat"] . " | " . $row["no_hp"] . "</td>";
                        echo "<td>" . format_tanggal($row["tanggal_sewa"]) . "</td>";
                        echo "<td>" . $row["metode_bayar"] . "</td>";
                        echo "<td>";
                        echo "<button class='btn btn-primary btn-sewa-detail' data-bs-toggle='modal' data-bs-target='#detail' data-id='" . $row["id"] . "'>Detail</button>";
                        echo "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<div class="modal fade" id="detail" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title modal-title-detail fs-5" id="detailListJasa"></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body modal-body-detail">
            </div>
        </div>
    </div>
</div>

<?php
include_once("templates/footer.php");
?>