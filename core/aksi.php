<?php
session_start();
include_once("koneksi.php");
include_once("fungsi.php");

if (isset($_POST["login"])) {
    $username = $conn->real_escape_string($_POST["username"]);
    $password = $conn->real_escape_string($_POST["password"]);
    $sql = "SELECT * FROM tbl_admin WHERE username = '$username' AND kata_sandi = '$password'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        if ($data["username"] === $username && $data["kata_sandi"] === $password) {
            $_SESSION["login_admin"] = "Login";
            $_SESSION["username"] = $username;
            $_SESSION["role"] = $data["role"];
            // if else role !IMPORTANT
            alert_with_redirect("Selamat Datang!", "../index.php");
        } else {
            alert_with_redirect("Username Atau Password Salah!", "../login.php");
        }
    } else {
        alert_with_redirect("Username Atau Password Tidak Terdaftar!", "../login.php");
    }
}

if (isset($_POST["tambah_jasa"])) {
    $id_detail_jasa = $conn->real_escape_string($_POST["detail_jasa"]);
    $kode = explode("-", $id_detail_jasa);
    if ($kode[1] == "Gaun") {
        $format_kode = "GN";
    } else if ($kode[1] == "Pakaian Adat") {
        $format_kode = "PA";
    } else if ($kode[1] == "Pakaian Nikah") {
        $format_kode = "PN";
    } else if ($kode[1] == "Dekorasi") {
        $format_kode = "DR";
    } else if ($kode[1] == "Rias Pesta") {
        $format_kode = "RP";
    } else if ($kode[1] == "Rias Wisuda") {
        $format_kode = "RW";
    } else if ($kode[1] == "Fotografer") {
        $format_kode = "FG";
    }

    $result = $conn->query("SELECT MAX(id) AS max_number FROM tbl_jasa WHERE LEFT(id, 2) = '$format_kode'");
    $data = $result->fetch_assoc();
    if ($data["max_number"] === null) {
        $counter_final = "01";
    } else {
        $counter = substr($data["max_number"], 2) + 1;
        if ($counter < 10) {
            $counter_final = "0{$counter}";
        } else {
            $counter_final = $counter;
        }
    }

    $id_jasa = $format_kode . $counter_final;
    $id_jenis_jasa = $conn->real_escape_string($_POST["jenis_jasa"]);
    $id_detail_jasa_2 = $kode[0];
    $qty = $conn->real_escape_string($_POST["qty"]);
    $harga = $conn->real_escape_string($_POST["harga"]);
    $gambar = unggah_gambar($_FILES["gambar"]["name"], $_FILES["gambar"]["size"], $_FILES["gambar"]["tmp_name"], "../assets/upload_img/");
    if ($gambar) {
        $sql = "INSERT INTO tbl_jasa (id, id_jenis_jasa, id_detail_jasa, qty, harga, gambar) VALUES ('$id_jasa', '$id_jenis_jasa', '$id_detail_jasa_2', '$qty', '$harga', '$gambar')";
        $conn->query($sql);
        if ($conn->affected_rows > 0) {
            alert_with_redirect("Data Jasa Berhasil Ditambahkan!", "../tambah_jasa.php");
        } else {
            alert_with_redirect("Data Jasa Gagal Ditambahkan!", "../tambah_jasa.php");
        }
    } else {
        alert_with_redirect("Gambar harus berformat .jpg, .jpeg, .png, dengan ukuran kurang dari 3MB", "../tambah_jasa.php");
    }
}

if (isset($_POST["tambah_sewa"])) {
    $nama = $conn->real_escape_string($_POST["nama"]);
    $alamat = $conn->real_escape_string($_POST["alamat"]);
    $no_hp = $conn->real_escape_string($_POST["no_hp"]);
    $tanggal_sewa = $conn->real_escape_string($_POST["tanggal_sewa"]);
    $lama_sewa = $conn->real_escape_string($_POST["lama_sewa"]);
    $nama_jasa = $conn->real_escape_string($_POST["id_nama_jasa"]);
    $kode_jasa = $conn->real_escape_string($_POST["kode_jasa"]);
    $harga_sewa = $conn->real_escape_string($_POST["harga"]);
    $metode_bayar = $conn->real_escape_string($_POST["metode_bayar"]);
    $status_sewa = $conn->real_escape_string("Belum Dikembalikan");

    $result = $conn->query("SELECT MAX(id) AS max_val FROM tbl_penyewaan WHERE tanggal_transaksi = CURRENT_DATE");
    $data = $result->fetch_assoc();
    if ($data["max_val"] != null) {
        $counter = substr($data["max_val"], 6);
        $counter_temp = $counter + 1;
        if ($counter_temp > 0 && $counter_temp < 10) {
            $counter_final = date("dmy") . "00" . $counter_temp;
        } else if ($counter_temp > 9 && $counter_temp < 100) {
            $counter_final = date("dmy") . "0" . $counter_temp;
        } else if ($counter_temp > 99 && $counter_temp < 1000) {
            $counter_final = date("dmy") . $counter_temp;
        }
    } else {
        $counter_final = date("dmy") . "001";
    }
    $tanggal = date("Y-m-d");
    $sql = "INSERT INTO tbl_penyewaan (id, tanggal_transaksi, nama, alamat, no_hp, tanggal_sewa, lama_sewa, nama_jasa, kode_jasa, harga_sewa, metode_bayar, status_sewa) VALUES ('$counter_final', '$tanggal', '$nama', '$alamat', '$no_hp', '$tanggal_sewa', '$lama_sewa', '$nama_jasa', '$kode_jasa', '$harga_sewa', '$metode_bayar', '$status_sewa')";
    $conn->query($sql);
    if ($conn->affected_rows > 0) {
        alert_with_redirect("Transaksi Penyewaan Berhasil!", "../laporan.php"); //redirect to laporan.php
    } else {
        alert_with_redirect("Transaksi Penyewaan Gagal!", "../index.php");
    }
}

if (isset($_POST["ubah_status"])) {
    $id = $conn->real_escape_string($_POST["id"]);
    $status_sewa = $conn->real_escape_string($_POST["status_sewa"]);
    $sql = "UPDATE tbl_penyewaan SET status_sewa = '$status_sewa' WHERE id = '$id'";
    $conn->query($sql);
    if ($conn->affected_rows > 0) {
        alert_with_redirect("Penyewaan Berhasil DiKonfirmasi", "../pengembalian.php");
    } else {
        alert_with_redirect("Penyewaan Gagal DiKonfirmasi", "../pengembalian.php");
    }
}

if (isset($_POST["tambah_keranjang"])) {
    $id_jasa = $conn->real_escape_string($_POST["id_jasa"]);
    $url = $conn->real_escape_string($_POST["url"]);
    $sql = "SELECT * FROM tbl_keranjang WHERE id_jasa = '$id_jasa'";
    $result = $conn->query($sql);
    $data = $result->fetch_assoc();
    $format_kode = ["RP", "RW", "FG"];
    if ($result->num_rows > 0) {
        $kode = substr($data["id_jasa"], 0, 2);
        if (in_array($kode, $format_kode)) $lama_sewa = 1;
        else $lama_sewa = 3;
        if ($data['id_jasa'] != $id_jasa) {
            $sql = "INSERT INTO tbl_keranjang (id_jasa, lama_sewa) VALUES ('$id_jasa', '$lama_sewa')";
            $conn->query($sql);
            echo "<script>location.href='../index.php#jasa'</script>";
        } else {
            alert_with_redirect("Produk jasa sudah di dalam keranjang!", $url);
        }
    } else {
        $kode = substr($id_jasa, 0, 2);
        if (in_array($kode, $format_kode)) $lama_sewa = 1;
        else $lama_sewa = 3;
        $sql = "INSERT INTO tbl_keranjang (id_jasa, lama_sewa) VALUES ('$id_jasa', '$lama_sewa')";
        $conn->query($sql);
        echo "<script>location.href='../index.php#jasa'</script>";
    }
}

if (isset($_POST["hapus_keranjang"])) {
    $id_jasa = $conn->real_escape_string($_POST["id_jasa"]);
    $sql = "DELETE FROM tbl_keranjang WHERE id_jasa = '$id_jasa'";
    $result = $conn->query($sql);
    echo "<script>location.href='../keranjang.php'</script>";
}
