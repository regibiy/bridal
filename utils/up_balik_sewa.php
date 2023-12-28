<?php
include_once("../core/koneksi.php");
$id_transaksi = $_GET["idtrans"];
$kode_jasa = $_GET["kodejasa"];
$sql = "UPDATE tbl_detail_penyewaan SET status_sewa = 'Dikembalikan', tanggal_dikembalikan = CURRENT_DATE WHERE id = '$id_transaksi' AND kode_jasa ='$kode_jasa'";
$conn->query($sql);
