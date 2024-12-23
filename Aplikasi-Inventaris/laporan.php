<?php
session_start();
require 'function.php';
if (!isset($_SESSION['email'])) {
  header('location: index.php');
  exit();
}

if ($_SESSION['role'] !== 'admin') {
  echo "<script>
        alert('Anda bukan admin. Anda tidak dapat mengakses halaman ini.');
        window.location.href = 'dashboard.php';
        </script>";
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Laporan - ClothStock</title>
  </head>
  <body class="sb-nav-fixed">
    <?php
    include 'navbar.php';
    ?>
    <div id="layoutSidenav">
      <?php
      include 'sidebar.php';
      ?>
      <div id="layoutSidenav_content" class="bg-body-secondary">
        <main>
          <div class="container-fluid px-4">
            <div class="card shadow-sm mt-4 mb-4">
              <div class="card-header bg-white d-flex align-items-center justify-content-between">
                <h4 class="text-info">Laporan Stok</h4>
              </div>
              <div class="card-body">
                <table class="table-striped" id="datatablesSimple">
                  <thead>
                    <tr>
                      <th class="table-dark">No</th>
                      <th>Kode Barang</th>
                      <th>Nama Barang</th>
                      <th>Stok Awal</th>
                      <th>Barang Masuk</th>
                      <th>Barang Keluar</th>
                      <th>Stok Saat Ini</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      $ambildataproduk = mysqli_query($conn, "SELECT idproduk,kd_produk, namaproduk, stok from produk");
                      $i = 1;

                      while($data=mysqli_fetch_array($ambildataproduk)){
                        $idproduk = $data['idproduk'];
                        $namaproduk = $data['namaproduk'];
                        $kd_produk = $data['kd_produk'];
                        $stok = $data['stok'];

                        $barangmasuk = mysqli_query($conn, "SELECT sum(qty) as totalmasuk from masuk where idproduk = '$idproduk'");
                        $datamasuk = mysqli_fetch_array($barangmasuk);
                        $totalmasuk = $datamasuk['totalmasuk'] ?? 0;

                        $barangkeluar = mysqli_query($conn, "SELECT sum(qty) as totalkeluar from keluar where idproduk = '$idproduk'");
                        $datamasuk = mysqli_fetch_array($barangkeluar);
                        $totalkeluar = $datamasuk['totalkeluar'] ?? 0;

                        $stokawal = $stok - $totalmasuk + $totalkeluar;
                    ?>
                        <tr>
                          <td><?=$i++;?></td>
                          <td><?=$kd_produk;?></td>
                          <td><?=$namaproduk;?></td>
                          <td><?=$stokawal;?></td>
                          <td><?=$totalmasuk;?></td>
                          <td><?=$totalkeluar;?></td>
                          <td><?=$stok;?></td>
                        </tr>
                    <?php
                      }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </main>
      </div>
    </div>
  </body>
</html>
