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
    <title>Admin Dashboard</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include 'header.php'; ?>

<section class="dashboard">

   <h1 class="heading">dashboard</h1>

   <div class="box-container">

      <div class="box">
      <h3>Welcome</h3>
      <p><?= $fetch_profile['nama']; ?></p>
      <a href="profile.php" class="btn">Lihat Profile</a>
      </div>

      <div class="box">
      <?php
         $select_pegawai = $conn->prepare("SELECT * FROM `pegawai`");
         $select_pegawai->execute();
         $number_of_pegawai = $select_pegawai->rowCount();
      ?>
      <h3><?= $number_of_pegawai; ?></h3>
      <p>Jumlah Pegawai ASN</p>
      <a href="pegawai.php" class="btn">Lihat pegawai</a>
      </div>

      <div class="box">
      <?php
         $select_subbagian = $conn->prepare("SELECT * FROM `subbagian`");
         $select_subbagian->execute();
         $number_of_subbagian = $select_subbagian->rowCount();
      ?>
      <h3><?= $number_of_subbagian; ?></h3>
      <p>Jumlah Sub Bagian</p>
      <a href="subbagian.php" class="btn">Lihat sub bagian</a>
      </div>

      <div class="box">
      <?php
         $select_catatan_kinerja = $conn->prepare("SELECT * FROM `catatankinerja`");
         $select_catatan_kinerja->execute();
         $number_of_catatan_kinerja = $select_catatan_kinerja->rowCount();
      ?>
      <h3><?= $number_of_catatan_kinerja; ?></h3>
      <p>Jumlah Catatan Kinerja</p>
      <a href="cttn_kinerja.php" class="btn">Lihat laporan</a>
      </div>

      <div class="box">
      <?php
         $select_terlambat = $conn->prepare("SELECT * FROM `catatankinerja` WHERE status = 'Terlambat'");
         $select_terlambat->execute();
         $number_of_terlambat = $select_terlambat->rowCount();
      ?>
      <h3><?= $number_of_terlambat; ?></h3>
      <p>Catatan Kinerja Yang Terlambat</p>
      <a href="cttn_kinerja.php" class="btn">Lihat laporan</a>
      </div>

      <div class="box">
      <?php
         $select_acc = $conn->prepare("SELECT * FROM `catatankinerja` WHERE status = 'Selesai'");
         $select_acc->execute();
         $number_of_acc = $select_acc->rowCount();
      ?>
      <h3><?= $number_of_acc; ?></h3>
      <p>Catatan Kinerja Yang Selesai</p>
      <a href="cttn_kinerja.php" class="btn">Lihat laporan</a>
      </div>

   </div>

</section>

<!-- footer section starts  -->
<?php include 'footer.php'; ?>
<!-- footer section ends -->

<!-- custom js file link  -->
<script src="../js/admin_script.js"></script>

</body>
</html>