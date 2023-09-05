<?php
use PHPUnit\Framework\TestCase;
use SendSecret\Duplicate\Duplicate;

//some of the classes use values/functions from the files below
if (!defined('DEF_IS_PRODUCTION'))
{
    define('DEF_IS_PRODUCTION', false);
}
require_once 'vendor/autoload.php';
require_once 'includes/functions.php';
require_once 'includes/constants.php';
require_once 'includes/connect.php';

class DuplicateTest extends TestCase
{
    public function testCheckIfDuplicateExists()
    {
        //check with the users table with a user already created from testing the Register class
        $result = Duplicate::checkIfDuplicateExists(DEF_TBL_USERS, 'email', 'samueladeoye@gmail.com');
        //check that result is true
        $this->assertEquals(true, $result);
    }
}