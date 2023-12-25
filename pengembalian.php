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
        <table id="example" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>Tanggal Transaksi</th>
                    <th>Data Penyewa</th>
                    <th>Tanggal Sewa</th>
                    <th>Metode Bayar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // $sql = "SELECT *, tbl_penyewaan.id AS id_sewa FROM tbl_penyewaan INNER JOIN tbl_detail_penyewaan ON tbl_penyewaan.id = tbl_detail_penyewaan.id INNER JOIN tbl_jasa ON tbl_detail_penyewaan.kode_jasa = tbl_jasa.id WHERE tbl_detail_penyewaan.status_sewa <> 'Dikembalikan'";
                $sql = "SELECT * FROM tbl_penyewaan";
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
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

<!-- Modal -->
<form action="core/aksi.php" method="post">
    <div class="modal fade" id="notif" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 fw-bold" id="exampleModalLabel">Notifikasi</h1>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda Yakin Untuk Mengkonfirmasi Pengembalian Barang?</p>
                    <input type="hidden" class="id-update-status" name="id">
                    <input type="hidden" value="Dikembalikan" name="status_sewa">
                </div>
                <div class="modal-footer">
                    <button type="submit" name="ubah_status" class="btn btn-primary">Ya</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                </div>
            </div>
        </div>
    </div>
</form>

<div class="modal fade" id="detail" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title modal-title-detail fs-5" id="detailListJasa"></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body modal-body-detail">
                <button class="btn btn-primary">test</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="gambar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title modal-title-gambar fs-5" id="exampleModalLabel"></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <img src="" alt="Gambar Jasa" class="img-fluid img-fluid-gambar">
            </div>
        </div>
    </div>
</div>

<?php
include_once("templates/footer.php");
?>