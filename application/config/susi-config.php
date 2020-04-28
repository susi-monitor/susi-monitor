<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once ('susi-version.php');

/*
| -------------------------------------------------------------------
| SuSi Monitor configuration
| -------------------------------------------------------------------
| This file contains configuration parameters needed to customize
| your instance.
| -------------------------------------------------------------------
*/

/*
| -------------------------------------------------------------------
| Customization
| -------------------------------------------------------------------
*/

/* Base URL of your site - typically http://example.com/ - provide with trailing slash
This value HAS TO be set if you wish to use a domain name */
defined('BASEURL')  OR define('BASEURL', '');

/* Administration panel access password */
defined('ADMIN_PASSWORD')  OR define('ADMIN_PASSWORD', 'admin');

/* Customized title */
define('PAGE_TITLE', 'SuSi Monitor');

/*
| -------------------------------------------------------------------
| Notifications
| -------------------------------------------------------------------
*/

/* Will not show option to enable notifications for target if set to false */
defined('NOTIFICATIONS_ENABLED')  OR define('NOTIFICATIONS_ENABLED', false);

/* Webhook URL for Microsoft Teams
  Instruction on how to obtain that: https://docs.microsoft.com/en-us/microsoftteams/platform/webhooks-and-connectors/how-to/add-incoming-webhook */
defined('TEAMS_WEBHOOK_URL')  OR define('TEAMS_WEBHOOK_URL', '');

/*
| -------------------------------------------------------------------
| Connection and client parameters
| -------------------------------------------------------------------
*/

/* Custom User Agent string */
defined('UA_STRING')  OR define('UA_STRING', 'SuSi Monitor v'.RELEASE_VERSION);

/* Proxy settings */
defined('PROXY_ENABLED')  OR define('PROXY_ENABLED', 0);
defined('PROXY_HOST')  OR define('PROXY_HOST', 'exampleproxy.local');
defined('PROXY_PORT')  OR define('PROXY_PORT', 8080);
defined('PROXY_CREDENTIALS')  OR define('PROXY_CREDENTIALS', 'someuser:somepassword');

/* MITM protection - disabled by default - set "2" to enforce checks */
defined('VERIFYHOST')  OR define('VERIFYHOST', 0);
defined('VERIFYPEER')  OR define('VERIFYPEER', 0);
