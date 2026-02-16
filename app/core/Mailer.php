<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../../vendor/autoload.php';
require __DIR__ . '/../config/config.php';

class Mailer
{
    public static function sendVerificationMail($toEmail, $toName, $verifyLink)
    {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = MAIL_HOST;
            $mail->SMTPAuth = true;
            $mail->Username = MAIL_USERNAME;
            $mail->Password = MAIL_PASSWORD;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = MAIL_PORT;

            $mail->setFrom(SENDER_MAIL, APP_NAME); // Sender
            $mail->addAddress($toEmail, $toName); // Receiver

            $toNameSafe = htmlspecialchars($toName);
            $mail->isHTML(true);
            $mail->Subject = 'Verify your Triflock account';
            $mail->Body = "
<!DOCTYPE html>
<html lang='en'>
<head>
<meta charset='UTF-8'>
<title>Verify Your Email</title>
</head>
<body style='font-family: Arial, sans-serif; background-color:#f7f7f7; margin:0; padding:0;'>
  <table width='100%' bgcolor='#f7f7f7' cellpadding='0' cellspacing='0'>
    <tr>
      <td align='center'>
        <table width='600' bgcolor='#ffffff' cellpadding='20' cellspacing='0' style='border-radius:8px; margin-top:40px; border:1px solid #e2e8f0;'>
          <tr>
            <td align='center'>
              <h2 style='color:#f59e0b;'>Triflock</h2>
              <p style='font-size:16px; color:#374151;'>Hi $toNameSafe,</p>
              <p style='font-size:16px; color:#374151;'>Please verify your email to activate your account.</p>
              <a href='$verifyLink' style='display:inline-block; padding:12px 24px; background-color:#f59e0b; color:#fff; text-decoration:none; border-radius:5px; font-weight:bold; margin:20px 0;'>Verify Email</a>
              <p style='font-size:14px; color:#6b7280;'>If you did not create this account, you can ignore this email.</p>
            </td>
          </tr>
        </table>
        <p style='font-size:12px; color:#9ca3af; margin-top:20px;'>© 2026 Triflock. All rights reserved.</p>
      </td>
    </tr>
  </table>
</body>
</html>
";
            $mail->AltBody = "Hi $toNameSafe, verify your account here: $verifyLink";
            $mail->send();
            return true;
        } catch (Exception $e) {
            error_log("Mail Error:" . $mail->ErrorInfo);
            return false;
        }
    }
}
