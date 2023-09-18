<?php

@include '../config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:../login.php');
}

if(isset($_POST['submit'])){

    $select_user = $conn->prepare("SELECT * FROM `akun` WHERE id_akun = ? LIMIT 1");
    $select_user->execute([$admin_id]);
    $fetch_user = $select_user->fetch(PDO::FETCH_ASSOC);
 
    $prev_pass = $fetch_user['password'];
    $prev_image = $fetch_user['image'];
 
    $image = $_FILES['image']['name'];
    $image = filter_var($image, FILTER_SANITIZE_STRING);
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = '../uploaded_img/'.$image;
 
    if(!empty($image)){
       if($image_size > 2000000){
          $message[] = 'Ukuran gambar terlalu besar!';
       }else{
          $update_image = $conn->prepare("UPDATE `akun` SET `image` = ? WHERE id_akun = ?");
          $update_image->execute([$image, $admin_id]);
          move_uploaded_file($image_tmp_name, $image_folder);
          unlink('../uploaded_img/'.$prev_image);
          $message[] = 'Gambar berhasil diupdate!';
          }
    }
 
    $empty_pass = 'da39a3ee5e6b4b0d3255bfef95601890afd80709';
    $old_pass = md5($_POST['old_pass']);
    $old_pass = filter_var($old_pass, FILTER_SANITIZE_STRING);
    $new_pass = md5($_POST['new_pass']);
    $new_pass = filter_var($new_pass, FILTER_SANITIZE_STRING);
    $cpass = md5($_POST['cpass']);
    $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);
 
    if($old_pass != $empty_pass){
       if($old_pass != $prev_pass){
          $message[] = 'Password lama tidak cocok!';
       }elseif($new_pass != $cpass){
          $message[] = 'Konfirmasi password tidak cocok!';
       }else{
          if($new_pass != $empty_pass){
             $update_pass = $conn->prepare("UPDATE `akun` SET password = ? WHERE id_akun = ?");
             $update_pass->execute([$cpass, $admin_id]);
             $message[] = 'Password berhasil diperbarui!';
          }else{
             $message[] = 'Tolong masukkan password baru!';
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
    <title>Update Profile</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include 'header.php'; ?>

<section class="form-container" style="min-height: calc(100vh - 19rem);">

   <form action="" method="post" enctype="multipart/form-data">
      <h3>update profile</h3>
      <div class="flex">
         <div class="col">
            <p>Foto Profile</p>
            <input type="file" name="image" accept="image/*" class="box">
            <p>Password Lama</p>
            <input type="password" name="old_pass" placeholder="Masukkan password lama" maxlength="50" class="box">
         </div>
         <div class="col">
            <p>Password Baru</p>
            <input type="password" name="new_pass" placeholder="Masukkan password baru" maxlength="50" class="box">
            <p>Konfirmasi Password</p>
            <input type="password" name="cpass" placeholder="Konfirmasi password baru" maxlength="50" class="box">
         </div>
      </div>
      <input type="submit" name="submit" value="update profile" class="btn">
   </form>

</section>

<!-- update profile section ends -->

<!-- footer section starts  -->
<?php include 'footer.php'; ?>
<!-- footer section ends -->

<!-- custom js file link  -->
<script src="../js/admin_script.js"></script>
    
</body>
</html>