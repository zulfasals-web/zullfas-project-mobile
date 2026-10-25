<?php
include 'koneksi.php';

$email    = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if (!empty($email) && !empty($password)) {
    $query  = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        // Mengirimkan role ke App Inventor (admin / pelanggan)
        echo $user['role']; 
    } else {
        echo "Email atau Password Salah!";
    }
} else {
    echo "Email dan Password wajib diisi!";
}
mysqli_close($conn);
?>