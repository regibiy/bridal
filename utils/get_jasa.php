<?php
include_once("../core/koneksi.php");
$id = $_GET["id"];
$sql = "SELECT * FROM tbl_jasa WHERE id = '$id'";
$result = $conn->query($sql);
$data = $result->fetch_all(MYSQLI_ASSOC);
echo json_encode($data);
