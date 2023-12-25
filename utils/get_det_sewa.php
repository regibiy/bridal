<?php
include_once("../core/koneksi.php");
$id = $_GET["id"];
$sql = "SELECT * FROM tbl_detail_penyewaan INNER JOIN tbl_jasa ON tbl_detail_penyewaan.kode_jasa = tbl_jasa.id WHERE tbl_detail_penyewaan.id = '$id'";
$result = $conn->query($sql);
$data = $result->fetch_all(MYSQLI_ASSOC);
echo json_encode($data);
