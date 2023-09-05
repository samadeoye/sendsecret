<?php
require_once '../includes/utils.php';

//unset and destroy the user session then redirect to landing page
unset($_SESSION['sendSecretUser']);
session_destroy();

header('location: '.DEF_ROOT_PATH.'/');