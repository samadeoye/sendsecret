<?php
if(DEF_IS_PRODUCTION)
{
    $serverName = "localhost";
    $dbName = "cstvcom_sendsecret";
    $userName = "cstvcom_sendsecret";
    $password = "48uO?6gE}E9F";
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