<?php

require_once('settings.php');

function getListOfTargets($dbh)
{
}

function checkTargets($dbh, $listOfTargets)
{
}

$dbh = new PDO(
    'mysql:host='.DB_HOST.';port='.DB_PORT.';dbname='.DB_NAME.'',
    DB_USER,
    DB_PASSWORD
);

$targets = getListOfTargets($dbh);
$result = checkTargets($dbh, $targets);
$pdo = null;
if ($result) {
    echo 'OK';
}else{
    echo 'ERROR';
}
exit();
