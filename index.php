<?php
$data = [
  "judul" => "Beranda",
  "penanda_beranda" => "active",
  "penanda_keranjang" => "",
  "penanda_tambah_jasa" => "",
  "penanda_pengembalian" => "",
  "penanda_laporan" => "",
  "penanda_masuk" => "",
];

include_once("core/aksi.php");
include_once("templates/header.php");
?>

<header class="masthead">
  <div class="container">
    <div>
      <div class="position-absolute top-50 start-50 translate-middle">
        <h1 class="fs-1">Selamat Datang Di Website Giant Salon Sintang</h1>
      </div>
    </div>
</header>

<!-- Bagian Jasa -->
<div class="container" id="jasa">
  <h1 class="heading">Jasa Kami</h1>
  <div class="box-container">
    <div class="box">
      <img src="assets/img/img_cp1.JPG" class="img-fluid" alt="sewa pakaian">
      <h3>Sewa Pakaian</h3>
      <p></p>
      <a href="list_pakaian.php" class="btn fw-bold">Lihat Lainnya</a>
    </div>
    <div class="box">
      <img src="assets/img/dp_1.jpg" class="img-fluid" alt="dekorasi pernikahan">
      <h3>Dekorasi Pernikahan</h3>
      <p></p>
      <a href="list_dekorasi.php" class="btn fw-bold">Lihat Lainnya</a>
    </div>
    <div class="box">
      <img src="assets/img/rp1.jpg" class="img-fluid" alt="rias">
      <h3>Rias</h3>
      <p></p>
      <a href="list_rias.php" class="btn fw-bold">Lihat Lainnya</a>
    </div>
    <div class="box">
      <img src="assets/img/rp1.jpg" class="img-fluid" alt="fotografer">
      <h3>Fotografer</h3>
      <p></p>
      <a href="list_fotografer.php" class="btn fw-bold">Lihat Lainnya</a>
    </div>
  </div>
</div>

<br></br><br></br>

<?php
include_once("templates/footer.php");
?>