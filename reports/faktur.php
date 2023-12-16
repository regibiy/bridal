<?php
include_once("../core/aksi.php");

$id = $_GET["id"];

$sql = "SELECT *, tbl_penyewaan.id AS id_sewa FROM tbl_penyewaan LEFT JOIN tbl_detail_jasa ON tbl_penyewaan.nama_jasa = tbl_detail_jasa.id WHERE tbl_penyewaan.id = '$id'";
$result = $conn->query($sql);
$data = $result->fetch_assoc();

if (substr($data["kode_jasa"], 0, 2) == "DR") {
    $nama_detail_jasa = "Dekorasi";
} else if (substr($data["kode_jasa"], 0, 2) == "FG") {
    $nama_detail_jasa = "Fotografer";
} else {
    $nama_detail_jasa = $data["nama_detail_jasa"];
}

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
<p style="text-align:center;margin-top:0;margin-bottom:24px;">No. ' . $data["id_sewa"] . '</p>
<table style="width:100%;margin-bottom:24px">
<tr>
<td style="width:50%;">Nama : <span style="font-weight:bold;">' . $data["nama"] . '</span></td>
<td style="width:20%;text-align:right;">Tanggal : <span style="font-weight:bold;">' . format_tanggal($data["tanggal_transaksi"]) . '</span></td>
</tr>
<tr>
<td style="width:50%;">Alamat : <span style="font-weight:bold;">' . $data["alamat"] . '</span></td>
</tr>
<tr>
<td style="width:50%;">No. HP : <span style="font-weight:bold;">' . $data["no_hp"] . '</span></td>
</tr>
</table>
<table class="table-style" style="width:100%;text-align:center;margin-bottom:100px;">
<tr>
<td class="table-style" style="font-weight:bold;padding:3px">Nama Jasa</td>
<td class="table-style" style="font-weight:bold;">Lama Sewa</td>
<td class="table-style" style="font-weight:bold;">Harga</td>
</tr>
<tr>
<td class="table-style" style="padding:3px">' . $nama_detail_jasa . " " . $data["kode_jasa"] . '</td>
<td class="table-style">' . $data["lama_sewa"] . ' Hari</td>
<td class="table-style">' . rupiah($data["harga_sewa"]) . '</td>
</tr>
<tr>
<td class="table-style" style="text-align:right;font-weight:bold;padding:3px" colspan="2">Sub Total</td>
<td class="table-style" style="font-weight:bold;">' . rupiah($data["harga_sewa"] * $data["lama_sewa"]) . '</td>
</tr>
</table>
<p style="text-align:center;margin:0;">Dicetak Oleh : <span style="font-weight:bold;">' . $_SESSION["username"] . '</span></p>
<p style="text-align:center;margin:3px;">Dicetak Pada : <span style="font-weight:bold;">' . date('d-m-Y') . '</span></p>';
$mpdf->WriteHTML($html);
$file_name = "Faktur No. " . $data["id_sewa"] . ".pdf";
$mpdf->Output($file_name, \Mpdf\Output\Destination::DOWNLOAD);
