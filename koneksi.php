<?php

$koneksi = @mysqli_connect('localhost','root','','lefa');
 if(!$koneksi){
    die("Mysql Error : ".mysqli_connect_error());
 }else {
    // echo "Koneksi Sukses";
 }
?>
 