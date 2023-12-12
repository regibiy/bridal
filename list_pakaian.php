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

<div class="container">
  <h1 class="heading">List Pakaian</h1>
  <h2 class="heading2">Gaun</h2>
  <div class="box-container">
    <?php
    $sql = "SELECT * FROM tbl_jasa WHERE LEFT(id, 2) = 'GN'";
    $result2 = $conn->query($sql);
    while ($row = $result2->fetch_assoc()) {
      $id = $row["id"];
      $result = $conn->query("SELECT COUNT(id) AS max_value FROM tbl_penyewaan WHERE tanggal_sewa >= CURRENT_DATE AND kode_jasa = '$id'");
      $data = $result->fetch_assoc();
      $quantity = $row["qty"] - $data["max_value"];

      echo "<div class='box'>";
      echo "<img class='img-fluid' src='assets/upload_img/" . $row['gambar'] . "' alt='Gambar Gaun'>";
      echo "<p class='fw-bold'>Qty: " . $quantity . "</p>";
      echo "<p class='fw-bold'>Harga : " . $row["harga"] . "</p>";

      if ($quantity == 0) {
        echo "<button class='btn fw-bold' onclick='alertQty()'>Sewa</button>";
      } else {
        echo "<a href='form_sewa.php?idjasa=" . $id . "' class='btn fw-bold'>Sewa</a>";
      }
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
      $id = $row["id"];
      $result2 = $conn->query("SELECT COUNT(id) AS max_value FROM tbl_penyewaan WHERE tanggal_sewa >= CURRENT_DATE AND kode_jasa = '$id'");
      $data = $result2->fetch_assoc();
      $quantity = $row["qty"] - $data["max_value"];

      echo "<div class='box'>";
      echo "<img class='img-fluid' src='assets/upload_img/" . $row['gambar'] . "' alt='Gambar Pakaian Adat'>";
      echo "<p class='fw-bold'>Qty: " . $quantity . "</p>";
      echo "<p class='fw-bold'>Harga : " . $row["harga"] . "</p>";

      if ($quantity == 0) {
        echo "<button class='btn fw-bold' onclick='alertQty()'>Sewa</button>";
      } else {
        echo "<a href='form_sewa.php?idjasa=" . $id . "' class='btn fw-bold'>Sewa</a>";
      }
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
      $id = $row["id"];
      $result2 = $conn->query("SELECT COUNT(id) AS max_value FROM tbl_penyewaan WHERE tanggal_sewa >= CURRENT_DATE AND kode_jasa = '$id'");
      $data = $result2->fetch_assoc();
      $quantity = $row["qty"] - $data["max_value"];

      echo "<div class='box'>";
      echo "<img class='img-fluid' src='assets/upload_img/" . $row['gambar'] . "' alt='Gambar Pakaian Nikah'>";
      echo "<p class='fw-bold'>Qty: " . $quantity . "</p>";
      echo "<p class='fw-bold'>Harga : " . $row["harga"] . "</p>";

      if ($quantity == 0) {
        echo "<button class='btn fw-bold' onclick='alertQty()'>Sewa</button>";
      } else {
        echo "<a href='form_sewa.php?idjasa=" . $id . "' class='btn fw-bold'>Sewa</a>";
      }
      echo "</div>";
    }
    ?>
  </div>
</div>

<br></br><br></br>

<?php
include_once("templates/footer.php");
?>