<?php
require_once 'utils.php';

use SendSecret\Param\Param;
use SendSecret\User\User;

$action = isset($_REQUEST['action']) ? trim($_REQUEST['action']) : '';
if ($action == '')
{
    getJsonRow(false, 'Invalid request!');
}

$params = Param::getRequestParams($action);
doValidateRequestParams($params);

try
{
    $data = [];
    $db->beginTransaction();

    switch($action)
    {
        case 'register':
            SendSecret\Auth\Register::registerUser();
        break;
        case 'login':
            SendSecret\Auth\Login::loginUser();
        break;
        case 'updateProfile':
            User::updateUser();
            $row = User::$data;
            if (count($row) > 0)
            {
                $data = $row;
            }
        break;
        case 'changePassword':
            User::changePassword();
        break;
        case 'forgotPassword':
            User::sendPasswordResetEmail();
        break;
        case 'resetPassword':
            User::resetPassword();
        break;
    }

    $db->commit();
    if (count($data) > 0)
    {
        $datax = [
            'status' => true,
            'data' => $data
        ];
        getJsonList($datax);
    }
    getJsonRow(true, 'Operation successful!');
}
catch(Exception $ex)
{
	$db->rollBack();
    getJsonRow(false, $ex->getMessage());
}