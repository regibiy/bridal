<?php
$data = [
    "judul" => "Pengembalian",
    "penanda_beranda" => "",
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
                    <th>Nama</th>
                    <th>Tanggal Sewa</th>
                    <th>Lama Sewa</th>
                    <th>Nama Jasa</th>
                    <th>Harga Sewa</th>
                    <th>Detail Jasa</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT *, tbl_penyewaan.id AS id_sewa FROM tbl_penyewaan INNER JOIN tbl_jasa ON tbl_penyewaan.kode_jasa = tbl_jasa.id WHERE status_sewa <> 'Dikembalikan'";
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . format_tanggal($row["tanggal_transaksi"]) . "</td>";
                    echo "<td>" . $row["nama"] . "</td>";
                    echo "<td>" . format_tanggal($row["tanggal_sewa"]) . "</td>";
                    echo "<td>" . $row["lama_sewa"] . " Hari</td>";
                    echo "<td><button type='button' class='btn btn-outline-secondary btn-gambar' data-bs-toggle='modal' data-bs-target='#gambar' data-id='" . $row["kode_jasa"] . "'>" . $row["kode_jasa"] . "</button></td>";
                    echo "<td>" . rupiah($row["harga_sewa"]) . "</td>";
                    echo "<td><button class='btn btn-outline-secondary btn-sewa-detail' data-bs-toggle='modal' data-bs-target='#detail' data-id='" . $row["id_sewa"] . "'>Detail</button></td>";
                    echo "<td><button class='btn btn-primary btn-update-status' data-id='" . $row["id_sewa"] . "' data-bs-toggle='modal' data-bs-target='#notif'>Dikembalikan</button></td>";
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
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title modal-title-detail fs-5" id="exampleModalLabel"></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body modal-body-detail">
                <p id="tanggalTransaksiDetail"></p>
                <p id="namaDetail"></p>
                <p id="alamatDetail"></p>
                <p id="hpDetail"></p>
                <p id="tanggalSewaDetail"></p>
                <p id="lamaSewaDetail"></p>
                <p id="namaJasaDetail"></p>
                <p id="kodeJasaDetail"></p>
                <p id="hargaSewaDetail"></p>
                <p id="metodeBayarDetail"></p>
                <p id="statusSewaDetail"></p>
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