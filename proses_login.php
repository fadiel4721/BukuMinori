<?php
session_start(); // Start session

require 'koneksi.php';

if (isset($_POST['kirim'])) {
    // Variables from the form
    $username = $_POST['name'];
    $password = $_POST['password'];

    // Query to get user data based on the username
    $query = "SELECT * FROM user WHERE username = '$username'";
    $result = mysqli_query($koneksi, $query);

    // Check if the user with the given username is found
    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        // Check if the entered password is correct
        if (password_verify($password, $user['password'])) {
            // Login successful, set session or display a message
            $_SESSION['user_id'] = $user['id_user'];
            $_SESSION['username'] = $user['username'];

            $_SESSION ['ceklogin'] = true;
            // Display SweetAlert for success
            echo '<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>';
            echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
            echo '<script>
                    $(document).ready(function() {
                        Swal.fire({
                            icon: "success",
                            title: "Login berhasil!",
                            text: "Selamat datang, ' . $user['username'] . '",
                            showConfirmButton: false,
                            timer: 3000
                        }).then(function() {
                            window.location.href = "homepageadmin.php";
                        });
                    });
                </script>';
            exit(); // Stop execution to prevent further redirection
        } else {
            $error = "Password yang dimasukkan salah.";
            $redirect = "index.php"; // Redirect to the login page if the password is incorrect
        }
    } else {
        $error = "Username tidak ditemukan.";
        $redirect = "index.php"; // Redirect to the login page if the username is not found
    }
}

// Display SweetAlert for errors and redirect
echo '<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>';
echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
echo '<script>
        $(document).ready(function() {
            Swal.fire({
                icon: "error",
                title: "Login Gagal!",
                text: "' . $error . '",
                showConfirmButton: false,
                timer: 3000
            }).then(function() {
                window.location.href = "' . $redirect . '"; // Adjust to your login page
            });
        });
      </script>';
exit();
?>
