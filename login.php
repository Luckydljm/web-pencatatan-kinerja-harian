<?php

@include 'config.php';

session_start();

if(isset($_POST['submit'])){

   $nip = $_POST['nip'];
   $nip = filter_var($nip, FILTER_SANITIZE_STRING);
   $password = md5($_POST['password']);
   $password = filter_var($password, FILTER_SANITIZE_STRING);

   $sql = "SELECT * FROM `akun` WHERE nip = ? AND password = ?";
   $stmt = $conn->prepare($sql);
   $stmt->execute([$nip, $password]);
   $rowCount = $stmt->rowCount();  

   $row = $stmt->fetch(PDO::FETCH_ASSOC);

   if($rowCount > 0){

      if($row['user_type'] == 'admin'){

         $_SESSION['admin_id'] = $row['id_akun'];
         header('location:admin/home.php');

      }elseif($row['user_type'] == 'pegawai'){

         $_SESSION['user_id'] = $row['id_akun'];
         header('location:home.php');

      }else{
         $message[] = 'Akun tidak ditemukan!';
      }

   }else{
      $message[] = 'NIP atau password salah!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/components.css">

    <style>
      body {
         background-image: url('images/bg-login.jpg');
         background-size: cover;
      }
   </style>

</head>
<body>
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
<div class="logo-login">
   <img src="images/logo.png" alt="logo-PUBMTR">
</div>

<div class="form-container">

   <form action="" method="post">   
      <input type="text" name="nip" placeholder="Masukkan NIP" required class="box">
      <input type="password" name="password" placeholder="Masukkan Password" required class="box">
      <input type="submit" name="submit" value="LOGIN" class="btn">
         <p>Belum memiliki akun? <a href="registrasi.php">Daftar Sekarang</a></p>
   </form>

</div>
</body>
</html>