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
    } else if ($kode[1] == "Fotografer Wedding") {
        $format_kode = "FW";
    } else if ($kode[1] == "Fotografer Prewedding") {
        $format_kode = "FP";
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
