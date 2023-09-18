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
    <title>Search Page</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

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

<!-- search catatan kinerja  -->
<div class="table-container">

<h1 class="title-black">Catatan kinerja harian pegawai</h1>

    <table class="table">
        <thead>
            <tr>
                <th>NIP</th>
                <th>Nama</th>
                <th>Tanggal</th>
                <th>Uraian Tugas</th>
                <th>Kuantitas</th>
                <th>Output</th>
                <th>Lampiran</th>
                <th>Last Modified</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
        <?php
         if(isset($_POST['search']) or isset($_POST['search_btn'])){
            $search = $_POST['search'];
            $show_datas = $conn->prepare("SELECT * FROM `catatankinerja`, `pegawai`, `akun` WHERE catatankinerja.nip = pegawai.nip && pegawai.nip = akun.nip &&  id_akun = ? && tanggal LIKE '%{$search}%'");
            $show_datas->execute([$user_id]);
            if($show_datas->rowCount() > 0){
                while($fetch_datas = $show_datas->fetch(PDO::FETCH_ASSOC)){ 
        ?>

            <tr>

            <td data-label="NIP"><?= $fetch_datas['nip']; ?></td>
            <td data-label="Nama"><?= $fetch_datas['nama']; ?></td>
            <td data-label="Tanggal"><?= $fetch_datas['tanggal']; ?></td>
            <td data-label="Uraian Tugas"><?= $fetch_datas['tugas']; ?></td>
            <td data-label="Kuantitas"><?= $fetch_datas['kuantitas']; ?></td>
            <td data-label="Output"><?= $fetch_datas['output']; ?></td>
            <td data-label="Lampiran"><img src="uploaded_lamp/<?= $fetch_datas['lampiran']; ?>" alt="lampiran"></td>
            <td data-label="Last Modified"><?= $fetch_datas['waktu']; ?></td>
            <td data-label="Status"> <span style="color:<?php if($fetch_datas['status'] == 'Terlambat'){ echo 'red'; }elseif($fetch_datas['status'] == 'Menunggu Validasi'){ echo 'blue'; }else{ echo '#0c972c'; }; ?>"><?= $fetch_datas['status']; ?></span></td>
            <td data-label="Aksi">
               <a href="laporan.php?delete=<?= $fetch_datas['id_kinerja']; ?>" class="delete-btn" onclick="return confirm('Anda yakin ingin menghapus data ini?');"> <i class="fas fa-trash"></i></a>
               <a href="update-laporan.php?update=<?= $fetch_datas['id_kinerja']; ?>" class="option-btn"> <i class="fas fa-edit"></i></a>
            </td>
            </tr>

            <?php
                  }
               }else{
                  echo '<p class="empty">Catatan Kinerja tidak ditemukan!</p>';
               }
            }else{
               echo '<p class="empty">Silahkan cari sesuatu!</p>';
            }
            ?>
        </tbody>
    </table>
</div>
<!-- end of search catatan kinerja -->

<!-- footer section starts  -->
<?php include 'footer.php'; ?>
<!-- footer section ends -->

<!-- custom js file link  -->
<script src="script.js"></script>

</body>
</html>