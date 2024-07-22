<?php 
session_start();

if( !isset($_SESSION["login"])){
    header("location: login.php");
    exit;
}

require 'functions.php';
$mahasiswa = query("SELECT * FROM mahasiswa ");

// tombol cari di tekan
if(isset($_POST["cari"])){
    $mahasiswa = cari($_POST["keyword"]);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman admin</title>
</head>
<body>
    <a href="logout.php">logout</a>
    <h1>Daftar mahasiswa</h1>

    
     <a href="tambah.php">Tambah data mahasiswa</a>
     <br> 
     <br>
     <form action="" method="post">
       
       <input type="text" name="keyword" size="40" autofocus
       placeholder="masukan keyword pencarian..." autocomplete="off">
       <button type="submit" name="cari">Cari</button>

     </form>   
     <br>

    <table border="1" cellpadding="10" cellspacing="0">
 <tr>
      <th>No.</th>
      <th>Aksi</th>
      <th>gambar</th>
      <th>Nik</th>
      <th>Nama</th>
      <th>Email</th>
</tr>
   <?php $i=1;?> 
<?php foreach($mahasiswa as $row): ?>    

<tr>
      <td><?= $i;?></td>
        <td><a href="ubah.php?id=<?=$row['id']; ?>">Ubah</a> 
          <a href="hapus.php?id=<?= $row["id"]; ?>"onclick="
          return confirm('yakin?');">Hapus</a></td>
      <td><img src="img/<?= $row["gambar"] ?>" alt=""></td>
      <td><?= $row["nik"]; ?></td>
      <td><?= $row["nama"]; ?></td>
      <td><?= $row["email"]; ?></td>
</tr>     
<?php $i++; ?>
<?php endforeach;?>

    </table>

</body>
</html>