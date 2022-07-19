<?php
// koneksi ke data base
include_once("control/config.php");
 
// ambil id dari url
$id = $_GET['id'];

echo $id;
 
// perintah delet database
$result = mysqli_query($mysqli, "DELETE FROM data_rfid WHERE id=$id");
 
// redirect ke index.php
header("Location:index.php");
?>
