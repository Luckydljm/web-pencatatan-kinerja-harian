<?php

@include '../config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:../login.php');
}

if(isset($_POST['update_data'])){

    $pid = $_POST['pid'];
    $nama_sub = $_POST['nama_sub'];
    $nama_sub = filter_var($nama_sub, FILTER_SANITIZE_STRING);
    $kepala_sub = $_POST['kepala_sub'];
    $kepala_sub = filter_var($kepala_sub, FILTER_SANITIZE_STRING);
    $nip_kepala = $_POST['nip_kepala'];
    $nip_kepala = filter_var($nip_kepala, FILTER_SANITIZE_STRING);
    $jabatan = $_POST['jabatan'];
    $jabatan = filter_var($jabatan, FILTER_SANITIZE_STRING);
    $pangkat = $_POST['pangkat'];
    $pangkat = filter_var($pangkat, FILTER_SANITIZE_STRING);
 
    $update_subbagian = $conn->prepare("UPDATE `subbagian` SET nama_sub = ?, kepala_sub = ?, nip_kepala = ?, jabatan = ?, pangkat = ? WHERE id_sub = ?");
    $update_subbagian->execute([$nama_sub, $kepala_sub, $nip_kepala, $jabatan, $pangkat, $pid]);
    
    $message[] = 'subbagian berhasil diperbarui!';
    header('location:subbagian.php'); 
 
 }
 
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Data</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include 'header.php'; ?>

<section class="update-data">

   <h1 class="title">Perbarui Sub Bagian</h1>   

   <?php
      $update_id = $_GET['update'];
      $select_subbagian = $conn->prepare("SELECT * FROM `subbagian` WHERE id_sub = ?");
      $select_subbagian->execute([$update_id]);
      if($select_subbagian->rowCount() > 0){
         while($fetch_subbagian = $select_subbagian->fetch(PDO::FETCH_ASSOC)){ 
   ?>
   <form action="" method="post" enctype="multipart/form-data">
      <input type="hidden" name="pid" value="<?= $fetch_subbagian['id_sub']; ?>">
      <input type="text" name="nama_sub" placeholder="Masukkan nama sub bagian" required class="box" value="<?= $fetch_subbagian['nama_sub']; ?>">
      <input type="text" name="kepala_sub" placeholder="Masukkan kepala sub bagian" required class="box" value="<?= $fetch_subbagian['kepala_sub']; ?>">
      <input type="text" name="nip_kepala" placeholder="Masukkan NIP kepala sub bagian" required class="box" value="<?= $fetch_subbagian['nip_kepala']; ?>">
      <input type="text" name="jabatan" placeholder="Masukkan jabatan" required class="box" value="<?= $fetch_subbagian['jabatan']; ?>">
      <input type="text" name="pangkat" placeholder="Masukkan pangkat" required class="box" value="<?= $fetch_subbagian['pangkat']; ?>">
      
         <input type="submit" class="btn" value="update data" name="update_data">
         <a href="subbagian.php" class="option-btn">Kembali</a>
      </div>
   </form>
   <?php
         }
      }else{
         echo '<p class="empty"Sub Bagian tidak ditemukan!</p>';
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