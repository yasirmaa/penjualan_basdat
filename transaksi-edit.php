<?php
require 'functions.php';

// ===== Tampil semua transaksi
$result = pg_query($db, "SELECT * FROM barang INNER JOIN transaksi ON barang.id_barang = transaksi.id_barang INNER JOIN pembeli ON transaksi.id_pembeli = pembeli.id_pembeli ORDER BY id_transaksi");
$Transaksi = [];
while ($transaksi = pg_fetch_assoc($result)) {
    $Transaksi[] = $transaksi;
}

// ===== Tampil semua barang
$result = pg_query($db, "SELECT * FROM barang ORDER BY id_barang");
$Barang = [];
while ($barang = pg_fetch_assoc($result)) {
    $Barang[] = $barang;
}

// ===== Tampil semua pembeli
$result = pg_query($db, "SELECT * FROM pembeli ORDER BY id_pembeli");
$Pembeli = [];
while ($pembeli = pg_fetch_assoc($result)) {
    $Pembeli[] = $pembeli;
}

// ===== Tampil yang di edit
$id_transaksi = $_GET['edit_transaksi'];

$result = pg_query($db, "SELECT * FROM transaksi 
                                INNER JOIN barang ON transaksi.id_barang = barang.id_barang 
                                INNER JOIN pembeli ON transaksi.id_pembeli = pembeli.id_pembeli 
                                WHERE id_transaksi = $id_transaksi");
$edit_transaksi = pg_fetch_assoc($result);

// ===== Edit transaksi
if (isset($_POST['edit'])) {
    if (edit_transaksi($_POST)) {
        echo "
          <script> 
              alert ('Data Berhasil di edit!');
              document.location.href = 'transaksi.php';
          </script>
          ";
    } else {
        echo "Error: ";
    }
}

// ===== Hapus transaksi
if (isset($_GET['hapus_transaksi'])) {
    $id_transaksi = $_GET['hapus_transaksi'];
    $result = pg_query($db, "DELETE FROM transaksi WHERE id_transaksi = $id_transaksi");
    if ($result) {
        echo "
          <script> 
              alert ('Data Berhasil Dihapus!');
              document.location.href = 'transaksi.php';
          </script>
          ";
    } else {
        echo "
          <script> 
              alert ('Data gagal dihapus karena masih melakukan transaksi');
              document.location.href = 'transaksi.php';
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
    <title>Pesanan</title>
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
                    <div class="list-item aktif d-flex flew-row align-items-center">
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
                <div class="header p-4 pe-5 ps-5 shadow mb-4 w-75 bg-light rounded-3">
                    <h5 class="fw-bold mb-4">Edit Pesanan</h5>
                    <form action="" method="POST" enctype="multipart/form-data" class="w-100">
                        <input type="hidden" class="form-control" name="id_transaksi" value="<?= $edit_transaksi['id_transaksi'] ?>">
                        <input type="hidden" class="form-control" name="kuantitas_lama" value="<?= $edit_transaksi['kuantitas'] ?>">
                        <div class="mb-3 row align-items-center">
                            <label for="kode_transaksi" class="col-sm-3 col-form-label">Kode Transaksi</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="kode_transaksi" name="kode_transaksi" required value="<?= $edit_transaksi['kode_transaksi'] ?>">
                            </div>
                        </div>
                        <div class="mb-3 row align-items-center">
                            <label for="id_pembeli" class="col-sm-3 col-form-label">Nama Pelanggan</label>
                            <div class="col-sm-9">
                                <select class="form-select" id="id_pembeli" name="id_pembeli">
                                    <option value="<?= $edit_transaksi['id_pembeli'] ?>" selected><?= $edit_transaksi['nama_pembeli'] ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row align-items-center">
                            <label for="id_barang" class="col-sm-3 col-form-label">Nama Barang</label>
                            <div class="col-sm-9">
                                <select class="form-select" id="id_barang" name="id_barang">
                                    <option value="<?= $edit_transaksi['id_barang'] ?>" selected><?= $edit_transaksi['nama_barang'] ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row align-items-center">
                            <label for="kuantitas" class="col-sm-3 col-form-label">Jumlah Barang</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" id="kuantitas" name="kuantitas" required value="<?= $edit_transaksi['kuantitas'] ?>">
                            </div>
                        </div>
                        <div class="mb-3 row align-items-center">
                            <label for="tgl_transaksi" class="col-sm-3 col-form-label">Tanggal Pemesanan</label>
                            <div class="col-sm-9">
                                <input type="date" class="form-control" id="tgl_transaksi" name="tgl_transaksi" required value="<?= $edit_transaksi['tgl_transaksi'] ?>">
                            </div>
                        </div>
                        <div class="col-12 mt-4 d-flex justify-content-end">
                            <a href="transaksi.php">
                                <button type="button" class="btn btn-secondary me-2">
                                    Kembali
                                </button>
                            </a>
                            <input type="submit" name="edit" value="Simpan" class="btn btn-primary ps-4 pe-4 ">
                        </div>
                    </form>
                </div>
                <div class="daftar-mhs p-4 shadow bg-light rounded-3">
                    <h5 class="fw-bold">Daftar Pesanan</h5>
                    <hr>
                    <div class="table-responsive bg-body mt-3 mb-4 rounded-3 shadow-sm">
                        <table class="table align-middle ">
                            <thead class="table fw-bold" style="background-color: #0096FF;">
                                <tr>
                                    <th class="text-center">No.</th>
                                    <th class="text-center">Kode Transaksi</th>
                                    <th>Nama Pelanggan</th>
                                    <th>Nama Barang</th>
                                    <th class="text-center">Jumlah Barang</th>
                                    <th class="text-center">Total Harga</th>
                                    <th class="text-center">Tanggal Pemesanan</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php foreach ($Transaksi as $transaksi) : ?>
                                    <tr>
                                        <td class="text-center"><?= $i++ ?>.</td>
                                        <td class="text-center"><?= $transaksi['kode_transaksi'] ?></td>
                                        <td><?= $transaksi['nama_pembeli'] ?></td>
                                        <td><?= $transaksi['nama_barang'] ?></td>
                                        <td class="text-center"><?= $transaksi['kuantitas'] ?></td>
                                        <td class="text-center"><?= $transaksi['total_harga'] ?></td>
                                        <td class="text-center"><?= $transaksi['tgl_transaksi'] ?></td>
                                        <td class="text-center">
                                            <a href="transaksi-edit.php?edit_transaksi=<?= $transaksi['id_transaksi'] ?>">
                                                <button type="button" class="btn btn-warning">
                                                    <i class="fa-regular fa-pen-to-square"></i>
                                                </button>
                                            </a>
                                            <a href="transaksi.php?hapus_transaksi=<?= $transaksi['id_transaksi'] ?>" onclick="return confirm('Ingin Menghapus Data Tersebut?');">
                                                <button type="button" class="btn btn-danger"><i class="fa-regular fa-trash-can"></i></button>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
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