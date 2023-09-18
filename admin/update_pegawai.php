<?php

@include '../config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:../login.php');
}

if(isset($_POST['update_data'])){

    $pid = $_POST['pid'];
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
 
    $update_pegawai = $conn->prepare("UPDATE `pegawai` SET nama = ?, gender = ?, jabatan_peg = ?, pangkat_peg = ?, id_sub = ? WHERE nip = ?");
    $update_pegawai->execute([$nama, $gender, $jabatan_peg, $pangkat_peg, $id_sub, $pid]);
    
    $message[] = 'Data pegawai berhasil diperbarui!';
    header('location:pegawai.php'); 
 
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

   <h1 class="title">Perbarui Data Pegawai</h1>   

   <?php
      $update_id = $_GET['update'];
      $select_pegawai = $conn->prepare("SELECT * FROM `pegawai`, `subbagian` WHERE pegawai.id_sub = subbagian.id_sub && nip = ?");
      $select_pegawai->execute([$update_id]);
      if($select_pegawai->rowCount() > 0){
         while($fetch_pegawai = $select_pegawai->fetch(PDO::FETCH_ASSOC)){ 
   ?>
   <form action="" method="post" enctype="multipart/form-data">
      <input type="hidden" name="pid" value="<?= $fetch_pegawai['nip']; ?>">
      <input type="text" name="nama" placeholder="Masukkan nama sub bagian" required class="box" value="<?= $fetch_pegawai['nama']; ?>">
      <select name="gender" class="box" required>
        <option selected><?= $fetch_pegawai['gender']; ?></option>
        <option value="Pria">Pria</option>
        <option value="Wanita">Wanita</option>
      </select>
      <input type="text" name="jabatan_peg" placeholder="Masukkan jabatan" required class="box" value="<?= $fetch_pegawai['jabatan_peg']; ?>">
      <input type="text" name="pangkat_peg" placeholder="Masukkan pangkat" required class="box" value="<?= $fetch_pegawai['pangkat_peg']; ?>">
      <select name="id_sub" class="box" required>
         <option value="<?= $fetch_pegawai['id_sub']; ?>"selected disabled><?= $fetch_pegawai['nama_sub']; ?></option>
            <?php
               $show_subbagian = $conn->prepare("SELECT * FROM `subbagian`");
               $show_subbagian->execute();
               if($show_subbagian->rowCount() > 0){
                  while($fetch_subbagian = $show_subbagian->fetch(PDO::FETCH_ASSOC)){  
            ?>
            <option value="<?= $fetch_subbagian['id_sub']; ?>"><?= $fetch_subbagian['nama_sub']; ?></option>
            <?php
            }
            }
            ?>
      </select>

      
         <input type="submit" class="btn" value="update data" name="update_data">
         <a href="pegawai.php" class="option-btn">Kembali</a>
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