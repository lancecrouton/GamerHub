<?php
session_start();
?>
<?php
if (!isset($_SERVER['HTTP_REFERER'])) {
    header('location: index.php');
    exit;
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

include('recoverPassword.php');

if (isset($_POST["send"])) {
    $mail = new PHPMailer(true);

    $mail->isSMTP();
    $mail->Host = "smtp.gmail.com";
    $mail->SMTPAuth = true;
    $mail->Username = 'cosc360gamerhub@gmail.com';
    $mail->Password = 'bucmwttmgidnidch';
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;

    $mail->setFrom('cosc360gamerhub@gmail.com');
    $mail->addAddress($_POST["email"]);

    $mail->isHTML(true);

    $new_password = $_SESSION['new_password'];

    $mail->Subject = "Gamerhub - Password Recovery";
    $mail->Body = "Your new password is: " . $new_password;

    try {
        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    }
}
