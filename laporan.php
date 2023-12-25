<?php
$data = [
    "judul" => "Laporan",
    "penanda_beranda" => "",
    "penanda_keranjang" => "",
    "penanda_tambah_jasa" => "",
    "penanda_pengembalian" => "",
    "penanda_laporan" => "active",
    "penanda_masuk" => "",
];

include_once("core/aksi.php");
if (!login_admin()) header("Location: login.php");

include_once("templates/header.php");

?>

<div class="register-photo">
    <div class="form-container p-5 rounded bg-white">
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <button class="nav-link active" id="nav-faktur-tab" data-bs-toggle="tab" data-bs-target="#nav-faktur" type="button" role="tab" aria-controls="nav-faktur" aria-selected="true">Faktur</button>
                <button class="nav-link" id="nav-laporan-tab" data-bs-toggle="tab" data-bs-target="#nav-laporan" type="button" role="tab" aria-controls="nav-laporan" aria-selected="false">Laporan Penyewaan</button>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-faktur" role="tabpanel" aria-labelledby="nav-faktur-tab" tabindex="0">
                <div class="p-4">
                    <h1 class="text-center">Faktur Penyewaan</h1>
                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama</th>
                                <th>Alamat</th>
                                <th>NO. HP</th>
                                <th>Tanggal Transaksi</th>
                                <th>Nama Jasa</th>
                                <th>Lama Sewa</th>
                                <th>Harga</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT *, tbl_penyewaan.id AS id_sewa FROM tbl_penyewaan LEFT JOIN tbl_detail_jasa ON tbl_penyewaan.nama_jasa = tbl_detail_jasa.id";
                            $result = $conn->query($sql);
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row["id_sewa"] . "</td>";
                                echo "<td>" . $row["nama"] . "</td>";
                                echo "<td>" . $row["alamat"] . "</td>";
                                echo "<td>" . $row["no_hp"] . "</td>";
                                echo "<td>" . format_tanggal($row["tanggal_transaksi"]) . "</td>";
                                if (substr($row["kode_jasa"], 0, 2) == "DR") {
                                    $nama_detail_jasa = "Dekorasi";
                                } else if (substr($row["kode_jasa"], 0, 2) == "FG") {
                                    $nama_detail_jasa = "Fotografer";
                                } else {
                                    $nama_detail_jasa = $row["nama_detail_jasa"];
                                }
                                echo "<td>" .  $nama_detail_jasa . " " . $row["kode_jasa"] . "</td>";
                                echo "<td>" . $row["lama_sewa"] . " Hari</td>";
                                echo "<td>" . rupiah($row["harga_sewa"]) . "</td>";
                                echo "<td><a href='' data-id='" . $row["id_sewa"] . "' class='btn btn-primary btn-cetak'>Cetak</a></td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-pane fade" id="nav-laporan" role="tabpanel" aria-labelledby="nav-laporan-tab" tabindex="0">
                <div class="p-4">
                    <h1 class="text-center">Laporan Penyewaan</h1>
                    <table id="example2" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Data Penyewa</th>
                                <th>Tanggal Sewa</th>
                                <th>Nama Jasa</th>
                                <th>Lama Sewa</th>
                                <th>Harga</th>
                                <th>Metode Bayar</th>
                                <th>Status Sewa</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT *, tbl_penyewaan.id AS id_sewa FROM tbl_penyewaan LEFT JOIN tbl_detail_jasa ON tbl_penyewaan.nama_jasa = tbl_detail_jasa.id";
                            $result = $conn->query($sql);
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row["id_sewa"] . "</td>";
                                echo "<td>" . $row["nama"] . " | " . $row["alamat"] . " | " . $row["no_hp"] . "</td>";
                                echo "<td>" . format_tanggal($row["tanggal_transaksi"]) . "</td>";
                                if (substr($row["kode_jasa"], 0, 2) == "DR") {
                                    $nama_detail_jasa = "Dekorasi";
                                } else if (substr($row["kode_jasa"], 0, 2) == "FG") {
                                    $nama_detail_jasa = "Fotografer";
                                } else {
                                    $nama_detail_jasa = $row["nama_detail_jasa"];
                                }
                                echo "<td>" .  $nama_detail_jasa . " " . $row["kode_jasa"] . "</td>";
                                echo "<td>" . $row["lama_sewa"] . " Hari</td>";
                                echo "<td>" . rupiah($row["harga_sewa"]) . "</td>";
                                echo "<td>" . $row["metode_bayar"] . "</td>";
                                echo "<td>" . $row["status_sewa"] . "</td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>

                    <div class="mt-4 text-end">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#formCetak">Cetak Laporan</button>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="formCetak" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Periode Laporan</h1>
                                    <button type="button" class="btn-close btn-close-periode" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="alert alert-warning alert-warning-periode d-none" role="alert"></div>
                                    <div class="mb-3">
                                        <label for="tanggalAwal">Tanggal Awal</label>
                                        <input type="date" name="tanggalAwal" class="form-control form-tanggal-awal">
                                    </div>
                                    <div class="mb-3">
                                        <label for="tanggalAkhir">Tanggal Akhir</label>
                                        <input type="date" name="tanggalAkhir" class="form-control form-tanggal-akhir">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <a href="" target="_blank" class="btn btn-primary btn-cetak-laporan">Cetak</a>
                                    <button type="button" class="btn btn-secondary btn-close-periode" data-bs-dismiss="modal">Batal</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include_once("templates/footer.php");
?>