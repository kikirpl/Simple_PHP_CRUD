<?php
session_start();

if( !isset($_SESSION["login"])){
    header("location: login.php");
    exit;
}


require 'functions.php';

// ambiil data di url
$id = $_GET["id"];

// query data mahasiswa berdasarkan id
$m = query("SELECT * from mahasiswa WHERE id = $id")[0];



// cek tombol submit dah kirim belom
if(isset($_POST["submit"])){
   
    // cek apakah data berhasil di ubah atau tidak
     if(ubah($_POST) > 0){
        echo "
        <script>
           alert('data berhasil diubah');
           document.location.href = 'index.php';
           </script>
        ";
     } else{
        echo "
        <script>
           alert('data gagal diubah');
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
    <title>ubah data mahasiswa</title>
</head>
<body>
    <h1>ubah data mahasiswa</h1>

    <form action=" " method="post" enctype="multipart/form-data">

     <input type="hidden" name="id" value="<?= $m["id"]; ?>">
     <input type="hidden" name="gambarLama" value="<?= $m["gambar"]; ?>">

    <ul>
    <li>
        <label for="nama">Nama :</label>
        <input type="text" name="nama" id="nama" required value="<?= $m["nama"]; ?>">
    </li>

    <li>
        <label for="nik">Nik :</label>
        <input type="text" name="nik" id="nik" required value="<?= $m["nik"]; ?>">
    </li>

    <li>
        <label for="email">Email :</label>
        <input type="text" name="email" id="email" required value="<?= $m["email"]; ?>">
    </li>
    
    <li>
        <label for="gambar">Gambar :</label> <br>
        <img src="img/<?= $m['gambar'];?>" width="60px"> <br>
        <input type="file" name="gambar" id="gambar" >
    </li>

    <li>
        <button type="submit" name="submit">ubah data :</button>
    </li>

    </ul>

    </form>

</body>
</html>