<?php

include 'config.php';

if(isset($_POST['submit'])){

   $nip = $_POST['nip'];
   $nip = filter_var($nip, FILTER_SANITIZE_STRING);
   $password = md5($_POST['password']);
   $password = filter_var($password, FILTER_SANITIZE_STRING);
   $cpassword = md5($_POST['cpassword']);
   $cpassword = filter_var($cpassword, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $no_hp = $_POST['no_hp'];
   $no_hp = filter_var($no_hp, FILTER_SANITIZE_STRING);

   $image = $_FILES['image']['name'];
   $image = filter_var($image, FILTER_SANITIZE_STRING);
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = 'uploaded_img/'.$image;

   $select = $conn->prepare("SELECT * FROM `pegawai` WHERE nip = ?");
   $select->execute([$nip]);

   if($select->rowCount() > 0){
      $select_nip = $conn->prepare("SELECT * FROM `akun` WHERE nip = ?");
      $select_nip->execute([$nip]);  

      if($select_nip->rowCount() > 0){
         $message[] = 'Akun dengan NIP tersebut telah terdaftar!';
      }else{
         if($password != $cpassword){
            $message[] = 'Konfirmasi password tidak cocok!';
         }else{
            $insert = $conn->prepare("INSERT INTO `akun`(nip, password, email, no_hp, image) VALUES(?,?,?,?,?)");
            $insert->execute([$nip, $password, $email, $no_hp, $image]);
   
            if($insert){
               if($image_size > 2000000){
                  $message[] = 'Ukuran gambar terlalu besar!';
               }else{
                  move_uploaded_file($image_tmp_name, $image_folder);
                  $message[] = 'Registrasi berhasil!';
               }
            }
         }
      }
   }else{
      $message[] = 'NIP anda tidak terdaftar pada Dinas PUBMTR!';
   }

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi</title>

    <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/components.css">
</head>
<body>

   <style>
      body {
         background-image: url('images/bg-login.jpg');
         background-size: cover;

      }
   </style>

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

<div class="container">
   <div class="logo-login">
      <img src="images/logo.png" alt="logo-PUBMTR">
   </div>

   <div class="form-container">

      <form action="" enctype="multipart/form-data" method="post">   
        <table>
            <tr>
                <td colspan = 2><input type="text" name="nip" placeholder="Masukkan NIP" required class="box"></td>
            </tr>

            <tr>
                <td><input type="password" name="password" placeholder="Masukkan Password" required class="box"></td>
                <td><input type="password" name="cpassword" placeholder="Konfirmasi Password" required class="box"></td>
            </tr>

            <tr>
                <td><input type="email" name="email" placeholder="Masukkan Email" required class="box"></td>
                <td><input type="text" name="no_hp" placeholder="Masukkan No HP" required class="box"></td>
            </tr>

            <tr>
                <td colspan = 2><input type="file" name="image" class="box" required accept="image/jpg, image/jpeg, image/png"></td>
            </tr>
        </table>

         <input type="submit" name="submit" value="DAFTAR" class="btn">
         <p>Sudah memiliki akun? <a href="login.php">Masuk Sekarang</a></p>
      </form>

   </div>
</div>
</body>
</html>