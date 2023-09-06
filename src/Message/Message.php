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
        //sender's name will only be required for users who are not logged-in
        $userId = 0;
        if (isset($_SESSION['sendSecretUser']))
        {
            $row = $_SESSION['sendSecretUser'];
            $userId = intval($row['id']);
            $senderName = $row['first_name'] . ' ' . $row['last_name'];
        }
        else
        {
            $senderName = '';
            if (isset($_REQUEST['senderName']) && !empty($_REQUEST['senderName']))
            {
                $senderName = stringToUpper(trim($_REQUEST['senderName']));
            }
            if (empty($senderName))
            {
                throw new Exception("Sender's name is required.");
            }
        }
        $plainMsg = trim($_REQUEST['plainMsg']);
        $userSecretKey = trim($_REQUEST['secretKey']);

        //get the saved message code generated upon encryption
        $messageCode = self::invokeMessageEncoding($plainMsg, $userSecretKey);
        
        if (!empty($messageCode))
        {
            /*
                We won't store the user's secret key,
                hence, the decryption cannot be completed with only the available data on the system
            */
            $reference = getAppReference();
            $data = [
                'reference' => $reference,
                'sender_name' => $senderName,
                'message_code' => $messageCode,
                'cdate' => time()
            ];
            if ($userId > 0)
            {
                $data['user_id'] = $userId;
            }

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
        $messageRef = stringToUpper(trim($_REQUEST['messageRef']));
        $userSecretKey = trim($_REQUEST['secretKey']);

        //get message code
        $rs = Crud::select(
            self::$table,
            [
                'columns' => 'message_code, sender_name',
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
                $senderName = $rs['sender_name'];
                $message = <<<EOQ
                <b>Sender:</b> {$senderName}<br>
                <b>Message:</b> {$message}
EOQ;
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

    /*
        ** initiates the encryption action
    */
    protected static function invokeMessageEncoding($message, $userSecretKey)
    {
        $encryptionMethod = DEF_MESSAGE_ENCRYPTION_METHOD;
        $secretKey = hash('sha256', DEF_MESSAGE_SECRET_KEY);
        //hash the user secret key to use as IV, and grab only 16 bytes
        $userSecretKey = substr(hash('sha256', $userSecretKey), 0, 16);
        //concatenate the user secret key with the system key and use as the encryption key
        $secretKey = $userSecretKey . $secretKey;
        
        $output = openssl_encrypt($message, $encryptionMethod, $secretKey, 0, $userSecretKey);
        $messageCode = base64_encode($output);
        
        return $messageCode;
    }

    /*
        ** initiates the decryption action
    */
    protected static function invokeMessageDecoding($messageCode, $userSecretKey)
    {
        $encryptionMethod = DEF_MESSAGE_ENCRYPTION_METHOD;
        $secretKey = hash('sha256', DEF_MESSAGE_SECRET_KEY);
        //hash the user secret key to use as IV, and grab only 16 bytes
        $userSecretKey = substr(hash('sha256', $userSecretKey), 0, 16);
        //concatenate the user secret key with the system key and use as the encryption key
        $secretKey = $userSecretKey . $secretKey;
        
        $message = openssl_decrypt(base64_decode($messageCode), $encryptionMethod, $secretKey, 0, $userSecretKey);
        
        return $message;
    }

    /*
        ** fetches all messages sent by the logged-in user
    */
    public static function getSentMessages()
    {
        global $userId;

        return Crud::select(
            self::$table,
            [
                'columns' => 'id, reference, cdate',
                'where' => [
                    'user_id' => $userId
                ],
                'return_type' => 'all',
                'order' => 'cdate DESC'
            ]
        );
    }
}