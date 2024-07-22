<?php 
// koneksi ke database
$db = mysqli_connect("localhost", "root", "", "phpdasar");


function query($query){
   global $db;
   $result = mysqli_query($db, $query);
   $rows = [];
   while($row =mysqli_fetch_assoc($result)){
    $rows[] = $row;
   }
    return $rows;
}
function tambah($data){
    global $db;
    $nama = htmlspecialchars($data["nama"]);
    $nik = htmlspecialchars($data["nik"]);
    $email = htmlspecialchars($data["email"]);

    // upload gambar
    $gambar = upload();
    if(!$gambar){
        return false;
    }

    $query = "INSERT INTO mahasiswa VALUES 
    (' ', '$nama', '$nik', '$email', '$gambar' ) 
    ";

mysqli_query($db, $query);

return mysqli_affected_rows($db);
}

function upload(){
   $namaFile = $_FILES['gambar']['name'];
   $ukuranFile = $_FILES['gambar']['size'];
   $error = $_FILES['gambar']['error'];
   $tmpName = $_FILES['gambar']['tmp_name'];
   

   // cek apakah tidak ada gambar yang diupload
    if($error === 4){
        echo "<script> alert('Pilih gambar terlebih dahulu :'); </script>";
        return false;
    } 

    // cek apakah yang diupload adalah gambar
    $eksistensiGambarValid = ['jpg', 'png', 'jpeg'];
    $eksistensiGambar = explode('.', $namaFile);
    $eksistensiGambar = strtolower(end($eksistensiGambar));
     if(!in_array($eksistensiGambar, $eksistensiGambarValid)){
        echo "<script> alert('yang anda masukan bukan gambar !'); </script>";
        return false;
     }

    // cek jika ukurannya terlalu besar
      if($ukuranFile > 1800000){
        echo "<script> alert('ukuran gambar anda terlalu besar !'); </script>";
        return false;
      }

    // lolos pengecekan, gambar siap diupload
    // generate nama gambar baru
      $namaFileBaru = uniqid();
      $namaFileBaru .= '.';
      $namaFileBaru .= $eksistensiGambar;

      move_uploaded_file($tmpName, 'img/' . $namaFileBaru);
      return $namaFileBaru;

}




function hapus($id){
    global $db;
  
    mysqli_query($db, "DELETE FROM mahasiswa WHERE id = $id");
    return mysqli_affected_rows($db);
}

function ubah($data){
    global $db;
    $id = $data["id"];
    $nama = htmlspecialchars($data["nama"]);
    $nik = htmlspecialchars($data["nik"]);
    $email = htmlspecialchars($data["email"]);
    $gambarLama = htmlspecialchars($data["gambarLama"]);

    // cek apakah user pilih gambar baru atau tidak
    if($_FILES['gambar']['error'] === 4){
        $gambar = $gambarLama;
    }else{
        $gambar = upload();
    }

    $query = "UPDATE mahasiswa SET
       nama = '$nama', nik = '$nik', email = '$email', gambar = '$gambar' WHERE id = $id ";

mysqli_query($db, $query);

return mysqli_affected_rows($db);
}

function cari($keyword){
    $query = "SELECT * FROM mahasiswa
                WHERE
                nama LIKE '%$keyword%' OR
                nik LIKE '%$keyword%' OR
                email LIKE '%$keyword%'
                ";
    
    return query($query);
}

function registrasi($data){
    global $db;

    $username = strtolower(stripslashes($data["username"]));
    $password = mysqli_real_escape_string($db, $data["password"]);
    $password2 = mysqli_real_escape_string($db, $data["password2"]);

    // cek username sudah ada atau belum
    $result = mysqli_query($db, "SELECT username FROM user WHERE username = '$username'");
         
    if(mysqli_fetch_assoc($result)){
        echo 
        "<script> alert('username sudah terdaftar !') </script>";
        return false;
    }

    // cek konfirmasi password
      if($password !== $password2){
        echo "<script> alert('Konfirmasi password salah'); </script>";
        return false;
      }
    
    // enkripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);

    // tambahkan user baru ke database
     mysqli_query($db, "INSERT INTO user VALUES('', '$username', '$password')");

     return mysqli_affected_rows($db);
}
    

?>  