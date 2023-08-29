<?php
namespace Lamba\Auth;

use Exception;
use Lamba\Crud\Crud;
use Lamba\User\User;

class Login
{
    static $table = DEF_TBL_USERS;
    public static function loginUser()
    {
        $email = trim($_REQUEST['email']);
        $password = trim($_REQUEST['password']);

        //check if a user exists with the email
        $rs = Crud::select(
            self::$table,
            [
                'columns' => getUserSessionFields(),
                'where' => [
                    'email' => $email,
                    'deleted' => 0
                ]
            ]
        );
        if ($rs)
        {
            if ($rs['status'] != 1)
            {
                throw new Exception('Your account is disabled. Please contact the admin.');
            }
            elseif (md5($password) != $rs['password'])
            {
                throw new Exception('Email or Password is incorrect');
            }
            else
            {
                //login
                $_SESSION['user'] = $rs;
            }
        }
        else
        {
            throw new Exception('User with this email does not exist');
        }
    }
}
?>