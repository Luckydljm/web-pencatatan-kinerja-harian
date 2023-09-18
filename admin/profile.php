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
    <title>Profile</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include 'header.php'; ?>

<section class="profile">

   <h1 class="heading">profile details</h1>

   <div class="details">

      <div class="user">
         <img src="../uploaded_img/<?= $fetch_profile['image']; ?>" alt="">
         <h3><?= $fetch_profile['nama']; ?></h3>
         <p>(<?= $fetch_profile['nip']; ?>)</p>
         <p>Admin</p>
         <a href="update.php" class="inline-btn">update profile</a>
      </div>

   </div>

</section>

<!-- profile section ends -->

<!-- footer section starts  -->
<?php include 'footer.php'; ?>
<!-- footer section ends -->

<!-- custom js file link  -->
<script src="../js/admin_script.js"></script>
    
</body>
</html>