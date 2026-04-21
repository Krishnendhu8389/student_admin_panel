<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../../vendor/autoload.php';

class MailHelper {

    public static function sendResultMail($toEmail, $name, $marks, $examTotal) {

        $status = ($marks >= ($examTotal / 2)) ? "PASS 🎉" : "FAIL ❌";

        $mail = new PHPMailer(true);

        try {
           
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;

            $mail->Username = 'haree8389@gmail.com';
            $mail->Password = 'Krishnendhu@8389';

            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('haree8389@gmail.com', 'Student System');
            $mail->addAddress($toEmail, $name);

            $mail->isHTML(true);
            $mail->Subject = "Exam Result Notification";

            $mail->Body = "
                <h2>Hello $name 👋</h2>
                <p>Your exam result is published.</p>

                <table border='1' cellpadding='8'>
                    <tr>
                        <th>Marks</th>
                        <th>Total</th>
                        <th>Status</th>
                    </tr>
                    <tr>
                        <td>$marks</td>
                        <td>$examTotal</td>
                        <td><b>$status</b></td>
                    </tr>
                </table>

                <p>Thank you.</p>
            ";

            $mail->send();
            return true;

        } catch (Exception $e) {
            return false;
        }
    }
}