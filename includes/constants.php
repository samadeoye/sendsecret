<?php
define('SITE_NAME', 'SendSecret');
define('SITE_URL', 'http://localhost/sendsecret');
define('SITE_MAIL', 'mail@sendsecret.com');
define('PROJECT_FOLDER', 'sendsecret');
define('SITE_MAIL_FROM_EMAIL', SITE_MAIL);
define('SITE_MAIL_FROM_NAME', SITE_NAME);
define('SITE_ABR', 'SNDSEC');

//TABLES
define('DEF_TBL_USERS', 'users');
define('DEF_TBL_PASSWORD_RESET', 'password_reset');
define('DEF_TBL_MESSAGES', 'messages');

define('DEF_MESSAGE_SECRET_KEY', '3b6462u43i7h4-32k6-1]=0-nevwtwohqwhiepuv3rgy9854gjt099k');
define('DEF_MESSAGE_ENCRYPTION_METHOD', 'aes-256-cbc-hmac-sha1');
?>