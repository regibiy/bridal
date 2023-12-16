<?php
var_dump($_GET["tglawal"]);
var_dump($_GET["tglakhir"]);
die;

include_once("../core/aksi.php");

$id = $_GET["id"];

$sql = "SELECT *, tbl_penyewaan.id AS id_sewa FROM tbl_penyewaan LEFT JOIN tbl_detail_jasa ON tbl_penyewaan.nama_jasa = tbl_detail_jasa.id WHERE tbl_penyewaan.id = '$id'";
$result = $conn->query($sql);
$data = $result->fetch_assoc();

var_dump($data);
