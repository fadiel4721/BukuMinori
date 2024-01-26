<?php
?>
<nav class="sidebar close">
    <header>
        <div class="image-text">
            <span class="image">
                <img src="img/logo-minori-fotor.png" alt="logo">
            </span>
            <div class="text header-text">
                <span class="name">Buku Tamu</span>
                <span class="profession">PT MINORI</span>
            </div>
        </div>
        <i class='bx bx-chevron-right toggle'></i>
    </header>
    <div class="menu-bar">
        <div class="menu">
            <ul class="menu-links">
                <li class="search-box">
                    <a href="profil.php">
                    <i class='bx bxs-user-pin text'></i>
                    <span class="text nav-text">
                           Profil
                        </span>
                    </a>
                </li>
                <li class="nav-link">
                    <a href="homepage.php">
                        <i class='bx bx-bar-chart icon'></i>
                        <span class="text nav-text">
                            Statistik
                        </span>
                    </a>
                </li>
                <li class="nav-link">
                    <a href="tamu.php">
                        <i class='bx bx-book icon'></i>
                        <span class="text nav-text">
                            Tamu
                        </span>
                    </a>
                </li>
                <li class="nav-link">
                    <a href="history.php">
                        <i class='bx bx-history icon'></i>
                        <span class="text nav-text">
                            History Tamu
                        </span>
                    </a>
                </li>
                <li class="nav-link">
                    <a href="frekuensi_kunjungan.php">
                    <i class='bx bxs-group icon'></i>
                        <span class="text nav-text">
                            Frekuensi Tamu
                        </span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="bottom-content">
            <li class="">
                <a href="proses_logout.php" onclick="return konfirmasi();">
                    <i class='bx bx-log-out icon'></i>
                    <span class="text nav-text">
                        Log Out
                    </span>
                </a>
            </li>
            <li class="mode">
                <div class="moon-sun">
                    <i class='bx bx-moon icon moon'></i>
                    <i class='bx bx-sun icon sun'></i>
                </div>
                <span class="mode-text text">Dark Mode</span>
                <div class="toggle-switch">
                    <span class="switch"></span>
                </div>
            </li>
        </div>
    </div>
</nav>
<script>
    function konfirmasi() {
        return confirm('Apakah Anda Yakin Untuk Log Out?');
    }
</script>
<script src="js/script.js"></script>