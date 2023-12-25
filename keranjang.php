<?php
$data = [
    "judul" => "Keranjang",
    "penanda_beranda" => "",
    "penanda_keranjang" => "active",
    "penanda_tambah_jasa" => "",
    "penanda_pengembalian" => "",
    "penanda_laporan" => "",
    "penanda_masuk" => "",
];

include_once("core/aksi.php");
if (!login_admin()) header("Location: login.php");

$sql = "SELECT * FROM tbl_keranjang INNER JOIN tbl_jasa ON tbl_keranjang.id_jasa = tbl_jasa.id";
$result = $conn->query($sql);

include_once("templates/header.php");

?>

<div class="register-photo">
    <div class="form-container p-5 rounded bg-white">
        <h1 class="text-center mb-3">Keranjang</h1>
        <?php
        $format_kode = ["RP", "RW", "FG"];
        $total = 0;
        while ($row = $result->fetch_assoc()) {
            echo "<div class='card mb-3'>";
            echo "<div class='card-body bg-body-tertiary shadow-sm'>";
            echo "<div class='row'>";
            echo "<div class='col-2'>";
            echo "<img src='assets/upload_img/" . $row['gambar'] . "' class='img-thumbnail img-fluid'/>";
            echo "</div>";
            echo "<div class='col-8 detail-jasa'>";
            echo "<p class='fw-bold'>" . $row["id_jasa"] . "</p>";
            echo "<p class='fw-bold'>" . rupiah($row["harga"]) . "</p>";
            echo "<input type='hidden' class='harga' value='" . $row["harga"] . "' />";
            $kode = substr($row["id_jasa"], 0, 2);
            if (!in_array($kode, $format_kode)) {
                echo "<p>Lama Sewa Per Hari</p>";
                echo "<div class='d-flex align-items-center atur-lama-sewa'>";
                echo "<button type='button' class='btn btn-sm btn-info me-3 btn-kurang' data-idjasa='" . $row["id_jasa"] . "' data-harga='" . $row["harga"] . "'>-</button>";
                echo "<input type='text' class='form-control form-control-sm col-1 me-3 text-center input-lama-sewa' id='" . $row["id_jasa"] . "' value='" . $row["lama_sewa"] . "' readonly />";
                echo "<button type='button' class='btn btn-sm btn-info btn-tambah' data-idjasa='" . $row["id_jasa"] . "' data-harga='" . $row["harga"] . "'>+</button>";
                echo "</div>";
            } else {
                echo "<div class='d-flex align-items-center atur-lama-sewa'>";
                echo "<input type='hidden' class='form-control form-control-sm col-1 me-3 text-center input-lama-sewa' id='" . $row["id_jasa"] . "' value='" . $row["lama_sewa"] . "' readonly />";
                echo "</div>";
            }
            echo "</div>";
            echo "<div class='col-2 text-end'>";
            echo "<form action='core/aksi.php' method='post' class='p-0 bg-body-tertiary'>";
            echo "<input type='hidden' name='id_jasa' value='" . $row["id_jasa"] . "' />";
            echo "<button type='submit' class='btn btn-danger' name='hapus_keranjang'>Hapus</button>";
            echo "</form>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
        }
        ?>
        <!-- foto, id_jasa, hapus, total_harga -->
        <div class="text-end d-flex justify-content-end align-items-center">
            <div class="me-2">
                <p class="m-0">Total</p>
                <p class="fw-semibold m-0" id="total"></p>
            </div>
            <button type="button" class="btn btn-primary btn-beli" data-bs-toggle="modal" data-bs-target="#formSewa">Beli</button>
        </div>
    </div>
</div>

<!-- Modal -->
<form action="core/aksi.php" method="post" autocomplete="off">
    <div class="modal fade" id="formSewa" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Data Transaksi Sewa</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="name" name="nama" placeholder="Nama Penyewa" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea name="alamat" id="alamat" class="form-control" placeholder="Alamat Penyewa" required></textarea>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label for="noHp" class="form-label">No Handphone</label>
                            <input type="number" id="noHp" name="no_hp" class="form-control" placeholder="Nomor HP Penyewa" required />
                        </div>
                        <div class="col">
                            <label for="tanggalSewa" class="form-label">Tanggal Sewa</label>
                            <input type="date" name="tanggal_sewa" id="tanggalSewa" class="form-control" required>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label class="form-label" for="metodeBayar">Metode Pembayaran</label>
                        <div class="col-2">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="metode_bayar" id="flexRadioDefault1" value="Tunai" checked required>
                                <label class="form-check-label" for="flexRadioDefault1">Tunai</label>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="metode_bayar" id="flexRadioDefault2" value="Transfer" required>
                                <label class="form-check-label" for="flexRadioDefault2">Transfer</label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3 text-end">
                        <div class="col">
                            <p class="fw-semibold">Total yang Harus Dibayarkan :</p>
                            <p class="total-to-pay fw-bold m-0"></p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary" name="tambah_sewa">Proses</button>
                </div>
            </div>
        </div>
    </div>
</form>
<?php
include_once("templates/footer.php");
