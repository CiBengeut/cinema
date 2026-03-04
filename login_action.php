<?php
session_start();
require 'config/koneksi.php';

$email = $_POST['email'];
$password = $_POST['password'];

$stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {

    $user = $result->fetch_assoc();

    if ($user['is_verified'] == 0) {
        die("Akun belum diverifikasi. Cek email Anda.");
    }

    if (password_verify($password, $user['password'])) {

        $_SESSION['user'] = $user['id_user'];
        $_SESSION['name'] = $user['first_name'];

        header("Location: index.php");
        exit;

    } else {
        echo "Password salah!";
    }

} else {
    echo "Email tidak ditemukan!";
}
?>