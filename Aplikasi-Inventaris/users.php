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
    <title>Data Admin - ClothStock</title>
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
                <h4 class="text-info">Data User</h4>
                <a class="btn btn-dark rounded-pill" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fa-solid fa-circle-plus me-2"></i>Tambah Data</a>
              </div>
              <div class="card-body">
                <table class="table-striped" id="datatablesSimple">
                  <thead>
                    <tr>
                      <th class="table-dark">No</th>
                      <th>Email</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      $ambildata = mysqli_query($conn, "SELECT * from users");
                      $i = 1;

                      while($data = mysqli_fetch_array($ambildata)){
                        $email = $data['email'];
                        $ida = $data['idadmin'];
                    ?>
                      <tr>
                        <td><?=$i++;?></td>
                        <td><?=$email;?></td>
                        <td>
                          <a href="" data-bs-toggle="modal" data-bs-target="#delete<?=$ida;?>"><i class="fa-solid fa-trash-can bg-danger p-2 text-white rounded"></i></a>
                        </td>
                    </tr>
                      <!-- Hapus Data Admin -->
                      <div class="modal fade" id="delete<?=$ida;?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus Data Admin</h1>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                              <form method="post">
                                <div class="modal-body">
                                  <input type="hidden" name="idadmin" value="<?=$ida;?>">
                                  <p class="fw-semibold">Apakah anda yakin ingin menghapus email tersebut?</p>
                                  <button type="submit" class="btn btn-danger text-white" name="hapusdataadmin">Hapus</button>
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  </body>
  <!-- Tambah Data Admin -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Data Admin</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form method="post">
            <div class="modal-body">
              <input type="text" name="email" class="form-control" placeholder="Email" required>
              <br>
              <input type="text" name="password" class="form-control" placeholder="Password" required>
              <br>
              <button type="submit" class="btn btn-info text-white" name="addnewadmin">Tambah</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</html>
