<?php

@include '../config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:../login.php');
}

if(isset($_POST['update_data'])){

    $id_kinerja = $_POST['id_kinerja'];
    $update_status = $_POST['update_status'];
    $update_status = filter_var($update_status, FILTER_SANITIZE_STRING);
    $update_data_status = $conn->prepare("UPDATE `catatankinerja` SET status = ? WHERE id_kinerja = ?");
    $update_data_status->execute([$update_status, $id_kinerja]);
    $message[] = 'Status berhasil di update!';
 
 };

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catatn Kinerja Harian</title>

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

    <table class="table">
        <thead>
            <tr>
                <th>NIP</th>
                <th>Nama</th>
                <th>Tanggal</th>
                <th>Last Modified</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
        <?php
            $show_datas = $conn->prepare("SELECT * FROM `catatankinerja`, `pegawai` WHERE catatankinerja.nip = pegawai.nip");
            $show_datas->execute();
            if($show_datas->rowCount() > 0){
                while($fetch_datas = $show_datas->fetch(PDO::FETCH_ASSOC)){ 
        ?>

            <tr>

            <td data-label="NIP"><?= $fetch_datas['nip']; ?></td>
            <td data-label="Nama"><?= $fetch_datas['nama']; ?></td>
            <td data-label="Tanggal"><?= $fetch_datas['tanggal']; ?></td>
            <td data-label="Last Modified"><?= $fetch_datas['waktu']; ?></td>
            <td data-label="Status" style="color: #8e44ad">
                <form action="" method="POST">
                    <input type="hidden" name="id_kinerja" value="<?= $fetch_datas['id_kinerja']; ?>">
                    <select name="update_status" class="drop-down">
                        <option value="" selected disabled><?= $fetch_datas['status']; ?></option>
                        <option value="Terlambat">Terlambat</option>
                        <option value="Selesai">Selesai</option>
                        <option value="Tidak Valid">Tidak Valid</option>
                    </select>
                    <div class="flex-btn">
                        <input type="submit" name="update_data" class="option-btn" value="update">
                    </div>
                </form>
            </td>
            <td data-label="Aksi">
               <a href="cetak.php?print=<?= $fetch_datas['id_kinerja']; ?>" class="delete-btn"> <i class="fas fa-print"></i></a>    
               <a href="quick_view.php?pid=<?= $fetch_datas['id_kinerja']; ?>" class="btn"> <i class="fas fa-eye"></i></a>
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