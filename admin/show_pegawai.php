<?php

@include '../config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:../login.php');
}

if(isset($_POST['submit'])){

   $nip = $_POST['nip'];
   $nip = filter_var($nip, FILTER_SANITIZE_STRING);
   $nama = $_POST['nama'];
   $nama = filter_var($nama, FILTER_SANITIZE_STRING);
   $gender = $_POST['gender'];
   $gender = filter_var($gender, FILTER_SANITIZE_STRING);
   $jabatan_peg = $_POST['jabatan_peg'];
   $jabatan_peg = filter_var($jabatan_peg, FILTER_SANITIZE_STRING);
   $pangkat_peg = $_POST['pangkat_peg'];
   $pangkat_peg = filter_var($pangkat_peg, FILTER_SANITIZE_STRING);
   $id_sub = $_POST['id_sub'];
   $id_sub = filter_var($id_sub, FILTER_SANITIZE_STRING);

   $select_pegawai = $conn->prepare("SELECT * FROM `pegawai` WHERE nip = ?");
   $select_pegawai->execute([$nip]);

   if($select_pegawai->rowCount() > 0){
      $message[] = 'Pegawai telah terdaftar!';
   }else{

      $insert_pegawai = $conn->prepare("INSERT INTO `pegawai`(nip, nama, gender, jabatan_peg, pangkat_peg, id_sub) VALUES(?,?,?,?,?,?)");
      $insert_pegawai->execute([$nip, $nama, $gender, $jabatan_peg, $pangkat_peg, $id_sub]);
      $message[] = 'Data pegawai berhasil ditambahkan!';

   }

};

if(isset($_GET['delete'])){

   $delete_id = $_GET['delete'];
   $select_delete_image = $conn->prepare("SELECT image FROM `akun`, `pegawai` WHERE akun.nip = pegawai.nip && id_akun = ?");
   $select_delete_image->execute([$delete_id]);
   $fetch_delete_image = $select_delete_image->fetch(PDO::FETCH_ASSOC);
   unlink('../uploaded_img/'.$fetch_delete_image['image']);
   $delete_pegawai = $conn->prepare("DELETE FROM `pegawai` WHERE nip = ?");
   $delete_pegawai->execute([$delete_id]);
   $delete_akun = $conn->prepare("DELETE FROM `akun` WHERE id_akun = ?");
   $delete_akun->execute([$delete_id]);
   header('location:pegawai.php');


}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pegawai</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include 'header.php'; ?>

<section class="show-data">

    <?php
      $show_id = $_GET['show'];
      $show_pegawai = $conn->prepare("SELECT * FROM `subbagian` WHERE id_sub = ? ");
      $show_pegawai->execute([$show_id]);
      if($show_pegawai->rowCount() > 0){
         while($fetch_pegawai = $show_pegawai->fetch(PDO::FETCH_ASSOC)){  
   ?>

   <h1 class="title">Daftar Pegawai ASN <?= $fetch_pegawai['nama_sub']; ?></h1>

   <?php
      }
   }
   ?>

   <div class="box-container">

   <?php
      $show_id = $_GET['show'];
      $show_pegawai = $conn->prepare("SELECT * FROM `pegawai` WHERE id_sub = ? ");
      $show_pegawai->execute([$show_id]);
      if($show_pegawai->rowCount() > 0){
         while($fetch_pegawai = $show_pegawai->fetch(PDO::FETCH_ASSOC)){  
   ?>
   <div class="box">
      <div class="nama"><?= $fetch_pegawai['nama']; ?></div>
      <div class="jabatan"><?= $fetch_pegawai['jabatan_peg']; ?></div>
      <div class="details">NIP. <?= $fetch_pegawai['nip']; ?></div>
      <div class="details">Golongan <?= $fetch_pegawai['pangkat_peg']; ?></div>
      <div class="flex-btn">
         <a href="update_pegawai.php?update=<?= $fetch_pegawai['nip']; ?>" class="option-btn">Perbarui</a>
         <a href="pegawai.php?delete=<?= $fetch_pegawai['nip']; ?>" class="delete-btn" onclick="return confirm('Hapus data ini?');">Hapus</a>
      </div>
      <a href="show_cttn_kinerja.php?show=<?= $fetch_pegawai['nip']; ?>" class="btn">Catatan Kinerja</a>
   </div>
   <?php
      }
   }else{
      echo '<p class="empty">Belum ada data pegawai!</p>';
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