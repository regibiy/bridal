<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $data["judul"] ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap4.min.css">
    <link href="assets/css/style.css" rel="stylesheet">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark p-3 sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">Giant Salon</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class=" collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link mx-2 fw-bold <?= $data["penanda_beranda"] ?>" aria-current="page" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mx-2 fw-bold <?= $data["penanda_tambah_jasa"] ?>" href="tambah_jasa.php">Tambah Jasa</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mx-2 fw-bold <?= $data["penanda_pengembalian"] ?>" href="pengembalian.php">Pengembalian</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mx-2 fw-bold <?= $data["penanda_laporan"] ?>" href="tambah_jasa.php">Laporan</a>
                    </li>
                    <?php
                    if (login_admin()) {
                        echo "<li class='nav-item'>
                        <a class='nav-link mx-2 fw-bold' href='logout.php'>Hi, " . $_SESSION["username"] . "! Keluar</a>'
                        </li>";
                    } else {
                        echo "<li class='nav-item'>
                        <a class='nav-link mx-2 fw-bold " . $data["penanda_masuk"] . "' href='login.php'>Login</a>
                        </li>";
                    }
                    ?>
                </ul>
            </div>
        </div>
    </nav>