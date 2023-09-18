<header class="header">

   <section class="flex">

      <a href="" class="logo-cetak"><img src="../images/logo-dinas.png" alt="logo"></a>

      <form action="" method="post" class="kop">
         <h1>PEMERINTAH PROVISI SUMATERA SELATAN</h1>
         <h1>DINAS PEKERJAAN UMUM BINA MARGA DAN TATA RUANG</h1>
         <p>Jalan Ade Irma Nasution No. 10, Telp. (0711) 313431 - 347855, FAX. (0711) 317793</p>
         <h1>PALEMBANG</h1>
      </form>

      <a href="" class="logo-cetak"><img src="../images/logo-pu.png" alt="logo"></a>

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
         <span>(<?= $fetch_profile['nip']; ?>)</span> <br>
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