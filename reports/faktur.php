<?php
include_once("../core/aksi.php");

$id = $_GET["id"];

$sql = "SELECT *, tbl_penyewaan.id AS id_sewa FROM tbl_penyewaan LEFT JOIN tbl_detail_jasa ON tbl_penyewaan.nama_jasa = tbl_detail_jasa.id WHERE tbl_penyewaan.id = '$id'";
$result = $conn->query($sql);
$data = $result->fetch_assoc();

require_once '../vendor/autoload.php';

$mpdf = new \Mpdf\Mpdf(['tempDir' => __DIR__ . '/custom/temp/dir/path', 'default_font' => 'dejavusans']);


$html = '
<style>
.table-style {
    border: 1px solid black;
    border-collapse: collapse;
}
</style>
<h1 style="font-weight:bold;margin:0;padding:0;">GIANT SALON SINTANG</h1>
<p style="margin-top:5px;margin-bottom:0;padding:0;">Jalan YC.Oevang Oeray Baning <br> Kota Sintang <br> Kalimantan Barat</p>
<p style="margin-top:5px;margin-bottom:0;padding:0;">No.HP 082151566633</p>
<hr>
<h2 style="text-align:center;margin-top:12px;margin-bottom:0;">FAKTUR</h2>
<p style="text-align:center;margin-top:0;margin-bottom:24px;">ddmmyy999</p>
<table style="width:100%;margin-bottom:24px">
<tr>
<td style="width:50%;">Nama : <span style="font-weight:bold;">' . $data["nama"] . '</span></td>
<td style="width:50%;text-align:right;">Tanggal : <span style="font-weight:bold;">dd-mm-yyyy</span></td>
</tr>
<tr>
<td style="width:50%;">Alamat : <span style="font-weight:bold;">Jalan Juanda</span></td>
</tr>
<tr>
<td style="width:50%;">No. HP : <span style="font-weight:bold;">081234566543</span></td>
</tr>
</table>
<table class="table-style" style="width:100%;text-align:center;margin-bottom:100px;">
<tr>
<td class="table-style" style="font-weight:bold;padding:3px">Nama Jasa</td>
<td class="table-style" style="font-weight:bold;">Lama Sewa</td>
<td class="table-style" style="font-weight:bold;">Harga</td>
</tr>
<tr>
<td class="table-style" style="padding:3px">Gaun GN01</td>
<td class="table-style">1 Hari</td>
<td class="table-style">750000</td>
</tr>
<tr>
<td class="table-style" style="text-align:right;font-weight:bold;padding:3px" colspan="2">Sub Total</td>
<td class="table-style" style="font-weight:bold;">750000</td>
</tr>
</table>
<p style="text-align:center;font-weight:bold;margin:0;">Juminten</p>
<p style="text-align:center;font-weight:bold;margin:3px;">dd-mm-yyyy</p>';
$mpdf->WriteHTML($html);
$mpdf->Output("test.pdf", \Mpdf\Output\Destination::DOWNLOAD);
