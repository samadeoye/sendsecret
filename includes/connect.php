<?php
if(DEF_IS_PRODUCTION)
{
    $serverName = "";
    $dbName = "";
    $userName = "";
    $password = "";
}
else
{
    //LOCAL
    $serverName = "localhost";
    $dbName = "sendsecret";
    $userName = "root";
    $password = "";
}

try
{
    $db = new PDO("mysql:host=$serverName;dbname=$dbName", $userName, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e)
{
    echo "Connection failed: " . $e->getMessage();
    exit;
}
?>