<?php
use PHPUnit\Framework\TestCase;
use SendSecret\Message\Message;

//some of the classes use values/functions from the files below
if (!defined('DEF_IS_PRODUCTION'))
{
    define('DEF_IS_PRODUCTION', false);
}
require_once 'vendor/autoload.php';
require_once 'includes/functions.php';
require_once 'includes/constants.php';
require_once 'includes/connect.php';

class MessageTest extends TestCase
{
    public function testEncodeMessage()
    {
        $_REQUEST['senderName'] = 'Sam Adeoye';
        $_REQUEST['plainMsg'] = 'This is a test from PHPUnit';
        $_REQUEST['secretKey'] = '1234';
        //check that no exception is thrown
        $this->expectNotToPerformAssertions();

        //MESSAGE ENCRYPTION
        //should not throw any error
        Message::encodeMessage();

        //MESSAGE DECRYPTION
        $_REQUEST['messageRef'] = 'ERHERTKL7T89';
        $_REQUEST['secretKey'] = '1223';
        //should throw an error, as an invalid message reference and secret key have been passed
        Message::decodeMessage();
    }
}