<?php
namespace SendSecret\User;

use SendSecret\Crud\Crud;
use Exception;
use SendSecret\Mail\SendMail;

class User
{
    static $table = DEF_TBL_USERS;
    static $tablePasswordReset = DEF_TBL_PASSWORD_RESET;
    static $data = [];
    public static function getUser($id, $arFields=['*'])
    {
        $fields = is_array($arFields) ? implode(',', $arFields) : $arFields;
        return Crud::select(
            self::$table,
            [
                'columns' => $fields,
                'where' => [
                    'id' => $id
                ]
            ]
        );
    }

    public static function updateUser()
    {
        global $userId;

        $fname = stringToUpper(trim($_REQUEST['fname']));
        $lname = stringToUpper(trim($_REQUEST['lname']));

        $data = [
            'first_name' => $fname,
            'last_name' => $lname
        ];
        $update = Crud::update(
            self::$table,
            $data,
            ['id' => $userId]
        );
        if ($update)
        {
            $row = array_merge($_SESSION['user'], $data);
            $_SESSION['user'] = $row;
            self::$data = $data;
        }
        else
        {
            throw new Exception('An error occured while updating your profile. Please try again.');
        }
    }

    public static function changePassword()
    {
        global $arUser;

        $oldPassword = trim($_REQUEST['oldPassword']);
        $newPassword = trim($_REQUEST['newPassword']);
        $passwordConfirm = trim($_REQUEST['passwordConfirm']);

        if ($newPassword != $passwordConfirm)
        {
            throw new Exception('Passwords do not match');
        }
        if (md5($oldPassword) != $arUser['password'])
        {
            throw new Exception('Old password is incorrect');
        }

        $newPassword = md5($newPassword);
        $update = Crud::update(
            self::$table,
            ['password' => $newPassword],
            ['id' => $arUser['id']]
        );
        if ($update)
        {
            $_SESSION['user']['password'] = $newPassword;
        }
        else
        {
            throw new Exception('An error occured while updating your password. Please try again.');
        }
    }

    public static function sendPasswordResetEmail()
    {
        $email = strtolower(trim($_REQUEST['email']));

        $row = Crud::select(
            self::$table,
            [
                'columns' => 'first_name, last_name',
                'where' => [
                    'email' => $email
                ]
            ]
        );
        if ($row)
        {
            //send password reset email
            $token = uniqid();
            $name = $row['fname'] .' '. $row['lname'];
            $siteName = SITE_NAME;
            $siteUrl = SITE_URL;

            $body = <<<EOQ
                Dear {$row['fname']},<br>
                Use the link below to complete your password reset on {$siteName}.<br>
                <a href="{$siteUrl}/auth/resetpassword?token={$token}">Reset Password</a>

EOQ;

            $arParams = [
                'mailTo' => $email,
                'toName' => $name,
                'mailFrom' => SITE_MAIL_FROM_EMAIL,
                'fromName' => SITE_MAIL_FROM_NAME,
                'isHtml' => true,
                'bodyHtml' => $body
            ];
            SendMail::sendMail($arParams);
            if (SendMail::$isSent)
            {
                $data = [
                    'email' => $email,
                    'token' => $token,
                    'cdate' => time()
                ];
                Crud::insert(self::$tablePasswordReset, $data);
            }
            else
            {
                throw new Exception('An error occured. Please try again.');
            }
        }
        else
        {
            throw new Exception('This email does not exist on the system');
        }
    }

    public static function resetPassword()
    {
        $token = trim($_REQUEST['token']);
        $newPassword = trim($_REQUEST['newPassword']);
        $passwordConfirm = trim($_REQUEST['passwordConfirm']);

        if ($newPassword != $passwordConfirm)
        {
            throw new Exception('Passwords do not match!');
        }

        //check if a log entry exist with the token and email
        $row = Crud::select(
            self::$tablePasswordReset,
            [
                'columns' => 'email',
                'where' => [
                    'id' => $token
                ],
                'order' => 'cdate DESC',
                'limit' => 1
            ]
        );

        if ($row)
        {
            Crud::update(
                self::$table,
                ['password' => md5($newPassword)],
                ['email' => $row['email']]
            );
            //delete password reset log
            Crud::delete(self::$tablePasswordReset, ['email' => $row['email']]);
        }
        else
        {
            throw new Exception('Token is invalid. Please click the link from your email.');
        }
    }
}