function alertQty() {
  alert("Stok Tidak Tersedia!");
}

$(function () {
  $(document).on("change", "#tipeJasa", function () {
    $("#detailJasa").remove();
    $("#detailRias").remove();
    const id = $(this).val();
    $.ajax({
      url: `utils/get_det_jasa.php?id=${id}`,
      method: "post",
      dataType: "json",
      success: function (data) {
        if (data.length == 0) {
          let input = $("<input />");
          input
            .attr("type", "hidden")
            .attr("id", "detailJasa")
            .attr("name", "detail_jasa")
            .attr("class", "d-none")
            .attr("value", "0-Dekorasi");
          // input
          //   .attr("class", "form-control")
          //   .attr("name", "detail_jasa")
          //   .attr("id", "detailJasa")
          //   .attr("placeholder", "Silakan Isi Detail Dekorasi");
          $("#jasa").append(input);
          $("#qtyGroup").addClass("d-none");
          $("#qty").val("0");
        } else {
          $("#qtyGroup").removeClass("d-none");
          $("#qty").val("");
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
      $("#subTotal").val(hasil);
    }
  });
});
