<?php
namespace SendSecret\Duplicate;

use SendSecret\Crud\Crud;

class Duplicate
{
    //check if the value passed exists in the database
    public static function checkIfDuplicateExists($table, $key, $value)
    {
        $row = Crud::select(
            $table,
            [
                'columns' => 'id',
                'where' => [
                    $key => $value
                ],
                'limit' => 1
            ]
        );
        if ($row)
        {
            return true;
        }
        return false;
    }
}