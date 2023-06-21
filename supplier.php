<?php
require 'functions.php';

if (isset($_POST['tambah'])) {
    if (tambah_pemasok($_POST)) {
        echo "
          <script> 
              alert ('Data Berhasil Ditambahkan!');
              document.location.href = 'supplier.php';
          </script>
          ";
    } else {
        echo "Error: ";
    }
}

// ===== Tampil semua pemasok
$result = pg_query($db, "SELECT * FROM pemasok ORDER BY id_pemasok");
while ($pemasok = pg_fetch_assoc($result)) {
    $Pemasok[] = $pemasok;
}

// ===== Hapus pemasok
if (isset($_GET['id_pemasok'])) {
    $id_pemasok = $_GET['id_pemasok'];
    $result = pg_query($db, "DELETE FROM pemasok WHERE id_pemasok = $id_pemasok");
    if ($result) {
        echo "
          <script> 
              alert ('Data Berhasil Dihapus!');
              document.location.href = 'supplier.php';
          </script>
          ";
    } else {
        echo "
          <script> 
              alert ('Data gagal dihapus karena masih melakukan transaksi');
              document.location.href = 'supplier.php';
          </script>
          ";
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemasok</title>
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
                    <div class="list-item  d-flex flew-row align-items-center">
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
                    <div class="list-item aktif d-flex flew-row align-items-center">
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
                    <div class="list-item d-flex flew-row align-items-center">
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
            <nav class="navbar navbar-expand-lg shadow-sm w-100 bg-light" style="height:64px;">
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
            <div class="container main-content p-5">
                <div class="header p-4 pe-5 ps-5 shadow mb-4 w-50 bg-light rounded-3">
                    <h5 class="fw-bold mb-4">Tambah Pemasok</h5>
                    <form action="" method="POST" enctype="multipart/form-data" class="w-100">
                        <div class="mb-3 row align-items-center">
                            <label for="nama" class="col-sm-3 col-form-label">Nama</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="nama" name="nama" required>
                            </div>
                        </div>
                        <div class="mb-3 row align-items-center">
                            <label for="no_telp" class="col-sm-3 col-form-label">Telepon</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="no_telp" name="no_telp" required>
                            </div>
                        </div>
                        <div class="mb-3 row align-items-center">
                            <label for="alamat" class="col-sm-3 col-form-label">Alamat</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="alamat" name="alamat" required>
                            </div>
                        </div>
                        <div class="col-12 mt-4 d-flex justify-content-end">
                            <input type="submit" name="tambah" value="Tambah" class="btn btn-primary ps-4 pe-4 ">
                        </div>
                    </form>
                </div>
                <div class="daftar-mhs p-4 shadow bg-light rounded-3">
                    <h5 class="fw-bold">Daftar Pemasok</h5>
                    <hr>
                    <div class="table-responsive bg-body mt-3 mb-4 rounded-3 shadow-sm">
                        <table class="table align-middle ">
                            <thead class="table fw-bold" style="background-color: #0096FF;">
                                <tr>
                                    <th class="text-center">No.</th>
                                    <th>Nama</th>
                                    <th>No Telepon</th>
                                    <th>Alamat</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php if (isset($Pemasok)) { ?>
                                    <?php foreach ($Pemasok as $pemasok) : ?>
                                        <tr>
                                            <td class="text-center"><?= $i++ ?>.</td>
                                            <td><?= $pemasok['nama_pemasok'] ?></td>
                                            <td><?= $pemasok['no_telp'] ?></td>
                                            <td><?= $pemasok['alamat'] ?></td>
                                            <td class="text-center">
                                                <a href="supplier-edit.php?edit_pemasok=<?= $pemasok['id_pemasok'] ?>">
                                                    <button type="button" class="btn btn-warning">
                                                        <i class="fa-regular fa-pen-to-square"></i>
                                                    </button>
                                                </a>
                                                <a href="supplier.php?id_pemasok=<?= $pemasok['id_pemasok'] ?>" onclick="return confirm('Ingin Menghapus Data Tersebut?');">
                                                    <button type="button" class="btn btn-danger"><i class="fa-regular fa-trash-can"></i></button>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- End Content -->
        </div>
        <!-- End Main -->
    </section>

    <!-- Scriot -->
    <script src="./js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>