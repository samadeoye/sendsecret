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
    $httpHost = 'http://'.$httpHost;
    $isProductionServer = false;
}
$fullPathUrl = $httpHost . $httpFolderPath;
define('DEF_FULL_BASE_PATH_URL', $fullPathUrl);
define('DEF_DOC_ROOT', $_SERVER['DOCUMENT_ROOT'] .'/'. $httpFolderPath . '/');
define('DEF_IS_PRODUCTION', $isProductionServer);

require_once DEF_DOC_ROOT.'vendor/autoload.php';
require_once DEF_DOC_ROOT.'includes/functions.php';
require_once DEF_DOC_ROOT.'/includes/connect.php';

if(isset($_SESSION['user']))
{
    //get the logged-in user session
    $arUser = getUserSession();
    $userId = $arUser['id'];
}

$arAdditionalCSS = $arAdditionalJs = $arAdditionalJsOnLoad = [];