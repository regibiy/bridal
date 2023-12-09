<?php
$data = [
  "judul" => "Masuk",
  "penanda_beranda" => "",
  "penanda_tambah_jasa" => "",
  "penanda_pengembalian" => "",
  "penanda_laporan" => "",
  "penanda_masuk" => "active"
];

include_once("core/aksi.php");

if (login_admin()) header("Location: index.php");

include_once("templates/header.php");
?>

<section class="vh-100 gradient-custom">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-12 col-md-8 col-lg-6 col-xl-5">
        <div class="card bg-dark text-white" style="border-radius: 1rem;">
          <div class="card-body p-5 text-center">
            <form action="core/aksi.php" method="post" autocomplete="off">
              <div class="mb-md-5 mt-md-4 pb-5">
                <h2 class="fw-bold mb-2 text-uppercase">Login</h2>
                <p class="text-white-50 mb-5">Silahkan Masukkan Username dan Password</p>
                <div class="form-outline form-white mb-4">
                  <label class="form-label" for="username">Username</label>
                  <input type="text" id="username" name="username" class="form-control form-control-lg" placeholder="username..." required />
                </div>
                <div class="form-outline form-white mb-4">
                  <label class="form-label" for="password">Password</label>
                  <input type="password" id="password" name="password" class="form-control form-control-lg" placeholder="password..." required />
                </div>
                <button class="btn btn-outline-light btn-lg px-5 swalla" name="login" type="submit">Login</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php
include_once("templates/footer.php");
?>