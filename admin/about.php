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
    <title>Dashboard</title>

    <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>
<?php include 'header.php'; ?>

<!-- about section starts  -->

<section class="about">

   <div class="row">

      <div class="image">
         <img src="../images/logo-pu.png" alt="">
      </div>

      <div class="content">
         <h3>Dinas Pekerjaan Umum Bina Marga dan Tata Ruang</h3>
         <p>Dinas Pekerjaan Umum merupakan instansi yang melakukan aktivitas pembinaan jalan,pembangunan,dan jembatan. Dinas Pekerjaan Umum Bina Marga di atur dengan peraturan tingkat daerah provinsi Nomor 9 tahun 1995 tanggal 1 Maret 1995.Dengan adanya peraturan ini maka Bina Marga yang semula hanya sub bagian yang tunduk dan bertanggung jawab langsung kepada kepala dinas sekarang menjadi Dinas yang bertanggung jawab langsung kepada Gubernur dengan adanya pemekaran tersebut berarti ada kewenangan anggaran rutin dan pembangunan.</p>
         <a href="http://dpubmtr.sumselprov.go.id/" class="inline-btn">Hubungi Kami</a>
      </div>

   </div>

</section>

<!-- about section ends -->

<!-- footer section starts  -->
<?php include 'footer.php'; ?>
<!-- footer section ends -->

<!-- custom js file link  -->
<script src="../js/admin_script.js"></script>
</body>
</html>