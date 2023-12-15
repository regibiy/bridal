<?php
include_once("../core/koneksi.php");
$id = $_GET["id"];
$sql = "SELECT * FROM tbl_penyewaan LEFT JOIN tbl_detail_jasa ON tbl_penyewaan.nama_jasa = tbl_detail_jasa.id WHERE tbl_penyewaan.id = '$id'";
$result = $conn->query($sql);
$data = $result->fetch_all(MYSQLI_ASSOC);
echo json_encode($data);
