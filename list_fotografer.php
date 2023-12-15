<?php
$data = [
  "judul" => "Daftar Fotografer",
  "penanda_beranda" => "active",
  "penanda_tambah_jasa" => "",
  "penanda_pengembalian" => "",
  "penanda_laporan" => "",
  "penanda_masuk" => "",
];

include_once("core/aksi.php");
if (!login_admin()) header("Location: login.php");

include_once("templates/header.php");
?>

<div class="container">
  <h1 class="heading">List Fotografer</h1>
  <div class="box-container">
    <?php
    $sql = "SELECT * FROM tbl_jasa WHERE LEFT(id, 2) = 'FG'";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
      $id = $row["id"];
      echo "<div class='box'>";
      echo "<img class='img-fluid mb-4 img-cover' src='assets/upload_img/" . $row['gambar'] . "' alt='Gambar Rias'>";
      echo "<p class='fw-bold'>Harga : " . rupiah($row["harga"]) . "</p>";
      echo "<a href='form_sewa.php?idjasa=" . $id . "' class='btn fw-bold'>Sewa</a>";
      echo "</div>";
    }
    ?>
  </div>
</div>

<br></br><br></br>

<?php
include_once("templates/footer.php");
?>