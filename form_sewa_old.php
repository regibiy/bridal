<?php
$data = [
  "judul" => "Sewa",
  "penanda_beranda" => "active",
  "penanda_keranjang" => "",
  "penanda_tambah_jasa" => "",
  "penanda_pengembalian" => "",
  "penanda_laporan" => "",
  "penanda_masuk" => ""
];

include_once("core/aksi.php");

if (!login_admin()) header("Location: login.php");
include_once("templates/header.php");
// validasi kode jasa ada atau tidak
if (isset($_GET["idjasa"])) {
  $id_jasa = $_GET["idjasa"];
  if (substr($id_jasa, 0, 2) == "DR" || substr($id_jasa, 0, 2) == "FG") {
    $sql = "SELECT * FROM tbl_jasa LEFT JOIN tbl_detail_jasa ON tbl_jasa.id_detail_jasa = tbl_detail_jasa.id WHERE tbl_jasa.id = '$id_jasa'";
  } else {
    $sql = "SELECT * FROM tbl_jasa INNER JOIN tbl_detail_jasa ON tbl_jasa.id_detail_jasa = tbl_detail_jasa.id WHERE tbl_jasa.id = '$id_jasa'";
  }
  $result = $conn->query($sql);
  $data = $result->fetch_assoc();
  if ($result->num_rows > 0) {
    $jenis_jasa = $data["id_jenis_jasa"];
  }
} else {
  alert_with_redirect("Terjadi kesalahan!", "index.php");
}
// validasi quantity, dilakukan ketika pakaian
if ($jenis_jasa == 1) {
  $sql2 = "SELECT COUNT(id) AS total FROM tbl_penyewaan WHERE tanggal_sewa >= CURRENT_DATE AND kode_jasa = '$id_jasa'";
  $result2 = $conn->query($sql2);
  $data2 = $result2->fetch_assoc();

  $hasil = $data["qty"] - $data2["total"];
  if ($hasil < 1) {
    alert_with_redirect("Stok Baju Tidak Tersedia!", "list_pakaian.php");
  }
}
?>

<section class="vh-100 gradient-custom">
  <div class="container py-5 h-100">
    <div class="row justify-content-center align-items-center h-100">
      <div class="col-12 col-lg-9 col-xl-7">
        <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
          <div class="card-body p-4 p-md-5">
            <h3 class="mb-4 pb-2 pb-md-0 mb-md-5 text-center">Form Penyewaan</h3>
            <form action="core/aksi.php" method="post" autocomplete="off">
              <div class="row mb-4">
                <div class="col-12">
                  <div class="form-outline">
                    <label class="form-label" for="name">Nama</label>
                    <input type="text" id="name" name="nama" class="form-control form-control-lg" placeholder="Nama" />
                  </div>
                </div>
              </div>
              <div class="row mb-4">
                <div class="col-12">
                  <div class="form-outline">
                    <label class="form-label" for="address">Alamat</label>
                    <textarea id="address" name="alamat" class="form-control form-control-lg" placeholder="Alamat"></textarea>
                  </div>
                </div>
              </div>
              <div class="row mb-4">
                <div class="col-md-6 mb-2 d-flex align-items-center">
                  <div class="form-outline datepicker w-100">
                    <label for="noHP" class="form-label">No Handphone</label>
                    <input type="number" id="noHP" name="no_hp" class="form-control form-control-lg" placeholder="Nomor Handphone" />
                  </div>
                </div>
                <div class="col-md-6 mb-2 d-flex align-items-center">
                  <div class="form-outline datepicker w-100">
                    <?php
                    if ($data["id_jenis_jasa"] == 3) {
                      echo "<label for='tanggalSewa' class='form-label'>Tanggal Rias</label>";
                    } else {
                      echo "<label for='tanggalSewa' class='form-label'>Tanggal Sewa</label>";
                    }
                    ?>
                    <input type="date" name="tanggal_sewa" id="tanggalSewa" class="form-control form-control-lg" />
                  </div>
                </div>
              </div>
              <?php
              if ($data["id_jenis_jasa"] != 3) {
                echo "
                <div class='row mb-4'>
                <div class='col-md-6'>
                <div class='form-outline'>
                <label class='form-label' for='lamaSewa'>Lama Sewa</label>
                <input type='number' name='lama_sewa' id='lamaSewa' class='form-control form-control-lg' placeholder='1' min='1' />
                </div>
                </div>
                </div>";
              } else {
                echo "<input type='hidden' name='lama_sewa' id='lamaSewa' class='form-control form-control-lg' value='0' />";
              }
              ?>
              <div class="row mb-4">
                <div class="col-12">
                  <div class="form-outline">
                    <label class="form-label" for="namaJasa">Nama Jasa</label>
                    <?php
                    if (substr($id_jasa, 0, 2) == "DR") {
                      echo "<input id='namaJasa' name='nama_jasa' class='form-control form-control-lg' value='Dekorasi' readonly />";
                    } else if (substr($id_jasa, 0, 2) == "FG") {
                      echo "<input id='namaJasa' name='nama_jasa' class='form-control form-control-lg' value='Fotografer' readonly />";
                    } else {
                      echo "<input id='namaJasa' name='nama_jasa' class='form-control form-control-lg' value='" . $data["nama_detail_jasa"] . "' readonly />";
                    }
                    ?>
                    <input type="hidden" name="id_nama_jasa" value="<?= $data["id_detail_jasa"] ?>">
                    <input type="hidden" name="kode_jasa" value="<?= $id_jasa ?>">
                  </div>
                </div>
              </div>
              <div class="row mb-4">
                <div class="col-12">
                  <div class="form-outline">
                    <?php
                    if ($data["id_jenis_jasa"] == 3) {
                      echo "<label class='form-label' for='harga'>Harga Rias</label>";
                    } else {
                      echo "<label class='form-label' for='harga'>Harga Sewa</label>";
                    }
                    ?>
                    <input id="tampilHarga" name="tampil_harga" class="form-control form-control-lg" value="<?= rupiah($data["harga"]) ?>" readonly />
                    <input type="hidden" name="harga" id="harga" value="<?= $data["harga"] ?>">
                  </div>
                </div>
              </div>
              <div class="row mb-4">
                <div class="col-12">
                  <div class="form-outline">
                    <label class="form-label" for="subTotal">Sub Total Harga</label>
                    <?php
                    if ($data["id_jenis_jasa"] != 3) {
                      echo "<input id='subTotal' class='form-control form-control-lg' readonly />";
                    } else {
                      echo "<input id='subTotal' class='form-control form-control-lg' value='" . rupiah($data["harga"]) . "' readonly />";
                    }
                    ?>
                  </div>
                </div>
              </div>
              <div class="row mb-4">
                <label class="form-label" for="metodeBayar">Metode Pembayaran</label>
                <div class="col-md-2 mb-2">
                  <div class="form-outline">
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="metode_bayar" id="flexRadioDefault1" value="Tunai" checked>
                      <label class="form-check-label" for="flexRadioDefault1">Tunai</label>
                    </div>
                  </div>
                </div>
                <div class="col-md-2 mb-4">
                  <div class="form-outline">
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="metode_bayar" id="flexRadioDefault2" value="Transfer">
                      <label class="form-check-label" for="flexRadioDefault2">Transfer</label>
                    </div>
                  </div>
                </div>
              </div>
              <div>
                <button type="submit" class="btn btn-primary" name="tambah_sewa">Sewa</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<br></br><br></br><br></br><br></br><br></br><br></br><br></br>

<?php
include_once("templates/footer.php");
?>