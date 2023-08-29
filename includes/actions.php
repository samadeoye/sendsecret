<?php
require_once 'utils.php';

use SendSecret\Param\Param;

$action = isset($_REQUEST['action']) ? trim($_REQUEST['action']) : '';
if ($action == '')
{
    getJsonRow(false, 'Invalid request!');
}

$params = Param::getRequestParams($action);
doValidateApiParams($params);

try
{
    $data = [];
    $db->beginTransaction();

    switch($action)
    {
        case 'register':
            SendSecret\Auth\Register::registerUser();
        break;
    }

    $db->commit();
    getJsonRow(true, 'Operation successful!');
}
catch(Exception $ex)
{
	$db->rollBack();
    getJsonRow(false, $ex->getMessage());
}