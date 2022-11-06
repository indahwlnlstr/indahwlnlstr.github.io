<?php 
    include "../header.php";


    $idKolam = $_GET['id'];

    if(isset($_POST['update'])){
        $namaKolam = $_POST['nama_kolam'];
        $harga = $_POST['harga'];
        $slot = $_POST['slot'];
        $tableGambar = mysqli_query($connect, "SELECT * FROM images WHERE id_kolam='$idKolam'");
        $rowGambar = mysqli_fetch_array($tableGambar);
        $fileLama = $rowGambar['file'];
        unlink('../img/'.$fileLama);

        $query = mysqli_query($connect, "UPDATE kolam SET nama_kolam='$namaKolam', harga='$harga', slot='$slot' WHERE id_kolam='$idKolam'");
        if(!empty($_FILES['gambar']['name'])){
            $query = mysqli_query($connect,"SELECT * FROM kolam WHERE nama_kolam='$namaKolam'");
            $result = mysqli_fetch_assoc($query);
            $id = $result['id_kolam'];
            $waktu = $_POST['waktu'];
            $nama = $_POST['nama_gambar'];
            $gambar = $_FILES['gambar']['name'];
            $x = explode('.',$gambar);
            $ekstensi = strtolower(end($x));
            $gambar_baru = "$nama.$ekstensi";
            $tmp = $_FILES['gambar']['tmp_name'];
            if(move_uploaded_file($tmp,"../img/$gambar_baru")){
              $query1 = mysqli_query($connect,"UPDATE images SET id_kolam='$id',upload_on='$waktu', file='$gambar_baru' WHERE id_kolam='$idKolam'");
        if($query && $query1){
            echo"Data Berhasil di Update";
            header("location:index.php");
        } else {
            echo"Data Gagal di Update";
        }
    }
}
    }

    $tableKolam = mysqli_query($connect, "SELECT * FROM kolam WHERE id_kolam='$idKolam'");
    $rowKolam = mysqli_fetch_array($tableKolam);
    $tableGambar = mysqli_query($connect, "SELECT * FROM images WHERE id_kolam='$idKolam'");
    $rowGambar = mysqli_fetch_array($tableGambar);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Halaman Update Data Kolam</title>
    <style>
	* {
    margin: 0;
    padding: 0;
    }
        table th {
        text-align: center;
            background-color: #E5EBB2;
            color: black;
        }
        table {
            font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 50%;
            margin-top: 10%;
            margin-left: auto;
            margin-right: auto;
            border: 2px solid black;
    }
        table td, table th {
            border: 1px solid black;
            padding: 5px;
    }
    table tr td a {
    color: black;
    }

    table tr:nth-child(even){background-color: #BCE29E; color: black;}
    table tr:nth-child(odd){background-color: #BCE29E; color: black;}
	</style>   
</head>
<body class=body>
<section class="center">
        <form action="" method="POST" enctype="multipart/form-data" class="box">
            <table border="0" align="center">
                <tr>
                    <th colspan="2">Data Kolam Yang Akan Di Update</th>
                </tr>
                <tr>
                    <td>Nama Kolam</td>
                    <td><input type="text" name="nama_kolam" placeholder="Masukkan Nama Kolam" value="<?= $rowKolam['nama_kolam'] ?>"required></td>
                </tr>
                <tr>
                    <td>Harga Tiket</td>
                    <td><input type="number" name="harga" placeholder="Masukkan Harga Tiket" value="<?= $rowKolam['harga'] ?>"required></td>
                </tr>

                <tr>
                    <td>Slot</td>
                    <td><input type="number" name="slot" placeholder="Masukkan Stock Kolam" value="<?= $rowKolam['slot'] ?>"required></td>
                </tr>
                <tr>
                    <td>Nama File</td>
                    <td><input type="text" name="nama_gambar" placeholder="Masukkan Nama Sesuai File" required></td>
                </tr>
                <tr>
                    <td>File</td>
                    <td><input type="file" name="gambar" value="<?=$rowGambar['file']?>"required></td>
                    <input type="datetime"  value="<?php echo date("Y-m-d\TH:i:s"); ?>" hidden name="waktu">
                </tr>

                <tr>
                    <td align="center" colspan="2"><hr><input type="submit" name="update" value="Update"></td>
                </tr>
            </table>
        </form>
    </section>
</body>
</html>