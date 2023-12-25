<?php
include_once("../core/koneksi.php");
$id_jasa = $_GET["idjasa"];
$aksi = $_GET["aksi"]; //0 kurang, 1 tambah

$sql = "SELECT * FROM tbl_keranjang WHERE id_jasa = '$id_jasa'";
$result = $conn->query($sql);
$data = $result->fetch_assoc();

if ($aksi == 0) {
    $hasil_kurang = $data["lama_sewa"] - 3;
} else {
    $hasil_kurang = $data["lama_sewa"] + 3;
}

$sql = "UPDATE tbl_keranjang SET lama_sewa = '$hasil_kurang' WHERE id_jasa = '$id_jasa'";
$result = $conn->query($sql);
echo ($hasil_kurang);
