<?php
$data = [
  "judul" => "Masuk",
  "penanda_beranda" => "active",
  "penanda_tambah_jasa" => "",
  "penanda_pengembalian" => "",
  "penanda_laporan" => "",
  "penanda_masuk" => "",
];

include_once("core/aksi.php");
include_once("templates/header.php");
?>
<!-- Navbar -->
<header class="masthead">
  <div class="container">
    <div>
      <div class="position-absolute top-50 start-50 translate-middle">
        <h1 class="fs-1">Selamat Datang Di Website Giant Salon Sintang</h1>
      </div>
    </div>
</header>

<!-- Bagian Jasa -->
<div class="container">
  <h1 class="heading">Jasa Kami</h1>
  <div class="box-container">
    <div class="box">
      <img src="assets/img/img_cp1.JPG" alt="">
      <h3>Sewa Pakaian</h3>
      <p></p>
      <a href="list_pakaian.php" class="btn fw-bold">Lihat Lainnya</a>
    </div>
    <div class="box">
      <img src="assets/img/dp_1.jpg" alt="">
      <h3>Dekorasi Pernikahan</h3>
      <p></p>
      <a href="list_dekorasi.php" class="btn fw-bold">Lihat Lainnya</a>
    </div>
    <div class="box">
      <img src="assets/img/rp1.jpg" alt="">
      <h3>Rias</h3>
      <p></p>
      <a href="#" class="btn fw-bold">Lihat Lainnya</a>
    </div>
  </div>
</div>

<br></br><br></br>

<?php
include_once("templates/footer.php");
?>