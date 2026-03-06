<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mailer
{
    public static function send($to, $subject, $body)
    {
        require_once ROOT_PATH . '/vendor/autoload.php'; 
        // If NOT using composer, manually require PHPMailer files instead

        $mail = new PHPMailer(true);

        try {
            // SMTP configuration
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'clsd@lspu.edu.ph'; // change
            $mail->Password   = 'nkpinbbgiqrwvdgn';   // Gmail App Password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            // Sender
            $mail->setFrom('clsd@lspu.edu.ph', 'CLSD System');

            // Recipient
            $mail->addAddress($to);

            // Content
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $body;

            $mail->send();
            return true;

        } catch (Exception $e) {
            return false;
        }
    }
}