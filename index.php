<?php
require 'koneksi.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
    <div class="header">
        <div class="selamat-minori">
            <span class="text1">Selamat Datang di Laman Buku Tamu PT.MINORI<br></span>
            <span class="text2">歓迎 ゲスト ブック 申込書 メーカー MINORI 会社</span></p>
        </div>
        <br>
        </br>
        <div class="container">
            <div class="login">
                <form action="proses_login.php" method="post">
                    <h1>Login</h1>
                    <hr>
                    <br>
                    <p><b>Masuk Sebagai Admin</b></p>
                    <br>
                    <div class="field-group">
                        <input type="text" name="name" class="input-field" placeholder="username" autocomplete="off" required='required'>
                        <div class="icon">
                            <i class='bx bxs-user' aria-hidden="true"></i>
                        </div>
                    </div>
                    <div class="field-group">
                        <input type="password" name="password" class="input-field" placeholder="password">
                        <div class="icon">
                            <i class='bx bxs-lock-alt' aria-hidden="true"></i>
                        </div>
                    </div>
                    <button type="submit" name="kirim">Login</button>

                    <p> <a href="form_tamu.php"><i class='bx bx-chevron-left-circle back'></i></a>

                        
                    </p>
                </form>
            </div>
            <div class="right">
                <div class="image-container">
                    <img src="img/Lepa.gif" alt="">

                </div>
            </div>
        </div>
    </div>
</body>

</html>