<?php
namespace SendSecret\Message;

use Exception;
use SendSecret\Crud\Crud;

class Message
{

    static $table = DEF_TBL_MESSAGES;
    static $data = [];
    public static function encodeMessage()
    {
        $senderName = stringToUpper(trim($_REQUEST['senderName']));
        $plainMsg = trim($_REQUEST['plainMsg']);
        $userSecretKey = trim($_REQUEST['secretKey']);
        $userId = 0;
        if (isset($_SESSION['user']))
        {
            $userId = intval($_SESSION['user']['id']);
        }

        //get the saved message code generated upon encryption
        $messageCode = self::invokeMessageEncoding($plainMsg, $userSecretKey);
        
        if (!empty($messageCode))
        {
            $reference = uniqid();
            $data = [
                'reference' => $reference,
                'sender_name' => $senderName,
                'user_id' => $userId,
                'message_code' => $messageCode,
                'cdate' => time()
            ];
            $insert = Crud::insert(self::$table, $data);
            if ($insert)
            {
                self::$data = [
                    'reference' => $reference
                ];
            }
        }
        else
        {
            throw new Exception('An error occured while encoding your message. Please try again.');
        }
    }
    
    public static function decodeMessage()
    {
        $messageRef = trim($_REQUEST['messageRef']);
        $userSecretKey = trim($_REQUEST['secretKey']);

        //get message code
        $rs = Crud::select(
            self::$table,
            [
                'columns' => 'message_code',
                'where' => [
                    'reference' => $messageRef
                ]
            ]
        );
        if ($rs)
        {
            $messageCode = $rs['message_code'];
            $message = self::invokeMessageDecoding($messageCode, $userSecretKey);
            
            if (!empty($message))
            {
                self::$data = [
                    'message' => $message
                ];
            }
            else
            {
                throw new Exception('An error occured. Please ensure you have entered the correct secret key');
            }
        }
        else
        {
            throw new Exception('You have entered an invalid message reference!');
        }
    }

    protected static function invokeMessageEncoding($message, $userSecretKey)
    {
        $encryptionMethod = DEF_MESSAGE_ENCRYPTION_METHOD;
        $secretKey = hash('sha256', DEF_MESSAGE_SECRET_KEY);
        $userSecretKey = substr(hash('sha256', $userSecretKey), 0, 16);
        $secretKey .= $userSecretKey;
        
        $output = openssl_encrypt($message, $encryptionMethod, $secretKey, 0, $userSecretKey);
        $messageCode = base64_encode($output);
        
        return $messageCode;
    }

    protected static function invokeMessageDecoding($messageCode, $userSecretKey)
    {
        $encryptionMethod = DEF_MESSAGE_ENCRYPTION_METHOD;
        $secretKey = hash('sha256', DEF_MESSAGE_SECRET_KEY);
        $userSecretKey = substr(hash('sha256', $userSecretKey), 0, 16);
        $secretKey .= $userSecretKey;
        
        $message = openssl_decrypt(base64_decode($messageCode), $encryptionMethod, $secretKey, 0, $userSecretKey);
        
        return $message;
    }
}