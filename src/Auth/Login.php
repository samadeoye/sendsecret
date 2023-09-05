<?php
namespace SendSecret\Auth;

use Exception;
use SendSecret\Crud\Crud;

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
            //check that account is not disabled
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
                //create a new user session
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