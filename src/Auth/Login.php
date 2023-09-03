<?php
namespace SendSecret\Auth;

use Exception;
use SendSecret\Crud\Crud;
use SendSecret\User\User;

class Login
{
    static $table = DEF_TBL_USERS;
    public static function loginUser()
    {
        $email = trim($_REQUEST['email']);
        $password = trim($_REQUEST['password']);

        //check if a user exists with the email
        $row = Crud::select(
            self::$table,
            [
                'columns' => 'id, first_name, last_name, email, password, status',
                'where' => [
                    'email' => $email,
                    'deleted' => 0
                ]
            ]
        );
        if ($row)
        {
            if ($row['status'] != 1)
            {
                throw new Exception('Your account is disabled. Please contact the admin.');
            }
            elseif (md5($password) != $row['password'])
            {
                throw new Exception('Email or Password is incorrect');
            }
            else
            {
                //login
                $_SESSION['sendSecretUser'] = $row;
            }
        }
        else
        {
            throw new Exception('User with this email does not exist');
        }
    }
}
?>