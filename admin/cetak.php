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
    <title>Catatn Kinerja Harian</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include 'header_cetak.php'; ?>

<div class="table-container">

<h1 class="title">Catatan kinerja harian pegawai</h1>

    <table class="table-identity">
        <thead>
        <?php
            $print_id = $_GET['print'];
            $select_identity = $conn->prepare("SELECT * FROM `pegawai`, `subbagian`, `catatankinerja` WHERE pegawai.id_sub = subbagian.id_sub && pegawai.nip = catatankinerja.nip && id_kinerja = ?");
            $select_identity->execute([$print_id]);
            if($select_identity->rowCount() > 0){
                while($fetch_identity = $select_identity->fetch(PDO::FETCH_ASSOC)){ 
        ?>
        <tr>
            <th>NAMA</th>
            <th>:</th>
            <th><?= $fetch_identity['nama']; ?></th>
        </tr>

        <tr>
            <th>NIP</th>
            <th>:</th>
            <th><?= $fetch_identity['nip']; ?></th>
        </tr>

        <tr>
            <th>PANGKAT/GOL</th>
            <th>:</th>
            <th><?= $fetch_identity['pangkat_peg']; ?></th>
        </tr>

        <tr>
            <th>JABATAN</th>
            <th>:</th>
            <th><?= $fetch_identity['jabatan_peg']; ?></th>
        </tr>

        <tr>
            <th>BIDANG TUGAS</th>
            <th>:</th>
            <th><?= $fetch_identity['nama_sub']; ?></th>
        </tr>

        <tr>
            <th>ATASAN LANGSUNG</th>
            <th>:</th>
            <th><?= $fetch_identity['jabatan']; ?></th>
        </tr>

        <tr>
            <th>TANGGAL</th>
            <th>:</th>
            <th><?= $fetch_identity['tanggal']; ?></th>
        </tr>

        <tr>
            <th>TANGGAL UPLOAD</th>
            <th>:</th>
            <th><?= $fetch_identity['waktu']; ?></th>
        </tr>

        <tr>
            <th>STATUS</th>
            <th>:</th>
            <th><?= $fetch_identity['status']; ?></th>
        </tr>

        <tr>
            <th></th>
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
            <th>Uraian Kegiatan</th>
            <th width="5%">Kuantitas</th>
            <th>Output</th>
            <th>Keterangan</th>
        </tr>
        </thead>

        <tbody>
        <?php
            $print_id = $_GET['print'];
            $select_report = $conn->prepare("SELECT * FROM `catatankinerja` WHERE id_kinerja = ?");
            $select_report->execute([$print_id]);
            if($select_report->rowCount() > 0){
                while($fetch_report = $select_report->fetch(PDO::FETCH_ASSOC)){ 
        ?>

        <tr>
            <td data-label="Uraian Kegiatan"><?= $fetch_report['tugas']; ?></td>
            <td data-label="Kuantitas"><?= $fetch_report['kuantitas']; ?></td>
            <td data-label="Output"><?= $fetch_report['output']; ?></td>
            <td data-label="Keterangan"><img src="../uploaded_lamp/<?= $fetch_report['lampiran']; ?>" alt="lampiran"></td>
        </tr>

        <?php
              } 
            }
        ?>
        </tbody>
    </table>
</div>

<section class="flex-ttd">
    <?php
        $print_id = $_GET['print'];
        $select_identity = $conn->prepare("SELECT * FROM `pegawai`, `subbagian`, `catatankinerja` WHERE pegawai.id_sub = subbagian.id_sub && pegawai.nip = catatankinerja.nip && id_kinerja = ?");
        $select_identity->execute([$print_id]);
        if($select_identity->rowCount() > 0){
            while($fetch_identity = $select_identity->fetch(PDO::FETCH_ASSOC)){ 
    ?>
    <form action="" method="post" class="kop">
        <h3><?= $fetch_identity['jabatan']; ?> DINAS PEKERJAAN UMUM</h3>
        <h3>BINA MARGA DAN TATA RUANG</h3>
        <h3>PROVINSI SUMATERA SEATAN</h3>
        <h3 class="nama-kepala"><?= $fetch_identity['kepala_sub']; ?></h3>
        <p><?= $fetch_identity['pangkat']; ?></p>
        <p>NIP.<?= $fetch_identity['nip_kepala']; ?></p>
    </form>
    <?php
        } 
        }
    ?>
</section>

    <script>
        window.print();
    </script>

<!-- footer section starts  -->
<?php include 'footer.php'; ?>
<!-- footer section ends -->

<!-- custom js file link  -->
<script src="../js/admin_script.js"></script>

</body>
</html>