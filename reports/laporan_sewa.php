<?php
include_once("../core/aksi.php");

$tanggal_awal = $_GET["tglawal"];
$tanggal_akhir = $_GET["tglakhir"];

$sql = "SELECT DISTINCT(tanggal_transaksi) FROM tbl_penyewaan WHERE tanggal_transaksi BETWEEN '$tanggal_awal' AND '$tanggal_akhir'";
$result = $conn->query($sql);

require_once '../vendor/autoload.php';
$mpdf = new \Mpdf\Mpdf(['tempDir' => __DIR__ . '/custom/temp/dir/path', 'default_font' => 'dejavusans', 'format' => 'Legal', 'orientation' => 'L']);

$html = '
<style>
.table-style {
    border: 1px solid black;
    border-collapse: collapse;
}
</style>

<h1 style="font-weight:bold;margin:0;padding:0;text-align:center;">GIANT SALON SINTANG</h1>
<p style="margin-top:5px;margin-bottom:0;padding:0;text-align:center;">Jalan YC.Oevang Oeray Baning <br> Kota Sintang <br> Kalimantan Barat</p>
<p style="margin-top:5px;margin-bottom:0;padding:0;text-align:center;">No.HP 082151566633</p>
<hr>
<h2 style="text-align:center;margin-top:12px;margin-bottom:0;">LAPORAN PENYEWAAN</h2>
<p style="margin-top:0;margin-bottom:24px;text-align:center;">Periode ' . format_tanggal($tanggal_awal) . ' Sampai Dengan ' . format_tanggal($tanggal_akhir) . '</p>
';
while ($row = $result->fetch_assoc()) {
    $tanggal = $row["tanggal_transaksi"];
    $html .= '
    <p>Tanggal Transaksi : <span style="font-weight:bold;">' . format_tanggal($tanggal) . '</span></p>
    <table class="table-style" style="width:100%;text-align:center;margin-bottom:32px;">
    <tr>
    <td class="table-style" style="font-weight:bold;padding:3px;width:8%;">ID</td>
    <td class="table-style" style="font-weight:bold;padding:3px;width:20%;">Data Penyewa</td>
    <td class="table-style" style="font-weight:bold;padding:3px;width:8%;">Tanggal Sewa</td>
    <td class="table-style" style="font-weight:bold;padding:3px;width:8%;">Lama Sewa</td>
    <td class="table-style" style="font-weight:bold;padding:3px;width:10%;">Nama Jasa</td>
    <td class="table-style" style="font-weight:bold;padding:3px;width:15%;">Harga</td>
    <td class="table-style" style="font-weight:bold;padding:3px;width:8%;">Metode Bayar</td>
    <td class="table-style" style="font-weight:bold;padding:3px;width:10%;">Status Sewa</td>
    <td class="table-style" style="font-weight:bold;padding:3px;">Total</td>
    </tr>';
    $sql2 = "SELECT *, tbl_penyewaan.id AS id_sewa FROM tbl_penyewaan LEFT JOIN tbl_detail_jasa ON tbl_penyewaan.nama_jasa = tbl_detail_jasa.id WHERE tanggal_transaksi = '$tanggal'";
    $result2 = $conn->query($sql2);
    $total = 0;
    $subtotal = 0;
    // $grandtotal = 0;
    while ($row2 = $result2->fetch_assoc()) {
        if (substr($row2["kode_jasa"], 0, 2) == "DR") {
            $nama_detail_jasa = "Dekorasi";
        } else if (substr($row2["kode_jasa"], 0, 2) == "FG") {
            $nama_detail_jasa = "Fotografer";
        } else {
            $nama_detail_jasa = $row2["nama_detail_jasa"];
        }

        if ($row2["lama_sewa"] == 0) {
            $total = (int)$row2["harga_sewa"];
        } else {
            $total = $row2["harga_sewa"] * $row2["lama_sewa"];
        }

        $subtotal += $total;
        $html .= '
        <tr>
        <td class="table-style" style="padding:3px;">' . $row2["id_sewa"] . '</td>
        <td class="table-style" style="padding:3px;">' . $row2["nama"] . " | " . $row2["alamat"] . " | " . $row2["no_hp"] . '</td>
        <td class="table-style" style="padding:3px;">' . format_tanggal($row2["tanggal_sewa"]) . '</td>
        <td class="table-style" style="padding:3px;">' . $row2["lama_sewa"] . ' Hari</td>
        <td class="table-style" style="padding:3px;">' . $nama_detail_jasa . " " . $row2["kode_jasa"] . '</td>
        <td class="table-style" style="padding:3px;">' . rupiah($row2["harga_sewa"]) . '</td>
        <td class="table-style" style="padding:3px;">' . $row2["metode_bayar"] . '</td>
        <td class="table-style" style="padding:3px;">' . $row2["status_sewa"] . '</td>
        <td class="table-style" style="padding:3px;">' . rupiah($total) . '</td>
        </tr>
        ';
    }
    $grandtotal += $subtotal;
    $html .= '
    <tr>
    <td class="table-style" style="padding:3px;font-weight:bold;text-align:right;" colspan="8">Subtotal</td>
    <td class="table-style" style="padding:3px;font-weight:bold;">' . rupiah($subtotal) . '</td>
    </tr>
    </table>';
}
$html .= '
<p>Total Pendapatan Periode ' . format_tanggal($tanggal_awal) . ' Sampai Dengan ' . format_tanggal($tanggal_akhir) . '</p>
<p style="font-weight:bold;">' . rupiah($grandtotal) . '</p>';
$mpdf->SetHTMLFooter('
<table width="100%">
    <tr>
        <td width="33%">{DATE j-m-Y}</td>
        <td width="33%" align="center">{PAGENO}/{nbpg}</td>
        <td width="33%" style="text-align: right; ">' . $_SESSION["username"] . '</td>
    </tr>
</table>
');
$mpdf->WriteHTML($html);
$file_name = "Faktur No. " . $data["id_sewa"] . ".pdf";
$mpdf->Output($file_name, \Mpdf\Output\Destination::INLINE);
