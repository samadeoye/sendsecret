<?php
use PHPUnit\Framework\TestCase;
use SendSecret\Auth\Login;

//some of the classes use values/functions from the files below
if (!defined('DEF_IS_PRODUCTION'))
{
    define('DEF_IS_PRODUCTION', false);
}
require_once 'vendor/autoload.php';
require_once 'includes/functions.php';
require_once 'includes/constants.php';
require_once 'includes/connect.php';

class LoginTest extends TestCase
{
    public function testLoginUser()
    {
        $_REQUEST['email'] = 'samueladeoye@gmail.com';
        $_REQUEST['password'] = 'Sam123#Adeoye@@!0';

        //check that no exception is thrown
        $this->expectNotToPerformAssertions();
        Login::loginUser();
    }
}