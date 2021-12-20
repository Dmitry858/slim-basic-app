<?php

namespace App\Support;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mail
{
    public function send($message, $subject = null, $to = null): array
    {
        $mail = new PHPMailer();
        $email = $to ?? config('mail.to.address');
        $subject = $subject ?? 'Сообщение с сайта '.$_SERVER['SERVER_NAME'];
        try
        {
            $mail->setFrom(config('mail.from.address'), config('mail.from.name'));
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $message;
            $mail->CharSet = PHPMailer::CHARSET_UTF8;
            $mail->send();
            return [
                'status' => 'success',
                'message' => 'Письмо успешно отправлено'
            ];
        }
        catch (Exception $e)
        {
            return [
                'status' => 'error',
                'message' => $mail->ErrorInfo
            ];
        }
    }
}