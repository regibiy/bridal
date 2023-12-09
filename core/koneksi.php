<?php
define("SERVERNAME", "localhost");
define("USERNAME", "admin");
define("PASSWORD", "4dm1n");
define("DATABASENAME", "db_bridal");

$conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DATABASENAME);

if ($conn->connect_error) {
    die($conn->connect_error);
}
