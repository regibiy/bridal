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
                <button class="nav-link active" id="nav-faktur-tab" data-bs-toggle="tab" data-bs-target="#nav-faktur" type="button" role="tab" aria-controls="nav-faktur" aria-selected="true">Faktur / Laporan</button>
                <button class="nav-link" id="nav-laporan-tab" data-bs-toggle="tab" data-bs-target="#nav-laporan" type="button" role="tab" aria-controls="nav-laporan" aria-selected="false">Laporan Penyewaan</button>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-faktur" role="tabpanel" aria-labelledby="nav-faktur-tab" tabindex="0">
                <div class="p-4">
                    <h1 class="text-center">Data Penyewaan</h1>
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
                            $sql = "SELECT DISTINCT tbl_penyewaan.id, tanggal_transaksi, nama, alamat, no_hp, tanggal_sewa, metode_bayar FROM tbl_penyewaan INNER JOIN tbl_detail_penyewaan ON tbl_penyewaan.id = tbl_detail_penyewaan.id WHERE tbl_detail_penyewaan.status_sewa IN('Belum Dikembalikan', 'Tidak Ada Peminjaman') ORDER BY tanggal_transaksi DESC";
                            $result = $conn->query($sql);
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row["id"] . "</td>";
                                echo "<td>" . format_tanggal($row["tanggal_transaksi"]) . "</td>";
                                echo "<td>" . $row["nama"] . " | " . $row["alamat"] . " | " . $row["no_hp"] . "</td>";
                                echo "<td>" . format_tanggal($row["tanggal_sewa"]) . "</td>";
                                echo "<td>" . $row["metode_bayar"] . "</td>";
                                echo "<td>
                                <button class='btn mb-1 btn-outline-primary btn-sewa-detail-laporan' data-bs-toggle='modal' data-bs-target='#detail' data-id='" . $row["id"] . "'>Detail</button>
                                <a href='' target='_blank' data-id='" . $row["id"] . "' class='btn mb-1 btn-primary btn-cetak'>Cetak Faktur</a>
                                </td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-pane fade" id="nav-laporan" role="tabpanel" aria-labelledby="nav-laporan-tab" tabindex="0">
                <div class="p-4 d-flex align-items-center flex-column">
                    <div class="col">
                        <h1 class="text-center">Form Periode Laporan Penyewaan</h1>
                    </div>
                    <div class="col-4 m-4 border rounded p-4">
                        <div class="alert alert-warning alert-warning-periode d-none" role="alert"></div>
                        <div class="mb-3">
                            <label for="tanggalAwal">Tanggal Awal</label>
                            <input type="date" name="tanggalAwal" class="form-control form-tanggal-awal">
                        </div>
                        <div class="mb-3">
                            <label for="tanggalAkhir">Tanggal Akhir</label>
                            <input type="date" name="tanggalAkhir" class="form-control form-tanggal-akhir">
                        </div>
                        <a href="" target="_blank" class="btn btn-primary btn-cetak-laporan">Cetak</a>
                    </div>
                </div>
            </div>
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