<?php

namespace SophieCalixto\App\Infrastructure\Student;

use SophieCalixto\App\Domain\Student\Student;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../../../vendor/autoload.php';


class SendStudentEmail implements \SophieCalixto\App\Domain\Student\SendStudentEmail
{

    public static function sendEmail(Student $student, string $message): bool|\Exception
    {
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;
            $mail->isSMTP();
            $mail->Host       = 'mailhog';
            $mail->SMTPAuth   = false;
            $mail->Username   = '';
            $mail->Password   = '';
            $mail->SMTPSecure = false;
            $mail->Port       = 1025;

            //Recipients
            $mail->setFrom('', 'Mailer');
            $mail->addAddress($student->email(), $student->name());

            // Content
            $mail->isHTML(true);
            $mail->Subject = $student->email();
            $mail->Body    = nl2br($message);
            $mail->AltBody = $message;

            $mail->send();
            return true;
        } catch (Exception $e) {
            return $e;
        }
    }
}