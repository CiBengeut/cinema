<?php
session_start();
require 'config/koneksi.php';

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($email) || empty($password)) {
    $_SESSION['error'] = "empty";
    header("Location: join-us.php?mode=login");
    exit;
}

$stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();

    if ($user['is_verified'] == 0) {
        $_SESSION['error'] = "not_verified";
        header("Location: join-us.php?mode=login");
        exit;
    }

    if (password_verify($password, $user['password'])) {
        $_SESSION['user'] = $user['id_user'];
        $_SESSION['name'] = $user['first_name'];
        header("Location: index.php");
        exit;
    } else {
        $_SESSION['error'] = "wrong_password";
        header("Location: join-us.php?mode=login");
        exit;
    }

} else {
    $_SESSION['error'] = "email_not_found";
    header("Location: join-us.php?mode=login");
    exit;
}
?>