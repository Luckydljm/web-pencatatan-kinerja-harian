<?php

@include '../config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:../login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Page</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>
    
<?php include 'header.php'; ?>

<!-- search pegawai  -->
<section class="show-data">

   <h1 class="heading">Data Pegawai</h1>

   <div class="box-container">

   <?php
      if(isset($_POST['search']) or isset($_POST['search_btn'])){
      $search = $_POST['search'];
      $show_pegawai = $conn->prepare("SELECT * FROM `pegawai`, `subbagian` WHERE pegawai.id_sub = subbagian.id_sub && nama LIKE '%{$search}%'");
      $show_pegawai->execute();
      if($show_pegawai->rowCount() > 0){
         while($fetch_pegawai = $show_pegawai->fetch(PDO::FETCH_ASSOC)){  
   ?>
   <div class="box">
      <div class="nama"><?= $fetch_pegawai['nama']; ?></div>
      <div class="jabatan"><?= $fetch_pegawai['jabatan_peg']; ?></div>
      <div class="details">NIP. <?= $fetch_pegawai['nip']; ?></div>
      <div class="details">Golongan <?= $fetch_pegawai['pangkat_peg']; ?></div>
      <div class="details"><?= $fetch_pegawai['nama_sub']; ?></div>
      <div class="flex-btn">
         <a href="update_pegawai.php?update=<?= $fetch_pegawai['nip']; ?>" class="option-btn">Perbarui</a>
         <a href="pegawai.php?delete=<?= $fetch_pegawai['nip']; ?>" class="delete-btn" onclick="return confirm('Hapus data ini?');">Hapus</a>
      </div>
      <a href="show_cttn_kinerja.php?show=<?= $fetch_pegawai['nip']; ?>" class="btn">Catatan Kinerja</a>
   </div>
   <?php
         }
      }else{
         echo '<p class="empty">Data pegawai tidak ditemukan!</p>';
      }
   }else{
      echo '<p class="empty">Silahkan cari sesuatu!</p>';
   }
   ?>

   </div>

</section>
<!-- end of search pegawai  -->

<!-- search sub bagian  -->
<section class="show-data">

   <h1 class="heading">Data Sub Bagian</h1>

   <div class="box-container">

   
   <?php
      if(isset($_POST['search']) or isset($_POST['search_btn'])){
      $search = $_POST['search'];
      $show_subbagian = $conn->prepare("SELECT * FROM `subbagian` WHERE nama_sub LIKE '%{$search}%'");
      $show_subbagian->execute();
      if($show_subbagian->rowCount() > 0){
         while($fetch_subbagian = $show_subbagian->fetch(PDO::FETCH_ASSOC)){  
   ?>

   <div class="box">
      <div class="nama"><?= $fetch_subbagian['nama_sub']; ?></div>
      <div class="jabatan"><?= $fetch_subbagian['kepala_sub']; ?></div>
      <div class="details">NIP. <?= $fetch_subbagian['nip_kepala']; ?></div>
      <div class="details"><?= $fetch_subbagian['jabatan']; ?></div>
      <div class="details">Golongan <?= $fetch_subbagian['pangkat']; ?></div>
      <div class="flex-btn">
         <a href="update_subbagian.php?update=<?= $fetch_subbagian['id_sub']; ?>" class="option-btn">Perbarui</a>
         <a href="subbagian.php?delete=<?= $fetch_subbagian['id_sub']; ?>" class="delete-btn" onclick="return confirm('Hapus data ini?');">Hapus</a>
      </div>
      <a href="show_pegawai.php?show=<?= $fetch_subbagian['id_sub']; ?>" class="btn">Lihat Pegawai</a>
   </div>
   <?php
         }
      }else{
         echo '<p class="empty">Data sub bagian tidak ditemukan!</p>';
      }
   }else{
      echo '<p class="empty">Silahkan cari sesuatu!</p>';
   }
   ?>

   </div>

</section>
<!-- end of search subbagian -->

<!-- search catatan kinerja  -->
<section class="show-data">
    <h1 class="heading">Catatan Kinerja Harian Pegawai</h1>
</section>
<div class="table-container">

    <table class="table">
        <thead>
            <tr>
                <th>NIP</th>
                <th>Nama</th>
                <th>Tanggal</th>
                <th>Last Modified</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
        <?php
         if(isset($_POST['search']) or isset($_POST['search_btn'])){
            $search = $_POST['search'];
            $show_datas = $conn->prepare("SELECT * FROM `catatankinerja`, `pegawai` WHERE catatankinerja.nip = pegawai.nip && tanggal LIKE '%{$search}%'");
            $show_datas->execute();
            if($show_datas->rowCount() > 0){
                while($fetch_datas = $show_datas->fetch(PDO::FETCH_ASSOC)){ 
        ?>

            <tr>

            <td data-label="NIP"><?= $fetch_datas['nip']; ?></td>
            <td data-label="Nama"><?= $fetch_datas['nama']; ?></td>
            <td data-label="Tanggal"><?= $fetch_datas['tanggal']; ?></td>
            <td data-label="Last Modified"><?= $fetch_datas['waktu']; ?></td>
            <td data-label="Status"><span style="color:<?php if($fetch_datas['status'] == 'Terlambat'){ echo 'red'; }elseif($fetch_datas['status'] == 'Menunggu Validasi'){ echo 'blue'; }else{ echo '#0c972c'; }; ?>"><?= $fetch_datas['status']; ?></span></td>
            <td data-label="Aksi">
               <a href="cetak.php?print=<?= $fetch_datas['id_kinerja']; ?>" class="delete-btn"> <i class="fas fa-print"></i></a>    
               <a href="quick_view.php?pid=<?= $fetch_datas['id_kinerja']; ?>" class="option-btn"> <i class="fas fa-eye"></i></a>
            </td>
            </tr>

            <?php
                  }
               }else{
                  echo '<p class="empty">Catatan Kinerja tidak ditemukan!</p>';
               }
            }else{
               echo '<p class="empty">Silahkan cari sesuatu!</p>';
            }
            ?>
        </tbody>
    </table>
</div>
<!-- end of search catatan kinerja -->

<!-- footer section starts  -->
<?php include 'footer.php'; ?>
<!-- footer section ends -->

<!-- custom js file link  -->
<script src="../js/admin_script.js"></script>

</body>
</html>