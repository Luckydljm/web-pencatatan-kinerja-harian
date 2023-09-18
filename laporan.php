<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

if(isset($_GET['delete'])){

    $delete_id = $_GET['delete'];
    $select_delete_lampiran = $conn->prepare("SELECT lampiran FROM `catatankinerja` WHERE id_kinerja = ?");
    $select_delete_lampiran->execute([$delete_id]);
    $fetch_delete_lampiran = $select_delete_lampiran->fetch(PDO::FETCH_ASSOC);
    unlink('uploaded_lamp/'.$fetch_delete_lampiran['lampiran']);
    $delete_laporan = $conn->prepare("DELETE FROM `catatankinerja` WHERE id_kinerja = ?");
    $delete_laporan->execute([$delete_id]);
    header('location:laporan.php');
 
 
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

    .btn-add {
        display: block;
        width: 20%;
        margin-bottom: 1rem;
        margin-top: 1rem;
        border-radius: 0.5rem;
        color: var(--white);
        background-color: var(--green);
        font-size: 2rem;
        padding: 1.3rem 3rem;
        text-transform: capitalize;
        cursor: pointer;
        text-align: center;
    }

    @media (max-width: 768px) {
        .btn-add {
            width: 50%;
        }
    }
    </style>

</head>

<body>

    <?php include 'header.php'; ?>

    <div class="table-container">
        <h1 class="title-black">Catatan kinerja harian pegawai</h1>

        <div class="flex">
            <a href="add_laporan.php" class="btn-add">Tambah Data</a>
            <form action="search_page.php" method="post" class="search-form">
                <input type="text" name="search" placeholder="search here..." required maxlength="100">
                <button type="submit" class="fas fa-search" name="search_btn"></button>
            </form>
        </div>

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
            $show_datas = $conn->prepare("SELECT * FROM `catatankinerja`, `pegawai`, `akun` WHERE catatankinerja.nip = pegawai.nip && pegawai.nip = akun.nip &&  id_akun = ?");
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
                    <td data-label="Lampiran"><img src="uploaded_lamp/<?= $fetch_datas['lampiran']; ?>" alt="lampiran">
                    </td>
                    <td data-label="Last Modified"><?= $fetch_datas['waktu']; ?></td>
                    <td data-label="Status"> <span
                            style="color:<?php if($fetch_datas['status'] == 'Terlambat'){ echo 'red'; }elseif($fetch_datas['status'] == 'Menunggu Validasi'){ echo 'blue'; }elseif($fetch_datas['status'] == 'Tidak Valid'){ echo 'orange'; }else{ echo '#0c972c'; }; ?>"><?= $fetch_datas['status']; ?></span>
                    </td>
                    <td data-label="Aksi">
                        <a href="laporan.php?delete=<?= $fetch_datas['id_kinerja']; ?>" class="delete-btn"
                            onclick="return confirm('Anda yakin ingin menghapus data ini?');"> <i
                                class="fas fa-trash"></i></a>
                        <a href="update-laporan.php?update=<?= $fetch_datas['id_kinerja']; ?>" class="option-btn"> <i
                                class="fas fa-edit"></i></a>
                    </td>
                </tr>

                <?php
              } 
            }
        ?>
            </tbody>
        </table>
    </div>

    <?php include 'footer.php'; ?>

    <!-- custom js file link  -->
    <script src="js/script.js"></script>

</body>

</html>