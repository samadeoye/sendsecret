<?php
namespace SendSecret\User;

use Exception;
use SendSecret\Crud\Crud;

class User
{
    static $table = DEF_TBL_USERS;
    public static function checkIfUserExists($field, $value)
    {
        $rs = Crud::select(
            self::$table,
            [
                'columns' => 'id',
                'where' => [
                    $field => $value
                ]
            ]
        );
        if ($rs)
        {
            return true;
        }
        return false;
    }
}