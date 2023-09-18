<?php

if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}

?>

<header class="header">

   <div class="flex">

      <a href="home.php" class="logo"><img src="images/logo-header.png" alt="logo"></a>

      <nav class="navbar">
         <a href="home.php">home</a>
         <a href="laporan.php">laporan</a>
         <a href="about.php">about</a>
      </nav>

      <div class="icons">
         <div id="menu-btn" class="fas fa-bars"></div>
         <div id="user-btn" class="fas fa-user"></div>

      <div class="profile">
         <?php
            $select_profile = $conn->prepare("SELECT * FROM `akun`, `pegawai` WHERE akun.nip = pegawai.nip && id_akun = ?");
            $select_profile->execute([$user_id]);
            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
         ?>
         <img src="uploaded_img/<?= $fetch_profile['image']; ?>" alt="">
         <p><?= $fetch_profile['nama']; ?></p>
         <a href="user_profile_update.php" class="btn">update profile</a>
         <a href="logout.php" class="delete-btn">logout</a>
      </div>

   </div>

</header>