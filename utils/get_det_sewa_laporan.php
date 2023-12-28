<?php
include_once("../core/koneksi.php");
$id = $_GET["id"];
$sql = "SELECT *, tbl_detail_penyewaan.id AS id_transaksi FROM tbl_detail_penyewaan 
        INNER JOIN tbl_jasa ON tbl_detail_penyewaan.kode_jasa = tbl_jasa.id 
        LEFT JOIN tbl_jenis_jasa ON tbl_jasa.id_jenis_jasa = tbl_jenis_jasa.id
        LEFT JOIN tbl_detail_jasa ON tbl_jasa.id_detail_jasa = tbl_detail_jasa.id
        WHERE tbl_detail_penyewaan.id = '$id'";
$result = $conn->query($sql);
$data = $result->fetch_all(MYSQLI_ASSOC);
echo json_encode($data);
