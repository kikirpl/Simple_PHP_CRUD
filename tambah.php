<?php
session_start();

if( !isset($_SESSION["login"])){
    header("location: login.php");
    exit;
}


require 'functions.php';




$db = mysqli_connect("localhost", "root", "", "phpdasar");


// cek tombol submit dah kirim belom
if(isset($_POST["submit"])){
   



    // cek apakah data berhasil di tambahkan atau tidak
     if(tambah($_POST) > 0){
        echo "
        <script>
           alert('data berhasil ditambahkan');
           document.location.href = 'index.php';
           </script>
        ";
     } else{
        echo "
        <script>
           alert('data gagal ditambahkan');
           document.location.href = 'index.php';
           </script> ";
     }
    
}



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>tambah data mahasiswa</title>
</head>
<body>
    <h1>tambah data mahasiswa</h1>

    <form action=" " method="post" enctype="multipart/form-data">
     
    <ul>
    <li>
        <label for="nama">Nama :</label>
        <input type="text" name="nama" id="nama" required>
    </li>

    <li>
        <label for="nik">Nik :</label>
        <input type="text" name="nik" id="nik" required>
    </li>

    <li>
        <label for="email">Email :</label>
        <input type="text" name="email" id="email" required>
    </li>
    
    <li>
        <label for="gambar">Gambar :</label>
        <input type="file" name="gambar" id="gambar">
    </li>

    <li>
        <button type="submit" name="submit">Kirim data :</button>
    </li>

    </ul>

    </form>

</body>
</html>