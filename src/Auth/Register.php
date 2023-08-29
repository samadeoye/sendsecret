<?php
namespace SendSecret\Auth;

use Exception;
use SendSecret\Crud\Crud;
use SendSecret\User\User;

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
            getJsonRow(false, 'Passwords do not match');
        }

        //check if a user exists with the same email
        if (User::checkIfUserExists('email', $email))
        {
            throw new Exception('A user already exists with this email');
        }

        //proceed to register
        $data = [
            'fname' => $fname,
            'lname' => $lname,
            'email' => $email,
            'password' => md5($password),
            'cdate' => time()
        ];
        if (Crud::insert(self::$table, $data))
        {
            global $db;
            
            //get last inserted id
            $id = $db->lastInsertId();
            $rs = Crud::select(
                self::$table,
                [
                    'columns' => 'fname, lname, email, password',
                    'where' => [
                        'id' => $id
                    ]
                ]
            );
            //set a new user session
            $_SESSION['user'] = $rs;
        }
        else
        {
            throw new Exception('An error occured');
        }
    }
}