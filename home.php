<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">

    <style>
      body {
         background-image: url('images/ampera.jpg');
         background-size: cover;
         background-position: center;
      }
   </style>

</head>
<body>
<?php include 'header.php'; ?>

<section class="home">

    <img src="images/image 3.png" alt="foto-pemda">
    <div class="content">
        <h1>bekerja keras <br>bergerak cepat <br>bertindak tepat</h1>
        <a href="about.php" class="option-btn">tentang kami</a>
    </div>

</section>

<section class="home-category">

   <h1 class="title">Catatan kinerja harian pegawai</h1>

   <div class="box-container">

      <div class="box">
         <h3>catatan kinerja</h3>
         <p>Catatan kinerja harian pegawai merupakan catatan data hasil kerja pegawai dalam melaksanakan pekerjaan yang menghasilkan output dari pelaksanaan suatu kegiatan atau pekerjaan baik secara kuantitas maupun kualitas yang dicapai seorang pegawai dalam melaksanakan tugas sesuai dengan tanggung jawab yang diberikan serta dapat diukur dengan standar yang telah ditetapkan selama periode tertentu. </p>
         <a href="laporan.php" class="option-btn">Tambah Catatan</a>
      </div>

   </div>

</section>

<?php include 'footer.php'; ?>

<script src="js/script.js"></script>
</body>
</html>