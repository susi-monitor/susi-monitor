<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
| SuSi Monitor configuration
| -------------------------------------------------------------------
| This file contains configuration parameters needed to customize
| your instance.
| -------------------------------------------------------------------
*/

//Base URL of your site - typically	http://example.com/ - provide with trailing slash
$config['base_url'] = '';

defined('RELEASE_VERSION')  OR define('RELEASE_VERSION', '1.4.0');

// Custom User Agent string
defined('UA_STRING')  OR define('UA_STRING', 'SuSi Monitor v'.RELEASE_VERSION);

// MITM protection - disabled by default - set "2" to enforce checks
defined('VERIFYHOST')  OR define('VERIFYHOST', 0);
defined('VERIFYPEER')  OR define('VERIFYPEER', 0);

//Administration panel access password
defined('ADMIN_PASSWORD')  OR define('ADMIN_PASSWORD', 'admin');

// Customized title
define('PAGE_TITLE', 'SuSi Monitor');

// Proxy settings
defined('PROXY_ENABLED')  OR define('PROXY_ENABLED', 0);
defined('PROXY_HOST')  OR define('PROXY_HOST', 'exampleproxy.local');
defined('PROXY_PORT')  OR define('PROXY_PORT', 8080);
defined('PROXY_CREDENTIALS')  OR define('PROXY_CREDENTIALS', "someuser:somepassword");


