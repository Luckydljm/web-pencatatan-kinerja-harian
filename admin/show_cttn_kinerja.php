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
    <title>Catatan Kinerja Harian</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="../css/admin_style.css">

    <style>
      .btn-add {
         display: block;
         width: 10%;
         margin-bottom: 1rem;
         margin-top: 1rem;
         border-radius: 0.5rem;
         color: var(--black);
         background-color: var(--orange);
         font-size: 1.5rem;
         padding: 1rem;
         text-transform: capitalize;
         cursor: pointer;
         text-align: center;
      }
   </style>

</head>
<body>

<?php include 'header.php'; ?>

<div class="table-container">
    <h1 class="heading">Catatan Kinerja Harian Pegawai</h1>

    <table class="table-identity">
        <thead>
        <?php
            $show_id = $_GET['show'];
            $show_identity = $conn->prepare("SELECT * FROM `pegawai` WHERE nip = ?");
            $show_identity->execute([$show_id]);
            if($show_identity->rowCount() > 0){
                while($fetch_identity = $show_identity->fetch(PDO::FETCH_ASSOC)){ 
        ?>
        <tr>
            <th><span class="nama"><?= $fetch_identity['nama']; ?></span></th>
        </tr>
        <?php
              } 
            }
        ?>
        </thead>
    </table>

    <table class="table">
        <thead>
            <tr>
                <th>NIP</th>
                <th>Tanggal</th>
                <th>Last Modified</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
        <?php
            $show_id = $_GET['show'];
            $show_datas = $conn->prepare("SELECT * FROM `catatankinerja` WHERE nip = ?");
            $show_datas->execute([$show_id]);
            if($show_datas->rowCount() > 0){
                while($fetch_datas = $show_datas->fetch(PDO::FETCH_ASSOC)){ 
        ?>

            <tr>

            <td data-label="NIP"><?= $fetch_datas['nip']; ?></td>
            <td data-label="Tanggal"><?= $fetch_datas['tanggal']; ?></td>
            <td data-label="Last Modified"><?= $fetch_datas['waktu']; ?></td>
            <td data-label="Status"> <span style="color:<?php if($fetch_datas['status'] == 'Terlambat'){ echo 'red'; }elseif($fetch_datas['status'] == 'Menunggu Validasi'){ echo 'blue'; }elseif($fetch_datas['status'] == 'Tidak Valid'){ echo 'red'; }else{ echo '#0c972c'; }; ?>"><?= $fetch_datas['status']; ?></span></td>
            <td data-label="Aksi">
               <a href="cetak.php?print=<?= $fetch_datas['id_kinerja']; ?>" class="delete-btn"> <i class="fas fa-print"></i></a>    
               <a href="quick_view.php?pid=<?= $fetch_datas['id_kinerja']; ?>" class="option-btn"> <i class="fas fa-eye"></i></a>
            </td>
            </tr>

        <?php
              } 
            }
        ?>
        </tbody>
    </table>
</div>

<!-- footer section starts  -->
<?php include 'footer.php'; ?>
<!-- footer section ends -->

<!-- custom js file link  -->
<script src="../js/admin_script.js"></script>

</body>
</html>