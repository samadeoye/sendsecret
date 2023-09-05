<?php
namespace SendSecret\Mail;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class SendMail
{
    static $isSent = false;
    public static function sendMail($arParams)
    {
        $mail = new PHPMailer(true);

        try
        {
            $mail->isMail();

            $mailTo = $arParams['mailTo'];
            $toName = $arParams['toName'];
            $mailFrom = $arParams['mailFrom'];
            $fromName = $arParams['fromName'];
            $subject =  (array_key_exists('subject', $arParams)) ? $arParams['subject'] : 'Mail From '.SITE_NAME;
            $body =  (array_key_exists('body', $arParams)) ? $arParams['body'] : '';
            $bodyHtml =  (array_key_exists('bodyHtml', $arParams)) ? $arParams['bodyHtml'] : '';
            $addReplyTo = (array_key_exists('addReplyTo', $arParams)) ? $arParams['addReplyTo'] : false;
            $isHtml = (array_key_exists('isHtml', $arParams)) ? $arParams['isHtml'] : false;
            $arCC = (array_key_exists('arCC', $arParams)) ? $arParams['arCC'] : [];
            $arBCC = (array_key_exists('arBCC', $arParams)) ? $arParams['arBCC'] : [];
            $arAttachments = (array_key_exists('arAttachments', $arParams)) ? $arParams['arAttachments'] : [];
            
            //Recipients
            $mail->setFrom($mailFrom, $fromName);
            $mail->addAddress($mailTo, $toName);
            if ($addReplyTo)
            {
                $mail->addReplyTo($mailFrom, $fromName);
            }
            if (count($arCC) > 0)
            {
                foreach($arCC as $ccEmail)
                {
                    $mail->addCC($ccEmail);
                }
            }
            if (count($arBCC) > 0)
            {
                foreach($arBCC as $bccEmail)
                {
                    $mail->addBCC($bccEmail);
                }
            }

            //Attachments
            if (count($arAttachments) > 0)
            {
                foreach($arAttachments as $attachment)
                {
                    $mail->addAttachment($attachment);
                }
            }

            //Content
            if ($isHtml)
            {
                $mail->isHTML(true);
                if ($bodyHtml == '' && $body != '')
                {
                    $mail->AltBody = $body;
                    $bodyHtml = $body;
                }
                $body = $bodyHtml;
            }
            else
            {
                $mail->AltBody = $body;
            }
            $mail->Subject = $subject;
            $mail->Body = $body;

            if ($mail->send())
            {
                self::$isSent = true;
            }
            else
            {
                throw new Exception('Message could not be sent'); 
            }
            self::$isSent = true;
        }
        catch (Exception $e)
        {
            self::$isSent = false;
            throw new Exception('Message could not be sent');
            //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}