<?php
namespace SendSecret\Auth;

use Exception;
use SendSecret\Crud\Crud;
use SendSecret\User\User;
use SendSecret\Duplicate\Duplicate;

class Register
{
    static $table = DEF_TBL_USERS;
    public static function registerUser()
    {
        $fname = stringToUpper(trim($_REQUEST['fname']));
        $lname = stringToUpper(trim($_REQUEST['lname']));
        $email = strtolower(trim($_REQUEST['email']));
        $password = trim($_REQUEST['password']);
        $passwordConfirm = trim($_REQUEST['passwordConfirm']);

        if ($password != $passwordConfirm)
        {
            throw new Exception('Passwords do not match');
        }

        //check if a user exists with the same email
        if (Duplicate::checkIfDuplicateExists(DEF_TBL_USERS, 'email', $email))
        {
            throw new Exception('A user already exists with this email');
        }

        //proceed to register
        $data = [
            'first_name' => $fname,
            'last_name' => $lname,
            'email' => $email,
            'password' => md5($password),
            'cdate' => time()
        ];
        if (Crud::insert(self::$table, $data))
        {
            global $db;
            
            //get last inserted id
            $id = $db->lastInsertId();
            $arFields = ['id', 'first_name', 'last_name', 'email', 'password'];
            $row = User::getUser($id, $arFields);
            if ($row)
            {
                //set a new user session
                $_SESSION['sendSecretUser'] = $row;
            }
            else
            {
                throw new Exception('An error occured while logging you in. Please proceed to login.');
            }
        }
        else
        {
            throw new Exception('An error occured');
        }
    }
}