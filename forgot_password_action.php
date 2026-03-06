<?php
include "config/koneksi.php";

require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

date_default_timezone_set("Asia/Jakarta");

$email = $_POST['email'];

$q = mysqli_query($conn,"SELECT * FROM users WHERE email='$email'");

if(mysqli_num_rows($q) > 0){

    $token = bin2hex(random_bytes(32));
    $expired = date("Y-m-d H:i:s", strtotime("+1 hour"));

    mysqli_query($conn,"
        UPDATE users 
        SET reset_token='$token', reset_expired='$expired'
        WHERE email='$email'
    ");

    $link = "http://localhost/cinema/reset_password.php?token=$token";

    $mail = new PHPMailer(true);

    try {

        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username = 'fourcinem4@gmail.com'; 
        $mail->Password = 'qvtocqgdpbwbmsrq';  
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        $mail->setFrom('fourcinem4@gmail.com', 'CINEM4');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Reset Password CINEM4';

        $mail->Body = "
        <h2>Reset Password CINEM4</h2>
        <p>Klik tombol di bawah untuk reset password:</p>

        <a href='$link'
        style='
        padding:12px 25px;
        background: rgba(31,111,255,.48);
        color:white;
        text-decoration:none;
        border-radius:5px;'>
        Reset Password
        </a>

        <p>Link berlaku selama 1 jam.</p>
        ";

        $mail->send();

        echo "Link reset password telah dikirim ke email.";

    } catch (Exception $e) {
        echo "Email gagal dikirim.";
    }

}else{
    echo "Email tidak ditemukan.";
}