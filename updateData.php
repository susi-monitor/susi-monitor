<?php

require_once('settings.php');

function getListOfTargets($dbh)
{
    $stmt = $dbh->prepare('SELECT * FROM targets');
    $stmt->execute();

    return $stmt->setFetchMode(PDO::FETCH_ASSOC);
}

function checkTargets($dbh, $listOfTargets)
{
}

try {
    $dbh = new PDO(
        'mysql:host='.DB_HOST.';port='.DB_PORT.';dbname='.DB_NAME.'',
        DB_USER,
        DB_PASSWORD
    );
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $error) {
    echo "Connection failed: ".$error->getMessage();
}

$targets = getListOfTargets($dbh);
$result = checkTargets($dbh, $targets);
$pdo = null;
if ($result) {
    echo 'OK';
} else {
    echo 'ERROR';
}
exit();
