<?php

define('DB_HOST', 'localhost');
define('DB_PORT', '3306');
define('DB_USER', 'yourUserNameHere');
define('DB_PASSWORD', 'yourPasswordHere');
define('DB_NAME', 'susi');

// Customized title
define('PAGE_TITLE', 'SuSi Monitor');

define('RELEASE_VERSION', '0.2.0');
//custom User Agent string
define('UA_STRING', 'SuSi Monitor v'.RELEASE_VERSION);

//proxy settings
define('PROXY_ENABLED', 0);
define('PROXY_HOST', 'exampleproxy.local');
define('PROXY_PORT', 8080);
define('PROXY_CREDENTIALS', "someuser:somepassword");