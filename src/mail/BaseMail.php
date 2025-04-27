<?php

namespace divyashrestha\Mvc\mail;

use divyashrestha\Mvc\Application;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

/**
 * Class BaseMail
 *
 * @author Divya Shrestha <work@divyashrestha.com.np>
 * @package divyashrestha\Mvc
 *
 */
class BaseMail
{
    /**
     * @param array $tos
     * @param string $subject
     * @param string $body
     * @param array $reply_tos
     * @param array $ccs
     * @param array $bccs
     * @param array $attachments
     * @return bool|string
     */
    public static function sendMail(array $tos, string $subject, string $body, array $reply_tos = [], array $ccs = [], array $bccs = [], array $attachments = []): bool|string
    {
        $mail_config = Application::$app->mail_config;
        $mail = new PHPMailer(true);

        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;
        if ($mail_config['mailer'] == 'smtp') {
            $mail->isSMTP();
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = $mail_config['encryption'] || PHPMailer::ENCRYPTION_SMTPS;
        } else {
            $mail->Mailer = $mail_config['mailer'];
        }
        $mail->Host = $mail_config['host'];
        $mail->Username = $mail_config['username'];
        $mail->Password = $mail_config['password'];
        $mail->Port = $mail_config['port'];
        try {
            $mail->setFrom($mail_config['from_address'], Application::$app->app_config['name']);

            foreach ($tos as $to) {
                $mail->addAddress($to['email'], $to['name'] || '');
            }

            if (empty($reply_tos)) {
                $mail->addReplyTo($mail_config['from_address'], Application::$app->app_config['name']);
            } else {
                foreach ($reply_tos as $reply_to) {
                    $mail->addReplyTo($reply_to['email'], $reply_to['name'] || '');
                }
            }

            foreach ($bccs as $bcc) {
                $mail->addBCC($bcc['email'], $bcc['name'] || '');
            }

            foreach ($ccs as $cc) {
                $mail->addCC($cc['email'], $cc['name'] || '');
            }

            foreach ($attachments as $attachment) {
                $mail->addAttachment($attachment['url'], $attachment['name'] || '');
            }

            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $body;
            console_log("sending mail");
            return $mail->send();
        } catch (Exception $exception) {
            $message = $exception->getMessage();
            console_log("Error on sending mail: $message and Mailer Error: {$mail->ErrorInfo}");
            return "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}
