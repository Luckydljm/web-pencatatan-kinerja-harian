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

   <section class="flex">

      <a href="home.php" class="logo"><img src="../images/logo-header.png" alt="logo"></a>

      <form action="search_page.php" method="post" class="search-form">
         <input type="text" name="search" placeholder="search here..." required maxlength="100">
         <button type="submit" class="fas fa-search" name="search_btn"></button>
      </form>

      <div class="icons">
         <div id="menu-btn" class="fas fa-bars"></div>
         <div id="search-btn" class="fas fa-search"></div>
         <div id="user-btn" class="fas fa-user"></div>
         <div id="toggle-btn" class="fas fa-sun"></div>
      </div>

      <div class="profile">
         <?php
            $select_profile = $conn->prepare("SELECT * FROM `akun`, `pegawai` WHERE akun.nip = pegawai.nip && id_akun = ?");
            $select_profile->execute([$admin_id]);
            if($select_profile->rowCount() > 0){
            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
         ?>
         <img src="../uploaded_img/<?= $fetch_profile['image']; ?>" alt="">
         <h3><?= $fetch_profile['nama']; ?></h3>
         <span>admin</span>
         <a href="profile.php" class="btn">view profile</a>
         <a href="logout.php" onclick="return confirm('logout from this website?');" class="delete-btn">logout</a>
         <?php
            }
         ?>
      </div>

   </section>

</header>

<!-- header section ends -->

<!-- side bar section starts  -->

<div class="side-bar">

   <div class="close-side-bar">
      <i class="fas fa-times"></i>
   </div>

   <div class="profile">
         <?php
            $select_profile = $conn->prepare("SELECT * FROM `akun`, `pegawai` WHERE akun.nip = pegawai.nip && id_akun = ?");
            $select_profile->execute([$admin_id]);
            if($select_profile->rowCount() > 0){
            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
         ?>
         <img src="../uploaded_img/<?= $fetch_profile['image']; ?>" alt="">
         <h3><?= $fetch_profile['nama']; ?></h3>
         <span>Admin</span>
         <a href="profile.php" class="btn">view profile</a>
         <?php
            }
         ?>
      </div>

   <nav class="navbar">
      <a href="home.php"><i class="fas fa-home"></i><span>home</span></a>
      <a href="pegawai.php"><i class="fas fa-user"></i><span>data pegawai</span></a>
      <a href="subbagian.php"><i class="fas fa-building"></i><span>data sub bagian</span></a>
      <a href="cttn_kinerja.php"><i class="fas fa-book"></i><span>catatan kinerja pegawai</span></a>
      <a href="about.php"><i class="fas fa-question-circle"></i><span>about us</span></a>
   </nav>

</div>

<!-- side bar section ends -->