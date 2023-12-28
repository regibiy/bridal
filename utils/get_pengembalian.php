<?php
include_once("../core/koneksi.php");
$sql = "SELECT DISTINCT tbl_penyewaan.id, tanggal_transaksi, nama, alamat, no_hp, tanggal_sewa, metode_bayar FROM tbl_penyewaan INNER JOIN tbl_detail_penyewaan ON tbl_penyewaan.id = tbl_detail_penyewaan.id WHERE tbl_detail_penyewaan.status_sewa = 'Belum Dikembalikan'";
$result = $conn->query($sql);
$data = $result->fetch_all(MYSQLI_ASSOC);
echo json_encode($data);
