const HASNOLAMASEWA = ["RP", "RW", "FG"];

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

function tampilTotalKeranjang() {
  let hargaInput = $(".detail-jasa").find(".harga");
  let lamaSewaInput = $(".atur-lama-sewa").find(".input-lama-sewa");
  let harga = [];
  let lamaSewa = [];
  hargaInput.each(function (index, element) {
    harga.push(element.value);
  });

  lamaSewaInput.each(function (index, element) {
    lamaSewa.push(element.value);
  });

  let tampilHarga = 0;
  for (let i = 0; i < harga.length; i++) {
    let counter = 0;
    for (let j = 0; j < lamaSewa[i]; j += 3) {
      counter++;
    }
    tampilHarga += harga[i] * counter;
  }
  return tampilHarga;
}

function alertPengembalian() {
  $pesan = "Apakah Anda yakin untuk menyelesaikan penyewaan?";
  if (confirm($pesan) == true) {
    return true;
  } else {
    return false;
  }
}

function generateTableDetailJasa(data) {
  $(".modal-body-detail").html(null);
  let table = $("<table class='table table-bordered'></table>");
  let tRow = $("<tr></tr>");
  let tHeadGambar = $("<th>Gambar Jasa</th>");
  let tHeadKodeJasa = $("<th>Kode Jasa</th>");
  let tHeadLamaSewa = $("<th>Lama Sewa</th>");
  let tHeadHargaSewa = $("<th>Harga Sewa</th>");
  let tHeadStatus = $("<th>Status Sewa</th>");
  let tHeadTanggalKembali = $("<th>Tanggal Kembali</th>");
  tRow
    .append(tHeadGambar)
    .append(tHeadKodeJasa)
    .append(tHeadLamaSewa)
    .append(tHeadHargaSewa)
    .append(tHeadStatus)
    .append(tHeadTanggalKembali);
  table.append(tRow);
  $(".modal-body-detail").append(table);
  data.forEach((element) => {
    let ket_jasa = null;
    if (element.nama_detail_jasa == null) ket_jasa = element.nama_jasa;
    else ket_jasa = element.nama_detail_jasa;
    let tRow = $("<tr></tr>");
    let tDataGambar = $(
      `<td><img src='assets/upload_img/${element.gambar}' class='img-thumbnail' width='150'/></td>`
    );
    let tDataKodeJasa = $(`<td>${ket_jasa} ${element.kode_jasa}</td>`);
    let lamaSewa = `${element.lama_sewa} Hari`;
    if (HASNOLAMASEWA.includes(element.kode_jasa.substring(0, 2))) {
      lamaSewa = "Tidak Ada";
    }
    let tDataLamaSewa = $(`<td>${lamaSewa}</td>`);
    let counter = 0;
    for (let i = 0; i < element.lama_sewa; i += 3) {
      counter++;
    }
    let tampilHarga = element.harga_sewa * counter;
    let tDataHargaSewa = $(`<td>${rupiah(tampilHarga)}</td>`);
    let tDataStatus = $(`<td>${element.status_sewa}</td>`);
    let tDataTanggalKembali = $(`<td>
      ${
        element.tanggal_dikembalikan == null
          ? element.tanggal_dikembalikan
          : formatTanggal(element.tanggal_dikembalikan)
      }</td>`);
    tRow
      .append(tDataGambar)
      .append(tDataKodeJasa)
      .append(tDataLamaSewa)
      .append(tDataHargaSewa)
      .append(tDataStatus)
      .append(tDataTanggalKembali);
    table.append(tRow);
  });
}

function generateTableListJasa(data) {
  $(".modal-body-detail").html(null);
  let table = $("<table class='table table-bordered'></table>");
  let tRow = $("<tr></tr>");
  let tHeadGambar = $("<th>Gambar Jasa</th>");
  let tHeadKodeJasa = $("<th>Kode Jasa</th>");
  let tHeadLamaSewa = $("<th>Lama Sewa</th>");
  let tHeadHargaSewa = $("<th>Harga Sewa</th>");
  let tHeadStatus = $("<th>Status Sewa</th>");
  let tHeadTanggalKembali = $("<th>Tanggal Kembali</th>");
  let tHeadAksi = $("<th>Aksi</th>");
  tRow
    .append(tHeadGambar)
    .append(tHeadKodeJasa)
    .append(tHeadLamaSewa)
    .append(tHeadHargaSewa)
    .append(tHeadStatus)
    .append(tHeadTanggalKembali)
    .append(tHeadAksi);
  table.append(tRow);
  $(".modal-body-detail").append(table);
  data.forEach((element) => {
    let ket_jasa = null;
    if (element.nama_detail_jasa == null) ket_jasa = element.nama_jasa;
    else ket_jasa = element.nama_detail_jasa;
    let tRow = $("<tr></tr>");
    let tDataGambar = $(
      `<td><img src='assets/upload_img/${element.gambar}' class='img-thumbnail' width='150'/></td>`
    );
    let tDataKodeJasa = $(`<td>${ket_jasa} ${element.kode_jasa}</td>`);
    let lamaSewa = `${element.lama_sewa} Hari`;
    let aksi = true;
    if (HASNOLAMASEWA.includes(element.kode_jasa.substring(0, 2))) {
      lamaSewa = "Tidak Ada";
      aksi = false;
    }
    let tDataLamaSewa = $(`<td>${lamaSewa}</td>`);
    let counter = 0;
    for (let i = 0; i < element.lama_sewa; i += 3) {
      counter++;
    }
    let tampilHarga = element.harga_sewa * counter;
    let tDataHargaSewa = $(`<td>${rupiah(tampilHarga)}</td>`);
    let tDataStatus = $(`<td>${element.status_sewa}</td>`);
    let tDataTanggalKembali = $(
      `<td>${
        element.tanggal_dikembalikan == null
          ? element.tanggal_dikembalikan
          : formatTanggal(element.tanggal_dikembalikan)
      }</td>`
    );
    let tDataAksi = $(
      aksi
        ? `<td><button type='button' class='btn btn-primary btn-dikembalikan' style='background-color:var(--bs-primary);color:var(--bs-light);' data-idtrans='${element.id_transaksi}' data-kodejasa='${element.kode_jasa}'>Dikembalikan</button></td>`
        : `<td>Tidak Memerlukan Aksi</td>`
    );
    tRow
      .append(tDataGambar)
      .append(tDataKodeJasa)
      .append(tDataLamaSewa)
      .append(tDataHargaSewa)
      .append(tDataStatus)
      .append(tDataTanggalKembali)
      .append(tDataAksi);
    table.append(tRow);
  });
}

function generateTablePengembalian(data) {
  $("#regenerateTable").html(null);
  let table = $(
    "<table id='example' class='table table-striped table-bordered' style='width:100%'></table>"
  );
  let tHead = $("<thead></thead>");
  let tRowHead = $("<tr></tr>");
  let tHeadNoTrans = $("<th>No. Transaksi</th>");
  let tHeadTglTrans = $("<th>Tanggal Transaksi</th>");
  let tHeadDataPenyewa = $("<th>Data Penyewa</th>");
  let tHeadTglSewa = $("<th>Tanggal Sewa</th>");
  let tHeadMetBay = $("<th>Metode Bayar</th>");
  let tHeadAksi = $("<th>Aksi</th>");
  tRowHead
    .append(tHeadNoTrans)
    .append(tHeadTglTrans)
    .append(tHeadDataPenyewa)
    .append(tHeadTglSewa)
    .append(tHeadMetBay)
    .append(tHeadAksi);
  tHead.append(tRowHead);
  table.append(tHead);
  let tBody = $("<tbody></tbody>");
  data.forEach((element) => {
    let tRowBody = $("<tr></tr>");
    let tDataNoTrans = $(`<td>${element.id}</td>`);
    let tDataTglTrans = $(
      `<td>${formatTanggal(element.tanggal_transaksi)}</td>`
    );
    let tDataPenyewa = $(
      `<td>${element.nama} | ${element.alamat} | ${element.no_hp}</td>`
    );
    let tDataTglSewa = $(`<td>${formatTanggal(element.tanggal_sewa)}</td>`);
    let tDataMetBay = $(`<td>${element.metode_bayar}</td>`);
    let tDataAksi = $(
      `<td><button class='btn btn-primary btn-sewa-detail' data-bs-toggle='modal' data-bs-target='#detail' data-id='${element.id}'>Detail</button></td>`
    );
    tRowBody
      .append(tDataNoTrans)
      .append(tDataTglTrans)
      .append(tDataPenyewa)
      .append(tDataTglSewa)
      .append(tDataMetBay)
      .append(tDataAksi);
    tBody.append(tRowBody);
  });
  table.append(tBody);
  $("#regenerateTable").html(table);
  new DataTable("#example");
}

$(function () {
  new DataTable("#example");
  new DataTable("#example2");

  $(document).on("keypress", "#noHp", function (e) {
    const isValid = /\d/.test(String.fromCharCode(e.which));
    if (!isValid) e.preventDefault();
  });

  $(document).on("change", "#tipeJasa", function () {
    $("#detailJasa").remove();
    $("#detailRias").remove();
    const id = $(this).val();
    $.ajax({
      url: `utils/get_det_jasa.php?id=${id}`,
      method: "get",
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

  //WARNINGGGG
  $(document).on("click", ".btn-gambar", function () {
    const id = $(this).data("id");
    $.ajax({
      url: `utils/get_jasa.php?id=${id}`,
      method: "get",
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
    $("#detailListJasa").text(`Daftar Jasa Pada Nomor Transaksi ${id}`);
    $.ajax({
      url: `utils/get_det_sewa.php?id=${id}`,
      method: "get",
      dataType: "json",
      success: function (data) {
        generateTableListJasa(data);
      },
    });
  });

  $(document).on("click", ".btn-sewa-detail-laporan", function () {
    const id = $(this).data("id");
    $("#detailListJasa").text(`Daftar Jasa Pada Nomor Transaksi ${id}`);
    $.ajax({
      url: `utils/get_det_sewa_laporan.php?id=${id}`,
      method: "get",
      dataType: "json",
      success: function (data) {
        generateTableDetailJasa(data);
      },
    });
  });

  $(document).on("click", ".btn-dikembalikan", function () {
    const id = $(this).data("idtrans");
    const kodeJasa = $(this).data("kodejasa");
    if (alertPengembalian()) {
      $.ajax({
        url: `utils/up_balik_sewa.php?idtrans=${id}&kodejasa=${kodeJasa}`,
        method: "post",
        success: function () {
          $.ajax({
            url: `utils/get_det_sewa.php?id=${id}`,
            method: "get",
            dataType: "json",
            success: function (data) {
              alert("Berhasil Menyelesaikan Penyewaan Jasa!");
              generateTableListJasa(data);
              $.ajax({
                url: `utils/get_pengembalian.php`,
                method: "get",
                dataType: "json",
                success: function (data) {
                  generateTablePengembalian(data);
                },
              });
            },
          });
        },
      });
    }
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
      window.open(
        `reports/laporan_sewa.php?tglawal=${tanggalAwal}&tglakhir=${tanggalAkhir}`,
        `_blank`
      );
    }
  });

  $(document).on("click", ".btn-close-periode", function () {
    $(".form-tanggal-awal").val("");
    $(".form-tanggal-akhir").val("");
    $(".alert-warning-periode").addClass("d-none");
  });

  //logic untuk total di keranjang start
  $("#total").text(rupiah(tampilTotalKeranjang()));
  //logic untuk total di keranjang end

  $(document).on("click", ".btn-kurang", function () {
    const idJasa = $(this).data("idjasa");
    if ($(`#${idJasa}`).val() == 3) {
      alert("Lama Sewa Berada Pada Nilai Minimum!");
    } else {
      $.ajax({
        url: `utils/up_lama_sewa.php?idjasa=${idJasa}&aksi=0`,
        method: "post",
        dataType: "json",
        success: function (data) {
          $(`#${idJasa}`).val(data);
          $("#total").text(rupiah(tampilTotalKeranjang()));
        },
      });
    }
  });

  $(document).on("click", ".btn-tambah", function () {
    const idJasa = $(this).data("idjasa");
    $.ajax({
      url: `utils/up_lama_sewa.php?idjasa=${idJasa}&aksi=1`,
      method: "post",
      dataType: "json",
      success: function (data) {
        $(`#${idJasa}`).val(data);
        $("#total").text(rupiah(tampilTotalKeranjang()));
      },
    });
  });

  $(document).on("click", ".btn-beli", function () {
    $(".total-to-pay").text(rupiah(tampilTotalKeranjang()));
  });
});
