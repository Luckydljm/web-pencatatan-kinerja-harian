<?php

@include 'config.php';

session_start();

date_default_timezone_set("ASIA/JAKARTA");

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

if(isset($_POST['add_data'])){

    $select_user = $conn->prepare("SELECT * FROM `akun` WHERE id_akun = ?");
    $select_user->execute([$user_id]);
    $fetch_user = $select_user->fetch(PDO::FETCH_ASSOC);
 
    $prev_nip = $fetch_user['nip'];

    $nip = $_POST['nip'];
    $nip = filter_var($nip, FILTER_SANITIZE_STRING);
    $tanggal = $_POST['tanggal'];
    $tanggal = filter_var($tanggal, FILTER_SANITIZE_STRING);
    $tugas = $_POST['tugas'];
    $tugas = filter_var($tugas, FILTER_SANITIZE_STRING);
    $kuantitas = $_POST['kuantitas'];
    $kuantitas = filter_var($kuantitas, FILTER_SANITIZE_STRING);
    $output = $_POST['output'];
    $output = filter_var($output, FILTER_SANITIZE_STRING);
    $waktu = $_POST['waktu'];
    $waktu = filter_var($waktu, FILTER_SANITIZE_STRING);
 
    $lampiran = $_FILES['lampiran']['name'];
    $lampiran = filter_var($lampiran, FILTER_SANITIZE_STRING);
    $lampiran_size = $_FILES['lampiran']['size'];
    $lampiran_tmp_name = $_FILES['lampiran']['tmp_name'];
    $lampiran_folder = 'uploaded_lamp/'.$lampiran;

    if($nip != $prev_nip){
        $message[] = 'NIP yang anda masukkan bukan milik anda!';
    }else{
        $select_datas = $conn->prepare("SELECT * FROM `catatankinerja` WHERE tanggal = ?");
        $select_datas->execute([$tanggal]);

            $insert_datas = $conn->prepare("INSERT INTO `catatankinerja`(nip, tanggal, tugas, kuantitas, output, waktu, lampiran) VALUES(?,?,?,?,?,?,?)");
            $insert_datas->execute([$nip, $tanggal, $tugas, $kuantitas, $output, $waktu, $lampiran]);
        
            if($insert_datas){
                if($lampiran_size > 2000000){
                    $message[] = 'Ukuran lampiran terlalu besar!';
                }else{
                    move_uploaded_file($lampiran_tmp_name, $lampiran_folder);
                    $message[] = 'Catatan kinerja berhasil upload!';
                    header('location:laporan.php');
                }
        
            }
    
        }
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
   </style>

</head>
<body>

<?php include 'header.php'; ?>

<section class="add-data">

   <h1 class="title-black">Tambah catatan kinerja harian</h1>

   <form action="" method="POST" enctype="multipart/form-data">
      <div class="flex">
         <div class="inputBox">
         <input type="text" name="nip" class="box" required placeholder="Masukkan NIP">
         <input type="date" min="0" name="tanggal" class="box" required placeholder="Pilih tanggal">
         </div>
         <div class="inputBox">
         <input type="text" name="kuantitas" class="box" required placeholder="Masukkan kuantitas">
         <input type="text" name="output" class="box" required placeholder="Masukkan output">
         </div>
         <input type="file" name="lampiran" required class="box" accept="image/jpg, image/jpeg, image/png">
         <input type="text" class="box" required name="waktu" value="<?php echo date('Y-m-d H:i:s')?>" hidden>
      </div>
      <textarea name="tugas" class="box" required placeholder="Masukkan uraian tugas" cols="30" rows="10"></textarea>
      <input type="submit" class="btn" value="tambah catatan" name="add_data">
   </form>

</section>

<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>