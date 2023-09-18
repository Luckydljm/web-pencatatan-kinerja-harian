<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

if(isset($_POST['update_data'])){

    $pid = $_POST['pid'];
    $nip = $_POST['nip'];
    $tanggal = $_POST['tanggal'];
    $kuantitas = $_POST['kuantitas'];
    $kuantitas = filter_var($kuantitas, FILTER_SANITIZE_STRING);
    $output = $_POST['output'];
    $output = filter_var($output, FILTER_SANITIZE_STRING);
    $tugas = $_POST['tugas'];
    $tugas = filter_var($tugas, FILTER_SANITIZE_STRING);
    $waktu = $_POST['waktu'];
    $waktu = filter_var($waktu, FILTER_SANITIZE_STRING);
 
    $lampiran = $_FILES['lampiran']['name'];
    $lampiran = filter_var($lampiran, FILTER_SANITIZE_STRING);
    $lampiran_size = $_FILES['lampiran']['size'];
    $lampiran_tmp_name = $_FILES['lampiran']['tmp_name'];
    $lampiran_folder = 'uploaded_lamp/'.$lampiran;
    $old_lampiran = $_POST['old_lampiran'];

    $select_datas = $conn->prepare("SELECT * FROM `catatankinerja` WHERE tanggal = ?");
    $select_datas->execute([$tanggal]);

    $update_data = $conn->prepare("UPDATE `catatankinerja` SET nip = ?, tanggal = ?, kuantitas = ?, output = ?, tugas = ?, waktu = ? WHERE id_kinerja = ?");
    $update_data->execute([$nip, $tanggal, $kuantitas, $output, $tugas, $waktu, $pid]);
 
    $message[] = 'Catatan kinerja berhasil diupdate!';
    header('location:laporan.php');
 
    if(!empty($lampiran)){
       if($lampiran_size > 2000000){
          $message[] = 'Ukuran lampiran terlalu besar!';
       }else{
 
          $update_lampiran = $conn->prepare("UPDATE `catatankinerja` SET lampiran = ? WHERE id_kinerja = ?");
          $update_lampiran->execute([$lampiran, $pid]);
 
          if($update_lampiran){
             move_uploaded_file($lampiran_tmp_name, $lampiran_folder);
             unlink('uploaded_lamp/'.$old_lampiran);
             $message[] = 'Lampiran kinerja berhasil update!';
          }
       }
    }
 
 }
 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catatan Kinerja Harian</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">

    <style>
      body {
         background-image: url('images/Rectangle 2.png');
         background-size: cover;
      }
   </style>

</head>
<body>

<?php include 'header.php'; ?>

<section class="update-data">

   <h1 class="title-black">update data</h1>   

   <?php
      $update_id = $_GET['update'];
      $select_datas = $conn->prepare("SELECT * FROM `catatankinerja` WHERE id_kinerja = ?");
      $select_datas->execute([$update_id]);
      if($select_datas->rowCount() > 0){
         while($fetch_datas = $select_datas->fetch(PDO::FETCH_ASSOC)){ 
   ?>
   <form action="" method="post" enctype="multipart/form-data">
      <input type="hidden" name="old_lampiran" value="<?= $fetch_datas['lampiran']; ?>">
      <input type="hidden" name="pid" value="<?= $fetch_datas['id_kinerja']; ?>">
      <input type="hidden" name="nip" value="<?= $fetch_datas['nip']; ?>">
      <input type="hidden" min="0" name="tanggal" class="box" required placeholder="Pilih tanggal" value="<?= $fetch_datas['tanggal']; ?>">
      <img src="uploaded_lamp/<?= $fetch_datas['lampiran']; ?>" alt="">
      <input type="text" name="kuantitas" class="box" required placeholder="Masukkan kuantitas" value="<?= $fetch_datas['kuantitas']; ?>">
      <input type="text" name="output" class="box" required placeholder="Masukkan output" value="<?= $fetch_datas['output']; ?>">
      <textarea name="tugas" class="box" required placeholder="Masukkan uraian tugas" cols="30" rows="5"><?= $fetch_datas['tugas']; ?></textarea>
      <input type="file" name="lampiran" class="box" accept="image/jpg, image/jpeg, image/png">
      <input type="text" class="box" required name="waktu" value="<?php echo date('Y-m-d H:i:s')?>" hidden>
      <div class="flex-btn">
         <input type="submit" class="btn" value="update data" name="update_data">
         <a href="laporan.php" class="option-btn">Kembali</a>
      </div>
   </form>
   <?php
         }
      }else{
         echo '<p class="empty">Data tidak ditemukan!</p>';
      }
   ?>

</section>


<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>