<?php
$data = [
  "judul" => "Daftar Pakaian",
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

<!-- LIST PAKAIAN -->
<div class="container">
  <h1 class="heading">List Pakaian</h1>
  <h2 class="heading2">Gaun</h2>
  <div class="box-container">
    <?php
    $sql = "SELECT * FROM tbl_jasa WHERE LEFT(id, 2) = 'GN'";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
      echo "<div class='box'>";
      echo "<img class='img-fluid' src='assets/upload_img/" . $row['gambar'] . "' alt='Gambar Gaun'>";
      echo "<p class='fw-bold'>Qty: " . $row["qty"] . "</p>";
      echo "<p class='fw-bold'>Harga : " . $row["harga"] . "</p>";
      echo "<a href='form_sewa.php?idjasa=" . $row["id"] . "' class='btn fw-bold'>Sewa</a>";
      echo "</div>";
    }
    ?>
  </div>
  <h2 class="heading2">Pakaian Adat</h2>
  <div class="box-container">
    <?php
    $sql = "SELECT * FROM tbl_jasa WHERE LEFT(id, 2) = 'PA'";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
      echo "<div class='box'>";
      echo "<img class='img-fluid' src='assets/upload_img/" . $row['gambar'] . "' alt='Gambar Pakaian Adat'>";
      echo "<p class='fw-bold'>Qty: " . $row["qty"] . "</p>";
      echo "<p class='fw-bold'>Harga : " . $row["harga"] . "</p>";
      echo "<a href='form_sewa.php?idjasa=" . $row["id"] . "' class='btn fw-bold'>Sewa</a>";
      echo "</div>";
    }
    ?>
  </div>
  <h2 class="heading2">Pakaian Nikah</h2>
  <div class="box-container">
    <?php
    $sql = "SELECT * FROM tbl_jasa WHERE LEFT(id, 2) = 'PN'";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
      echo "<div class='box'>";
      echo "<img class='img-fluid' src='assets/upload_img/" . $row['gambar'] . "' alt='Gambar Pakaian Nikah'>";
      echo "<p class='fw-bold'>Qty: " . $row["qty"] . "</p>";
      echo "<p class='fw-bold'>Harga : " . $row["harga"] . "</p>";
      echo "<a href='form_sewa.php?idjasa=" . $row["id"] . "' class='btn fw-bold'>Sewa</a>";
      echo "</div>";
    }
    ?>
  </div>
</div>

<br></br><br></br>

<?php
include_once("templates/footer.php");
?>