<?php
require_once '../includes/utils.php';

unset($_SESSION['sendSecretUser']);
session_destroy();

header('location: '.DEF_FULL_BASE_PATH_URL);