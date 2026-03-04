<?php
require 'config/koneksi.php';
require 'vendor/autoload.php';

date_default_timezone_set("Asia/Jakarta");
use PHPMailer\PHPMailer\PHPMailer;

$first_name = $_POST['first_name'];
$last_name  = $_POST['last_name'];
$email      = $_POST['email'];
$wa         = $_POST['wa'];
$password   = $_POST['password'];
$password_confirm = $_POST['password_confirm'];

if ($password !== $password_confirm) {
    die("Password tidak sama!");
}

// Hash password
$hash = password_hash($password, PASSWORD_DEFAULT);

// Generate OTP
$verification_code = rand(100000, 999999);
$expired = date("Y-m-d H:i:s", strtotime("+5 minutes"));

// Simpan ke database
$stmt = $conn->prepare("INSERT INTO users 
(first_name, last_name, email, wa, password, verification_code, verification_expired) 
VALUES (?, ?, ?, ?, ?, ?, ?)");

$stmt->bind_param("sssssss",
    $first_name,
    $last_name,
    $email,
    $wa,
    $hash,
    $verification_code,
    $expired
);

$stmt->execute();

// ================== KIRIM EMAIL ==================
$mail = new PHPMailer(true);

$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;
$mail->Username = 'fourcinem4@gmail.com'; // ganti
$mail->Password = 'qvtocqgdpbwbmsrq';  // ganti
$mail->SMTPSecure = 'tls';
$mail->Port = 587;

$mail->setFrom('fourcinem4@gmail.com', 'CINEM4');
$mail->addAddress($email);

$mail->Subject = 'Kode Verifikasi CINEM4';
$mail->Body    = "Halo $first_name,\n\nKode verifikasi akun CINEM4 kamu adalah: $verification_code\nBerlaku 5 menit.";

$mail->send();

header("Location: verify.php?email=$email");
exit;
?>