<?php
$data = [
  "judul" => "Tambah Jasa",
  "penanda_beranda" => "",
  "penanda_tambah_jasa" => "active",
  "penanda_pengembalian" => "",
  "penanda_laporan" => "",
  "penanda_masuk" => "",
];

include_once("core/aksi.php");
if (!login_admin()) header("Location: login.php");

include_once("templates/header.php");
?>

<!-- TAMBAH JASA -->
<div class="register-photo">
  <div class="form-container">
    <div class="image-holder"></div>
    <form method="post" action="core/aksi.php" autocomplete="off" enctype="multipart/form-data">
      <h2 class="text-center fw-bold">TAMBAH JASA</h2>
      <div class="form-group" id="jasa">
        <label class="fw-bold" for="tipeJasa">Tipe Jasa</label>
        <select class="form-select my-3" name="jenis_jasa" id="tipeJasa"> <!-- id harusnya jenisJasa, malas ubah -->
          <option value="0" selected hidden>Silakan Pilih Jasa</option>
          <?php
          $result = $conn->query("SELECT * FROM tbl_jenis_jasa");
          while ($row = $result->fetch_assoc()) {
            echo "<option value='" . $row["id"] . "'>" . $row["nama_jasa"] . "</option>";
          }
          ?>
        </select>
        <!-- muncul select atau input -->
      </div>
      <div class="form-group">
        <label class="fw-bold" for="qty">Qty</label>
        <input class="form-control" type="number" name="qty" id="qty" placeholder="Qty">
      </div>
      <div class="form-group">
        <label class="fw-bold" for="harga">Harga</label>
        <input class="form-control" type="number" name="harga" placeholder="Harga">
      </div>
      <div class="form-group">
        <label class="fw-bold" for="gambar">Gambar</label>
        <input class="form-control" type="file" name="gambar">
      </div>
      <div class="form-group">
        <button class="btn btn-primary btn-block" name="tambah_jasa" type="submit">Tambah</button>
      </div>
    </form>
  </div>
</div>

<br></br><br></br>

<?php
include_once("templates/footer.php");
?>