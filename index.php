<?php
require 'functions.php';

// ===== Tampil semua barang
$barang = pg_query($db, "SELECT COUNT(*) AS byk_barang FROM barang");
$barang = pg_fetch_assoc($barang);
// var_dump($barang['byk_barang']);

// ===== Tampil semua pemasok
$pemasok = pg_query($db, "SELECT COUNT(*) AS byk_pemasok FROM pemasok");
$pemasok = pg_fetch_assoc($pemasok);

// ===== Tampil semua pelanggan
$pelanggan = pg_query($db, "SELECT COUNT(*) AS byk_pelanggan FROM pembeli");
$pelanggan = pg_fetch_assoc($pelanggan);

// ===== Tampil semua pesanan
$pesanan = pg_query($db, "SELECT COUNT(*) AS byk_pesanan FROM transaksi");
$pesanan = pg_fetch_assoc($pesanan);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yamapedia</title>
    <!-- CSS -->
    <link rel="stylesheet" href="./css/style.css?v=<?php echo time(); ?>">
    <!-- Bootsrap5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <!-- css aos -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
    <!-- font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <!-- Font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        a {
            text-decoration: none;
        }
    </style>
</head>

<body>
    <section class="full d-flex" style="min-height: 100vh;">
        <!-- Sidebar -->
        <div class="sidebar position-fixed h-100">
            <div class="content d-flex flex-column p-4" style="width: 260px;">
                <div class="header">
                    <a class="sidebar-brand d-flex align-items-center justify-content-center text-white text-decoration-none" href="index.php">
                        <img src="img/logo-ym-1-white.png" alt="Logo" width="40" height="40" class="d-inline-block align-text-top me-2" />
                        <div class="sidebar-brand-text fw-bold fs-5">Yamapedia</div>
                    </a>
                </div>
                <hr class="border border-white border-1 opacity-100">
                <div class="main mt-3">
                    <div class="list-item aktif d-flex flew-row align-items-center">
                        <a class="d-flex align-items-center text-white" href="index.php">
                            <i class="fa-solid fa-house me-3"></i>
                            <span class="description">Dashboard</span>
                        </a>
                    </div>
                    <div class="list-item  d-flex flew-row align-items-center">
                        <a class="d-flex align-items-center text-white" href="produk.php">
                            <i class="fa-solid fa-tags me-3"></i>
                            <span class="description">Produk</span>
                        </a>
                    </div>
                    <div class="list-item  d-flex flew-row align-items-center">
                        <a class="d-flex align-items-center text-white" href="supplier.php">
                            <i class="fa-solid fa-truck-fast me-3"></i>
                            <span class="description">Pemasok</span>
                        </a>
                    </div>
                    <div class="list-item  d-flex flew-row align-items-center">
                        <a class="d-flex align-items-center text-white" href="pelanggan.php">
                            <i class="fa-solid fa-users me-3"></i>
                            <span class="description">Pelanggan</span>
                        </a>
                    </div>
                    <div class="list-item  d-flex flew-row align-items-center">
                        <a class="d-flex align-items-center text-white" href="transaksi.php">
                            <i class="fa-solid fa-cart-plus me-3"></i>
                            <span class="description">Pesanan</span>
                        </a>
                    </div>
                    <div class="list-item d-flex flew-row align-items-center">
                        <a class="d-flex align-items-center text-white" href="pembayaran.php">
                            <i class="fa-solid fa-money-bills me-3"></i>
                            <span class="description">Pembayaran</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Sidebar -->

        <!-- Main-content -->
        <div class="main-content w-100">
            <!-- Top-Navbar -->
            <nav class="navbar navbar-expand-lg shadow-sm w-100" style="height:64px;">
                <div class="container-fluid d-flex justify-content-end" style="padding-right: 80px;">
                    <div class="dropdown">
                        <a href="#" class="d-flex align-items-center text-black text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            <strong>Admin 1</strong>
                            <img src="img/cr-pp.png" alt="" width="40" height="40" class="rounded-circle ms-2 me-2">
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                            <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#exampleModal">Profile</a></li>
                            <li><a class="dropdown-item" href="#">Settings</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="logout.php">Log out</a></li>
                        </ul>
                    </div>
                </div>
            </nav>
            <!-- End Top -->

            <!-- Content -->
            <div class="container main-content p-5 pt-4">
                <div class="tittle d-flex align-items-center mb-3">
                    <i class="fa-solid fa-house me-3 fs-5"></i>
                    <h3 class="fw-bold m-0">Dashboard</h3>
                </div>
                <div class="header d-flex justify-content-evenly">
                    <div class="dash d-flex align-items-center justify-content-between shadow p-4 pb-2 border-bottom border-danger border-5 rounded-3">
                        <div class="desc-dash">
                            <p class="fw-semibold fs-5 mb-1">Produk</p>
                            <span class="fs-4 ms-3"><?= $barang['byk_barang'] ?></span>
                        </div>
                        <div class="icon-dash-1">
                            <i class="fa-solid fa-tags fs-2"></i>
                        </div>
                    </div>
                    <div class="dash d-flex align-items-center justify-content-between shadow p-4 pb-2 border-bottom border-primary border-5 rounded-3">
                        <div class="desc-dash">
                            <p class="fw-semibold fs-5 mb-1">Pemasok</p>
                            <span class="fs-4 ms-3"><?= $pemasok['byk_pemasok'] ?></span>
                        </div>
                        <div class="icon-dash-2">
                            <i class="fa-solid fa-truck-fast fs-2"></i>
                        </div>
                    </div>
                    <div class="dash d-flex align-items-center justify-content-between shadow p-4 pb-2 border-bottom border-warning border-5 rounded-3">
                        <div class="desc-dash">
                            <p class="fw-semibold fs-5 mb-1">Pelanggan</p>
                            <span class="fs-4 ms-3"><?= $pelanggan['byk_pelanggan'] ?></span>
                        </div>
                        <div class="icon-dash-3">
                            <i class="fa-solid fa-users fs-2"></i>
                        </div>
                    </div>
                    <div class="dash d-flex align-items-center justify-content-between shadow p-4 pb-2 border-bottom border-success border-5 rounded-3">
                        <div class="desc-dash">
                            <p class="fw-semibold fs-5 mb-1">Pesanan</p>
                            <span class="fs-4 ms-3"><?= $pesanan['byk_pesanan'] ?></span>
                        </div>
                        <div class="icon-dash-4">
                            <i class="fa-solid fa-cart-plus fs-2"></i>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End -->
        </div>
        <!-- End Main -->
    </section>

    <!-- Scriot -->
    <script src="./js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>