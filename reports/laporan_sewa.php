<?php
include_once("../core/aksi.php");

$tanggal_awal = $_GET["tglawal"];
$tanggal_akhir = $_GET["tglakhir"];

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
<p style="font-weight:bold">Detail Kode Nama Jasa</p>';
$sql0 = "SELECT *,
CASE
        WHEN nama_detail_jasa = 'Pakaian Nikah' THEN 'PN'
        WHEN nama_detail_jasa = 'Pakaian Adat' THEN 'PA'
        WHEN nama_detail_jasa = 'Gaun' THEN 'GN'
        WHEN nama_jasa = 'Fotografer' THEN 'FG'
        WHEN nama_jasa = 'Dekorasi' THEN 'DR'
        WHEN nama_detail_jasa = 'Rias Pesta' THEN 'RP'
        WHEN nama_detail_jasa = 'Rias Wisuda' THEN 'RW'
    END AS format_kode
FROM tbl_jenis_jasa LEFT JOIN tbl_detail_jasa ON tbl_jenis_jasa.id = tbl_detail_jasa.id_jasa ORDER BY format_kode";
$result0 = $conn->query($sql0);
$html .= '<ul>';
while ($row0 = $result0->fetch_assoc()) {
    $nama_detail_jasa = $row0["nama_detail_jasa"];
    if (is_null($row0["nama_detail_jasa"])) $nama_detail_jasa = $row0["nama_jasa"];
    $html .= '<li>' . $row0["format_kode"] . " = " . $nama_detail_jasa . '</li>';
}
$html .= '</ul>';
$html .= '
<table class="table-style" style="width:100%;text-align:center;">
<tr>
<td class="table-style" style="font-weight:bold;padding:3px;width:2%;">ID</td>
<td class="table-style" style="font-weight:bold;padding:3px;width:8%;">Tanggal Transaksi</td>
<td class="table-style" style="font-weight:bold;padding:3px;width:8%;">Data Penyewa</td>
<td class="table-style" style="font-weight:bold;padding:3px;width:8%;">Tanggal Sewa</td>
<td class="table-style" style="font-weight:bold;padding:3px;width:6%;">Metode Bayar</td>
<td class="table-style" style="font-weight:bold;padding:3px;width:5%;">Nama Jasa</td>
<td class="table-style" style="font-weight:bold;padding:3px;width:5%;">Lama Sewa</td>
<td class="table-style" style="font-weight:bold;padding:3px;width:8%;">Harga Sewa</td>
<td class="table-style" style="font-weight:bold;padding:3px;width:10%;">Status Sewa</td>
<td class="table-style" style="font-weight:bold;padding:3px;width:8%;">Tanggal Dikembalikan</td>
<td class="table-style" style="font-weight:bold;padding:3px;width:9%;">Total</td>
</tr>';
$grand_total = 0;
$sql = "SELECT * FROM tbl_penyewaan WHERE tanggal_transaksi BETWEEN '$tanggal_awal' AND '$tanggal_akhir'";
$result = $conn->query($sql);
while ($row = $result->fetch_assoc()) {
    $html .= '
    <tr>
    <td class="table-style" style="padding:3px">' . $row["id"] . '</td>
    <td class="table-style" style="padding:3px">' . format_tanggal($row["tanggal_transaksi"]) . '</td>
    <td class="table-style" style="padding:3px">' . $row["nama"] . "<br>" . $row["alamat"] . "<br>" . $row["no_hp"] . '</td>
    <td class="table-style" style="padding:3px">' . format_tanggal($row["tanggal_sewa"]) . '</td>
    <td class="table-style" style="padding:3px">' . $row["metode_bayar"] . '</td>
    ';
    $q = $row["id"];
    $sql2 = "SELECT * FROM tbl_detail_penyewaan WHERE id = '$q'";
    $result2 = $conn->query($sql2);
    $html .= '<td class="table-style">';
    while ($row2 = $result2->fetch_assoc()) {
        $html .= $row2["kode_jasa"] . '<br>';
    }
    $html .= '
    </td>
    <td class="table-style">
    ';
    $result3 = $conn->query($sql2);
    while ($row3 = $result3->fetch_assoc()) {
        $lama_sewa = $row3["lama_sewa"] . " Hari";
        if ($row3["lama_sewa"] == "1") $lama_sewa = "-";
        $html .= $lama_sewa . '<br>';
    }
    $html .= '
    </td>
    <td class="table-style">
    ';
    $result4 = $conn->query($sql2);
    while ($row4 = $result4->fetch_assoc()) {
        $html .= rupiah($row4["harga_sewa"]) . '<br>';
    }
    $html .= '
    </td>
    <td class="table-style">
    ';
    $result5 = $conn->query($sql2);
    while ($row5 = $result5->fetch_assoc()) {
        $html .= $row5["status_sewa"] . '<br>';
    }
    $html .= '
    </td>
    <td class="table-style">
    ';
    $result6 = $conn->query($sql2);
    while ($row6 = $result6->fetch_assoc()) {
        $tanggal_dikembalikan = format_tanggal($row6["tanggal_dikembalikan"]);
        if (is_null($row6["tanggal_dikembalikan"])) $tanggal_dikembalikan = "-";
        $html .= $tanggal_dikembalikan . '<br>';
    }
    $html .= '
    </td>
    <td class="table-style">
    ';
    $result6 = $conn->query($sql2);
    $sub_total = 0;
    while ($row6 = $result6->fetch_assoc()) {
        $counter = 0;
        for ($i = 0; $i < $row6["lama_sewa"]; $i += 3) {
            $counter++;
        }
        $sub_total += $row6["harga_sewa"] * $counter;
    }
    $grand_total += $sub_total;
    $html .=
        rupiah($sub_total) . '<br>' . '
    </td>
    </tr>
    ';
}
$html .= '
</table>
<p style="text-align:right">Total Pendapatan Periode ' . format_tanggal($tanggal_awal) . ' Sampai ' . format_tanggal($tanggal_akhir) . ' : <span style="font-weight:bold">' . rupiah($grand_total) . '</span></p>
';
$mpdf->SetHTMLFooter('
    <table width="100%" style="font-size:12px; font-weight:bold">
        <tr>
            <td width="33%">{DATE j-m-Y}</td>
            <td width="33%" align="center">{PAGENO}/{nbpg}</td>
            <td width="33%" style="text-align: right;">' . $_SESSION["username"] . '</td>
        </tr>
    </table>');

$mpdf->WriteHTML($html);
$file_name = "Laporan Penyewaan " . format_tanggal($tanggal_awal) . " Sampai " . format_tanggal($tanggal_akhir);
$mpdf->Output($file_name, \Mpdf\Output\Destination::INLINE);
