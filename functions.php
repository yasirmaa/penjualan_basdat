<?php
$host = 'localhost';
$port = '5432';
$database = 'db_penjualan';
$user = 'postgres';
$password = '13';

try {
    $db = pg_connect("host=localhost dbname=db_penjualan user=postgres password=13");
    // echo "Koneksi sukses!";
} catch (PDOException $e) {
    echo "Koneksi gagal: " . $e->getMessage();
}

// ====== Pelanggan ======//
function tambah_pelanggan($data)
{
    global $db;
    $nama = $data['nama'];
    $jenis_kelamin = $data['jenis_kelamin'];
    $no_telp = $data['no_telp'];
    $alamat = $data['alamat'];

    $query = "INSERT INTO pembeli (nama_pembeli, jenis_kelamin, no_telp, alamat) VALUES ('$nama', '$jenis_kelamin', '$no_telp', '$alamat')";
    $result = pg_query($db, $query);
    if ($result) {
        return true;
    } else {
        return false;
    }
}

function edit_pelanggan($data)
{
    global $db;
    $id_pembeli = $data['id_pembeli'];
    $nama_pembeli = $data['nama_pembeli'];
    $jenis_kelamin = $data['jenis_kelamin'];
    $no_telp = $data['no_telp'];
    $alamat = $data['alamat'];

    $query = "UPDATE pembeli SET nama_pembeli='$nama_pembeli', jenis_kelamin='$jenis_kelamin', no_telp='$no_telp', alamat='$alamat' WHERE id_pembeli = $id_pembeli";
    $result = pg_query($db, $query);
    if ($result) {
        return true;
    } else {
        return false;
    }
}

// ====== Pemasok ======//
function tambah_pemasok($data)
{
    global $db;
    $id_pemasok = $data['id_pemasok'];
    $nama = $data['nama'];
    $no_telp = $data['no_telp'];
    $alamat = $data['alamat'];

    $query = "INSERT INTO pemasok (nama_pemasok, no_telp, alamat) VALUES ('$nama', '$no_telp', '$alamat')";
    $result = pg_query($db, $query);
    if ($result) {
        return true;
    } else {
        return false;
    }
}

function edit_pemasok($data)
{
    global $db;
    $id_pemasok = $data['id_pemasok'];
    $nama_pemasok = $data['nama_pemasok'];
    $no_telp = $data['no_telp'];
    $alamat = $data['alamat'];

    $query = "UPDATE pemasok SET nama_pemasok='$nama_pemasok', no_telp='$no_telp', alamat='$alamat' WHERE id_pemasok = $id_pemasok";
    $result = pg_query($db, $query);
    if ($result) {
        return true;
    } else {
        return false;
    }
}

// ====== Barang ======//
function tambah_barang($data)
{
    global $db;
    $kode_barang = $data['kode_barang'];
    $nama_barang = $data['nama_barang'];
    $harga = $data['harga'];
    $stok = $data['stok'];
    $id_pemasok = $data['id_pemasok'];

    $query = "INSERT INTO barang (kode_barang, nama_barang, harga, stok, id_pemasok) VALUES ('$kode_barang', '$nama_barang', '$harga', '$stok', '$id_pemasok')";
    $result = pg_query($db, $query);
    if ($result) {
        return true;
    } else {
        return false;
    }
}

function edit_barang($data)
{
    global $db;
    $id_barang = $data['id_barang'];
    $kode_barang = $data['kode_barang'];
    $nama_barang = $data['nama_barang'];
    $harga = $data['harga'];
    $stok = $data['stok'];

    $query = "UPDATE barang SET kode_barang='$kode_barang', nama_barang='$nama_barang', harga='$harga', stok='$stok' WHERE id_barang = $id_barang";
    $result = pg_query($db, $query);
    if ($result) {
        return true;
    } else {
        return false;
    }
}

// ====== Pesanan ======//
function tambah_transaksi($data)
{
    global $db;
    $id_pembeli = $data['id_pembeli'];
    $id_barang = $data['id_barang'];
    $kuantitas = $data['kuantitas'];
    $tgl_transaksi = $data['tgl_transaksi'];
    $kode_transaksi = $data['kode_transaksi'];

    $result = pg_query($db, "SELECT * FROM barang WHERE id_barang = $id_barang");
    $barang = pg_fetch_assoc($result);
    $total_harga = $barang['harga'] * $kuantitas;

    $stok_baru = $barang['stok'] - $kuantitas;

    $query = "INSERT INTO transaksi (id_barang, id_pembeli, kuantitas, total_harga, tgl_transaksi, kode_transaksi) VALUES ('$id_barang', '$id_pembeli', '$kuantitas', '$total_harga', '$tgl_transaksi', '$kode_transaksi')";
    $result = pg_query($db, $query);
    if ($result) {
        pg_query($db, "UPDATE barang SET stok='$stok_baru'  WHERE id_barang = $id_barang");
        return true;
    } else {
        return false;
    }
}

function edit_transaksi($data)
{
    global $db;
    $id_transaksi = $data['id_transaksi'];
    $id_pembeli = $data['id_pembeli'];
    $id_barang = $data['id_barang'];
    $kuantitas = $data['kuantitas'];
    $kuantitas_lama = $data['kuantitas_lama'];
    $tgl_transaksi = $data['tgl_transaksi'];
    $kode_transaksi = $data['kode_transaksi'];

    $result = pg_query($db, "SELECT * FROM barang WHERE id_barang = $id_barang");
    $barang = pg_fetch_assoc($result);

    $stok_reset = $barang['stok'] + $kuantitas_lama;
    $stok_baru = $stok_reset - $kuantitas;

    $total_harga = $barang['harga'] * $kuantitas;

    $query = "UPDATE transaksi SET kode_transaksi='$kode_transaksi', tgl_transaksi='$tgl_transaksi', kuantitas='$kuantitas', total_harga='$total_harga' WHERE id_transaksi = $id_transaksi";
    $result = pg_query($db, $query);
    if ($result) {
        pg_query($db, "UPDATE barang SET stok='$stok_baru'  WHERE id_barang = $id_barang");
        return true;
    } else {
        return false;
    }
}

// ====== Pembayaran ======//
function tambah_pembayaran($data)
{
    global $db;
    $id_transaksi = $data['kode_transaksi'];
    $metode = $data['metode'];
    $total_bayar = $data['total_bayar'];
    $tgl_bayar = $data['tgl_bayar'];

    $query = "INSERT INTO pembayaran (id_transaksi, metode, total_bayar, tgl_bayar) VALUES ('$id_transaksi', '$metode', '$total_bayar', '$tgl_bayar')";
    $result = pg_query($db, $query);
    if ($result) {
        return true;
    } else {
        return false;
    }
}
