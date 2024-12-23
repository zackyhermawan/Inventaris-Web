<?php
$conn = mysqli_connect("localhost", "root", "", "tubes_pwb");

if(isset($_POST['addnewbarang'])){
    $namaproduk = $_POST['namaproduk'];
    $kd_produk = $_POST['kd_produk'];
    $kategorinya = $_POST['kategorinya'];
    $hargajual = $_POST['hargajual'];
    $stok = $_POST['stok'];

    $addtobarang = mysqli_query($conn, "insert into produk (namaproduk, kd_produk, idkategori, hargajual, stok) values('$namaproduk', '$kd_produk', '$kategorinya', '$hargajual', '$stok')");
    if($addtobarang){
        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: '{$namaproduk} berhasil ditambahkan.',
                        showConfirmButton: false,
                        timer: 2000
                    });
                });
              </script>";
    }
}

if(isset($_POST['updatebarang'])){
    $idb = $_POST['idproduk'];
    $namaproduk = $_POST['namaproduk'];
    $kd_produk = $_POST['kd_produk'];
    $kategori = $_POST['kategori'];
    $hargajual = $_POST['hargajual'];

    $update = mysqli_query($conn, "UPDATE produk set
    kd_produk = '$kd_produk',
    namaproduk = '$namaproduk',
    idkategori = (SELECT idkategori FROM kategori where idkategori = '$kategori'),
    hargajual = '$hargajual'
    where idproduk = '$idb'
    ");

    if($update){
        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Barang {$namaproduk} berhasil di edit.',
                        showConfirmButton: true
                    });
                });
              </script>";
    }
}

if(isset($_POST['deletebarang'])){
    $idb = $_POST['idproduk'];
    $namaproduk = $_POST['namaproduk'];

    $hapus = mysqli_query($conn, "delete from produk where idproduk = '$idb'");
    if($hapus){
        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Barang {$namaproduk} berhasil di hapus.',
                        showConfirmButton: true
                    });
                });
              </script>";
    }

}

// Tambah, Edit dan Delete Barang Masuk
if(isset($_POST['addbarangmasuk'])){
    $barangnya = $_POST['barangnya'];
    $qty = $_POST['qty'];

    $cekstok = mysqli_query($conn, "SELECT * from produk where idproduk = '$barangnya'");
    $ambildata = mysqli_fetch_array($cekstok);

    $stoksekarang = $ambildata['stok'];
    $tambahstok = $stoksekarang + $qty;

    $addtomasuk = mysqli_query($conn, "insert into masuk (idproduk, qty) values ('$barangnya', '$qty')");
    $updatestokmasuk = mysqli_query($conn, "update produk set stok='$tambahstok' where idproduk='$barangnya'");
    if($addtomasuk&&$updatestokmasuk){
        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Barang masuk berhasil ditambahkan.',
                        showConfirmButton: false,
                        timer: 2000
                    });
                });
              </script>";
    }
}

if(isset($_POST['editbarangmasuk'])){
    $idm = $_POST['idmasuk'];
    $idproduk = $_POST['idproduk'];
    $qtylama = $_POST['qtylama'];
    $qtybaru = $_POST['qtybaru'];

    $selisih = $qtybaru - $qtylama;
    $updatestok = mysqli_query($conn, "UPDATE produk set stok = stok + '$selisih' where idproduk = '$idproduk'");

    if($updatestok){
        $updatebarangmasuk = mysqli_query($conn, "UPDATE masuk set qty = '$qtybaru' where idmasuk = '$idm'");
        if($updatebarangmasuk){
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Edit Barang Masuk berhasil disimpan.',
                        showConfirmButton: true
                    });
                });
              </script>";
        }
    }
}

if(isset($_POST['hapusbarangmasuk'])){
    $idm = $_POST['idmasuk'];
    $idproduk = $_POST['idproduk'];
    $qty = $_POST['qty'];

    $updatestok = mysqli_query($conn, "UPDATE produk set stok = stok - '$qty' where idproduk = '$idproduk'");

    if($updatestok){
        $hapusbarangmasuk = mysqli_query($conn, "DELETE from masuk where idmasuk = '$idm'");
        if($hapusbarangmasuk){
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Barang Masuk berhasil dihapus.',
                        showConfirmButton: true
                    });
                });
            </script>";
        }
    }

}

// Tambah, Edit dan Delete Keluar
if(isset($_POST['addbarangkeluar'])){
    $barangnya = $_POST['barangnya'];
    $qty = $_POST['qty'];

    $cekstok = mysqli_query($conn, "SELECT * from produk where idproduk = '$barangnya'");
    $ambildata = mysqli_fetch_array($cekstok);

    $stoksekarang = $ambildata['stok'];
    $tambahstok = $stoksekarang - $qty;

    $addtokeluar = mysqli_query($conn, "insert into keluar (idproduk, qty) values ('$barangnya', '$qty')");
    $updatestokkeluar = mysqli_query($conn, "update produk set stok='$tambahstok' where idproduk='$barangnya'");
    if($addtokeluar&&$updatestokkeluar){
        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Barang Keluar berhasil ditambahkan.',
                        showConfirmButton: false,
                        timer: 2000
                    });
                });
              </script>";
    }
}


if (isset($_POST['editbarangkeluar'])) {
    $idkl = $_POST['idmasuk'];
    $idproduk = $_POST['idproduk'];
    $qtylama = $_POST['qtylama'];
    $qtybaru = $_POST['qtybaru'];

    $selisih = $qtybaru - $qtylama;

    $updateStokQuery = "UPDATE produk SET stok = stok - '$selisih' WHERE idproduk = '$idproduk'";
    $updatestok = mysqli_query($conn, $updateStokQuery);

    if ($updatestok) {
        $updateKeluarQuery = "UPDATE keluar SET qty = '$qtybaru' WHERE idkeluar = '$idkl'";
        $updatebarangkeluar = mysqli_query($conn, $updateKeluarQuery);

        if ($updatebarangkeluar) {
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Edit Barang Keluar berhasil disimpan.',
                        showConfirmButton: true
                    })
                });
            </script>";
        }
    } 
}

if(isset($_POST['hapusbarangkeluar'])){
    $idkl = $_POST['idkeluar'];
    $idproduk = $_POST['idproduk'];
    $qty = $_POST['qty'];

    $updatestok = mysqli_query($conn, "UPDATE produk set stok = stok + '$qty' where idproduk = '$idproduk'");
    if($updatestok){
        $hapusbarangkeluar = mysqli_query($conn, "DELETE from keluar where idkeluar = '$idkl'");
        if($hapusbarangkeluar){
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Barang Keluar berhasil dihapus.',
                        showConfirmButton: true
                    })
                });
            </script>";
        }
    }
}

// Tambah, Edit dan Delete Kategori
if(isset($_POST['addnewkategori'])){
    $namakategori = $_POST['namakategori'];

    $tambahkategori = mysqli_query($conn, "insert into kategori (namakategori) values ('$namakategori')");
    if($tambahkategori){
        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Kategori {$namakategori} berhasil ditambahkan.',
                        showConfirmButton: false,
                        timer: 2000
                    });
                });
              </script>";
    }
}

if(isset($_POST['editkategori'])){
    $namakategori = $_POST['namakategori'];
    $idk = $_POST['idkategori'];

    $updatekategori = mysqli_query($conn, "UPDATE kategori set namakategori = '$namakategori' where idkategori = '$idk'");
    if($updatekategori){
        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Edit Kategori berhasil disimpan.',
                        showConfirmButton: true
                    });
                });
              </script>";
    }
}

if(isset($_POST['hapuskategori'])){
    $idk = $_POST['idkategori'];

    $hapuskategori = mysqli_query($conn, "DELETE from kategori where idkategori = '$idk'");
    if($hapuskategori){
        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Kategori berhasil dihapus.',
                        showConfirmButton: true
                    });
                });
              </script>";
    }
}
?>