<?php
/* Candra adi putra <candraadiputra@gmail.com
 * CandraLab Studio (c)(2013)
 * http://www.candra.web.id
 * last edit: 14 okt 2013 
 */
 
require_once ('../inc/config.php');
//data dari halaman

$judul = $_POST['judul'];
$isi = mysql_real_escape_string($_POST['isi']);
$aksi = mysql_real_escape_string($_POST['aksi']);
$id = $_POST['id'];


$halaman_file = $_FILES['gambar']['tmp_name'];
$gambar_file = $_FILES['gambar']['name'];
$tipe_file = $_FILES['gambar']['type'];
$ukuran_file = $_FILES['gambar']['size'];
$direktori = "../upload/halaman/$gambar_file";
$sql = null;
$MAX_FILE_SIZE = 1000000;
//100kb
if($ukuran_file > $MAX_FILE_SIZE) {
	header("Location:../index.php?mod=halaman&pg=halaman_form&status=1");
	exit();
}
$sql = null;
if($ukuran_file > 0) {
	move_uploaded_file($halaman_file, $direktori);
}

if($aksi == 'tambah') {
	$sql = "INSERT INTO halaman(judul,gambar,tanggal,isi)
		VALUES('$judul','$gambar_file',now(),'$isi')";
}else if($aksi== 'edit') {
	if(!empty($gambar)){
	$sql = "update halaman set judul='$judul',
	gambar='$gambar_file',isi='$isi'
	where idhalaman='$id'";
	}else{
		$sql = "update halaman set judul='$judul',
	isi='$isi'
	where idhalaman='$id'";
	}
}

$result = mysql_query($sql) or die(mysql_error());

//check if query successful
if ($result) {
	header('location:../index.php?mod=halaman&pg=halaman_view&status=0');
} else {
	header('location:../index.php?mod=halaman&pg=halaman_view&status=1');
}
mysql_close();
?>
