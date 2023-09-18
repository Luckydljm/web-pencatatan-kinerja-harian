<?php

@include '../config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:../login.php');
}

if(isset($_POST['submit'])){

   $id_sub = $_POST['id_sub'];
   $id_sub = filter_var($id_sub, FILTER_SANITIZE_STRING);
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

   $select_subbagian = $conn->prepare("SELECT * FROM `subbagian` WHERE id_sub = ?");
   $select_subbagian->execute([$id_sub]);

   if($select_subbagian->rowCount() > 0){
      $message[] = 'subbagian telah terdaftar!';
   }else{

      $insert_subbagian = $conn->prepare("INSERT INTO `subbagian`(id_sub, nama_sub, kepala_sub, nip_kepala, jabatan, pangkat) VALUES(?,?,?,?,?,?)");
      $insert_subbagian->execute([$id_sub, $nama_sub, $kepala_sub, $nip_kepala, $jabatan, $pangkat]);
      $message[] = 'Data subbagian berhasil ditambahkan!';

   }

};

if(isset($_GET['delete'])){

   $delete_id = $_GET['delete'];
   $delete_subbagian = $conn->prepare("DELETE FROM `subbagian` WHERE id_sub = ?");
   $delete_subbagian->execute([$delete_id]);
   header('location:subbagian.php');


}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Sub Bagian</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include 'header.php'; ?>

<section class="form-container" style="min-height: calc(100vh - 19rem);">

   <form action="" method="post" enctype="multipart/form-data">
      <h3>Data Sub Bagian</h3>
      <div class="flex">
         <div class="col">
            <p>Nama Sub Bagian</p>
            <input type="text" name="nama_sub" placeholder="Masukkan nama sub bagian" class="box" required>
            <p>Kepala Sub Bagian</p>
            <input type="text" name="kepala_sub" placeholder="Masukkan nama kepala sub bagian" class="box" required>
            <p>NIP Kepala Sub Bagian</p>
            <input type="text" name="nip_kepala" placeholder="Masukkan NIP kepala sub bagian" class="box" required>
         </div>
         <div class="col">
            <p>Id Sub Bagian</p>
            <input type="text" name="id_sub" placeholder="Masukkan id sub bagian" class="box" required>
            <p>Jabatan</p>
            <input type="text" name="jabatan" placeholder="Masukkan jabatan" class="box" required>
            <p>Pangkat</p>
            <input type="text" name="pangkat" placeholder="Masukkan pangkat" class="box" required>
         </div>
      </div>
      <input type="submit" name="submit" value="Tambah Data" class="btn">
   </form>

</section>

<section class="show-data">

   <h1 class="title">Daftar Sub Bagian Pada Dinas PUBMTR</h1>

   <div class="box-container">

   <?php
      $show_subbagian = $conn->prepare("SELECT * FROM `subbagian`");
      $show_subbagian->execute();
      if($show_subbagian->rowCount() > 0){
         while($fetch_subbagian = $show_subbagian->fetch(PDO::FETCH_ASSOC)){  
   ?>
   <div class="box">
      <div class="jabatan"><?= $fetch_subbagian['id_sub']; ?></div>
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
      echo '<p class="empty">Belum ada data sub bagian!</p>';
   }
   ?>

   </div>

</section>


<!-- footer section starts  -->
<?php include 'footer.php'; ?>
<!-- footer section ends -->

<!-- custom js file link  -->
<script src="../js/admin_script.js"></script>

</body>
</html>