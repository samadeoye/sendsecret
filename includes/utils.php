<?php
session_start();
require_once 'constants.php';

$httpHost = $_SERVER['HTTP_HOST'];
$httpFolderPath = '';
$isProductionServer = true;
if ($httpHost == 'localhost')
{
    //LOCAL
    $httpFolderPath = '/'.PROJECT_FOLDER;
    $isProductionServer = false;
}
define('DEF_ROOT_PATH', $httpFolderPath);
define('DEF_DOC_ROOT', $_SERVER['DOCUMENT_ROOT'] .'/'. $httpFolderPath . '/');
define('DEF_FULL_ROOT_PATH', $httpHost.$httpFolderPath);
define('DEF_IS_PRODUCTION', $isProductionServer);

require_once DEF_DOC_ROOT.'vendor/autoload.php';
require_once DEF_DOC_ROOT.'includes/functions.php';
require_once DEF_DOC_ROOT.'includes/connect.php';

if (isset($_SESSION['sendSecretUser']))
{
    //get the logged-in user session
    $arUser = getUserSession();
    $userId = $arUser['id'];
}

$arAdditionalCSS = $arAdditionalJsFunctions = $arAdditionalJsScript = $arAdditionalJsOnLoad = [];