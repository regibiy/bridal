<?php
include_once("../core/aksi.php");

$id = $_GET["id"];

$sql = "SELECT * FROM tbl_penyewaan WHERE id = '$id'";
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
<p style="text-align:center;margin-top:0;margin-bottom:24px;">No. ' . $data["id"] . '</p>
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
<td class="table-style" style="font-weight:bold;">Total</td>
</tr>';

$sql2 = "SELECT * FROM tbl_detail_penyewaan 
        INNER JOIN tbl_jasa ON tbl_detail_penyewaan.kode_jasa = tbl_jasa.id
        LEFT JOIN tbl_jenis_jasa ON tbl_jasa.id_jenis_jasa = tbl_jenis_jasa.id
        LEFT JOIN tbl_detail_jasa ON tbl_detail_jasa.id = tbl_jasa.id_detail_jasa
        WHERE tbl_detail_penyewaan.id = '$id'";
$result2 = $conn->query($sql2);
$sub_total = 0;
while ($row = $result2->fetch_assoc()) {
    if (is_null($row['nama_detail_jasa'])) $ket_jasa = $row["nama_jasa"];
    else $ket_jasa = $row["nama_detail_jasa"];
    $counter = 0;
    for ($i = 0; $i < $row["lama_sewa"]; $i += 3) {
        $counter++;
    }
    $tampilHarga = $row["harga_sewa"] * $counter;
    $sub_total += $tampilHarga;
    $html .= '<tr>
            <td class="table-style" style="padding:3px">' . $ket_jasa . ' ' . $row["kode_jasa"] . '</td>
            <td class="table-style">' . $row["lama_sewa"] . ' Hari</td>
            <td class="table-style">' . rupiah($row["harga_sewa"]) . '</td>
            <td class="table-style">' . rupiah($tampilHarga) . '</td>
            </tr>';
}

$html .= '
<tr>
<td class="table-style" style="text-align:right;font-weight:bold;padding:3px" colspan="3">Sub Total</td>
<td class="table-style" style="font-weight:bold;">' . rupiah($sub_total) . '</td>
</tr>
</table>
<p style="text-align:center;margin:0;">Dicetak Oleh : <span style="font-weight:bold;">' . $_SESSION["username"] . '</span></p>
<p style="text-align:center;margin:3px;">Dicetak Pada : <span style="font-weight:bold;">' . date('d-m-Y') . '</span></p>';
$mpdf->WriteHTML($html);
$file_name = "Faktur No. " . $data["id_sewa"] . ".pdf";
$mpdf->Output($file_name, \Mpdf\Output\Destination::INLINE);
