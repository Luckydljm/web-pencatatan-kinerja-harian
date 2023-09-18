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
    <title>Catatn Kinerja Harian</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include 'header.php'; ?>

<section class="quick-view">

   <h1 class="heading">Detail Catatan Kinerja Pegawai</h1>

   <?php
     $pid = $_GET['pid'];
     $select_datas = $conn->prepare("SELECT * FROM `catatankinerja`, `pegawai` WHERE catatankinerja.nip = pegawai.nip && id_kinerja = ?"); 
     $select_datas->execute([$pid]);
     if($select_datas->rowCount() > 0){
      while($fetch_data = $select_datas->fetch(PDO::FETCH_ASSOC)){
   ?>
   <form action="" method="post" class="box">
      <div class="row">
         <div class="image-container">
            <div class="main-image">
               <img src="../uploaded_lamp/<?= $fetch_data['lampiran']; ?>" alt="">
            </div>
         </div>
         <div class="content">
            <div class="name"><?= $fetch_data['nama']; ?></div>
            <div class="nip">NIP.<?= $fetch_data['nip']; ?></div>
            <div class="flex">
               <div class="content-title">Tanggal Upload :</div>
               <div class="content-item"><?= $fetch_data['tanggal']; ?></div>
            </div>
            <div class="flex">
               <div class="content-title">Kuantitas :</div>
               <div class="content-item"><?= $fetch_data['kuantitas']; ?></div>
            </div>
            <div class="flex">
               <div class="content-title">Output :</div>
               <div class="content-item"><?= $fetch_data['output']; ?></div>
            </div>
            <div class="flex">
               <div class="content-title">Waktu :</div>
               <div class="content-item"><?= $fetch_data['waktu']; ?></div>
            </div>
            <div class="flex">
               <div class="content-title">Status :</div>
               <div class="content-item"><span style="color:<?php if($fetch_data['status'] == 'Terlambat'){ echo 'red'; }elseif($fetch_data['status'] == 'Menunggu Validasi'){ echo 'blue'; }elseif($fetch_datas['status'] == 'Tidak Valid'){ echo 'orange'; }else{ echo '#0c972c'; }; ?>"><?= $fetch_data['status']; ?></span></div>
            </div>

            <div class="content-title">Uraian Tugas :</div>
            <div class="details"><?= $fetch_data['tugas']; ?></div>
            <div class="flex-btn">
                <a href="cetak.php?print=<?= $fetch_data['id_kinerja']; ?>" class="delete-btn">Cetak</a>
               <a href="cttn_kinerja.php" class="option-btn">Kembali</a>
            </div>
         </div>
      </div>
   </form>
   <?php
      }
   }else{
      echo '<p class="empty">Belum ada data yang ditambahkan!</p>';
   }
   ?>

</section>

<!-- footer section starts  -->
<?php include 'footer.php'; ?>
<!-- footer section ends -->

<!-- custom js file link  -->
<script src="../js/admin_script.js"></script>

</body>
</html>