function alertQty() {
  alert("Stok Tidak Tersedia!");
}

function rupiah(harga) {
  let hasil_rupiah =
    "Rp " + harga.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, "$&,");
  return hasil_rupiah;
}

function formatTanggal(tanggal) {
  let formattedDate = new Date(tanggal);
  let day = formattedDate.getDate();
  let month = formattedDate.getMonth() + 1;
  let year = formattedDate.getFullYear();

  day = day < 10 ? "0" + day : day;
  month = month < 10 ? "0" + month : month;

  return day + "-" + month + "-" + year;
}

$(function () {
  new DataTable("#example");
  new DataTable("#example2");

  $(document).on("change", "#tipeJasa", function () {
    $("#detailJasa").remove();
    $("#detailRias").remove();
    const id = $(this).val();
    $.ajax({
      url: `utils/get_det_jasa.php?id=${id}`,
      method: "post",
      dataType: "json",
      success: function (data) {
        if (id == 1) {
          // detail and qty
          let selectDetail = $("<select></select>");
          selectDetail
            .attr("id", "detailJasa")
            .attr("name", "detail_jasa")
            .attr("class", "form-select");
          let option = $("<option></option>");
          option.attr("selected", true).attr("hidden", true);
          option.text("Silakan Pilih Detail Jasa");
          selectDetail.append(option);
          data.forEach((element) => {
            let option = $("<option></option>");
            option.attr("value", `${element.id}-${element.nama_detail_jasa}`);
            option.text(element.nama_detail_jasa);
            selectDetail.append(option);
          });
          $("#jasa").append(selectDetail);
          $("#qty").val("");
          $("#qtyGroup").removeClass("d-none");
        } else if (id == 2) {
          //hide detail and qty
          let input = $("<input />");
          input
            .attr("type", "hidden")
            .attr("id", "detailJasa")
            .attr("name", "detail_jasa")
            .attr("class", "d-none")
            .attr("value", "0-Dekorasi");
          $("#jasa").append(input);
          $("#qtyGroup").addClass("d-none");
          $("#qty").val("0");
        } else if (id == 3) {
          //hide qty
          let selectDetail = $("<select></select>");
          selectDetail
            .attr("id", "detailJasa")
            .attr("name", "detail_jasa")
            .attr("class", "form-select");
          let option = $("<option></option>");
          option.attr("selected", true).attr("hidden", true);
          option.text("Silakan Pilih Detail Jasa");
          selectDetail.append(option);
          data.forEach((element) => {
            let option = $("<option></option>");
            option.attr("value", `${element.id}-${element.nama_detail_jasa}`);
            option.text(element.nama_detail_jasa);
            selectDetail.append(option);
          });
          $("#jasa").append(selectDetail);
          $("#qtyGroup").addClass("d-none");
          $("#qty").val("0");
        } else if (id == 4) {
          let input = $("<input />");
          input
            .attr("type", "hidden")
            .attr("id", "detailJasa")
            .attr("name", "detail_jasa")
            .attr("class", "d-none")
            .attr("value", "0-Fotografer");
          $("#jasa").append(input);
          $("#qtyGroup").addClass("d-none");
          $("#qty").val("0");
        }
      },
    });
  });

  $(document).on("input", "#lamaSewa", function () {
    $("#subTotal").val("");
    const harga = $("#harga").val();
    const lamaSewa = $("#lamaSewa").val();
    const hasil = parseInt(harga) * parseInt(lamaSewa);
    if (isNaN(hasil)) {
      $("#subTotal").val("");
    } else {
      $("#subTotal").val(rupiah(hasil));
    }
  });

  $(document).on("click", ".btn-gambar", function () {
    const id = $(this).data("id");
    $.ajax({
      url: `utils/get_jasa.php?id=${id}`,
      method: "post",
      dataType: "json",
      success: function (data) {
        $(".modal-title-gambar").text(data[0].id);
        $(".img-fluid-gambar").attr(
          "src",
          `assets/upload_img/${data[0].gambar}`
        );
      },
    });
  });

  $(document).on("click", ".btn-sewa-detail", function () {
    const id = $(this).data("id");
    $.ajax({
      url: `utils/get_det_sewa.php?id=${id}`,
      method: "post",
      dataType: "json",
      success: function (data) {
        $(".modal-title-detail").text(`Detail Penyewaan ${id}`);
        $("#tanggalTransaksiDetail").text(
          `Tanggal Transaksi : ${formatTanggal(data[0].tanggal_transaksi)}`
        );
        $("#namaDetail").text(`Nama Penyewa : ${data[0].nama}`);
        $("#alamatDetail").text(`Alamat Penyewa : ${data[0].alamat}`);
        $("#hpDetail").text(`No. HP Penyewa : ${data[0].no_hp}`);
        $("#tanggalSewaDetail").text(
          `Tanggal Sewa : ${formatTanggal(data[0].tanggal_sewa)}`
        );
        $("#lamaSewaDetail").text(
          `Lama Sewa : ${formatTanggal(data[0].lama_sewa)}`
        );
        if (data[0].nama_detail_jasa == null) {
          let tempData = data[0].kode_jasa.substr(0, 2);
          if (tempData == "DR") {
            $namaDetailJasa = "Dekorasi";
          } else if (tempData == "FG") {
            $namaDetailJasa = "Fotografer";
          }
        } else {
          $namaDetailJasa = data[0].nama_detail_jasa;
        }
        $("#namaJasaDetail").text(`Nama Jasa : ${$namaDetailJasa}`);
        $("#kodeJasaDetail").text(`Kode Jasa : ${data[0].kode_jasa}`);
        $("#hargaSewaDetail").text(
          `Harga Jasa : ${rupiah(data[0].lama_sewa * data[0].harga_sewa)}`
        );
        $("#metodeBayarDetail").text(
          `Metode Pembayaran : ${data[0].metode_bayar}`
        );
        $("#statusSewaDetail").text(`Status Sewa : ${data[0].status_sewa}`);
      },
    });
  });

  $(document).on("click", ".btn-update-status", function () {
    const id = $(this).data("id");
    $(".id-update-status").val(id);
  });

  $(document).on("click", ".btn-cetak", function () {
    const id = $(this).data("id");
    $(this).attr("href", `reports/faktur.php?id=${id}`);
  });

  $(document).on("click", ".btn-cetak-laporan", function (e) {
    e.preventDefault();
    const tanggalAwal = $(".form-tanggal-awal").val();
    const tanggalAkhir = $(".form-tanggal-akhir").val();
    if (tanggalAwal.length < 1 || tanggalAkhir.length < 1) {
      $(".alert-warning-periode")
        .html("<p class='m-0'>Isi Formulir Periode Laporan dengan Benar!</p>")
        .removeClass("d-none");
    } else {
      location.href = `reports/laporan_sewa.php?tglawal=${tanggalAwal}&tglakhir=${tanggalAkhir}`;
    }
  });

  $(document).on("click", ".btn-close-periode", function () {
    $(".form-tanggal-awal").val("");
    $(".form-tanggal-akhir").val("");
    $(".alert-warning-periode").addClass("d-none");
  });
});
