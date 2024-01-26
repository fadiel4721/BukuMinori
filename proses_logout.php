<?php
session_start();
session_destroy(); 


header("Location: index.php"); // Arahkan ke halaman login
exit();
?>
