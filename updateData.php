<?php

require_once('settings.php');

function getListOfTargets($dbh)
{
    $stmt = $dbh->prepare('SELECT * FROM targets');
    $stmt->execute();

    return $stmt->fetchAll();
}

function checkTargets($dbh, $listOfTargets)
{
    foreach ($listOfTargets as $target) {
        switch ($target['type']) {
            //check if the URL serves proper JSON
            case 'json':
                if (json_decode(file_get_contents($target['url']), true)) {
                    insertData($dbh, $target['id'], 1);
                } else {
                    insertData($dbh, $target['id'], 0);
                }
                break;
            default:
                //check if the URL is alive
                if (file_get_contents($target['url'])) {
                    insertData($dbh, $target['id'], 1);
                } else {
                    insertData($dbh, $target['id'], 0);
                }
                break;
        }
    }
    return true;
}

function insertData($dbh, $targetId, $status)
{
    $sql = 'INSERT INTO data (target_id, status, datetime) VALUES (?,?,?)';
    $stmt = $dbh->prepare($sql);
    $stmt->execute([$targetId, $status, date('U')]);
}

try {
    $dbh = new PDO(
        'mysql:host='.DB_HOST.';port='.DB_PORT.';dbname='.DB_NAME.'',
        DB_USER,
        DB_PASSWORD
    );
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $error) {
    echo 'Connection failed with error: '.$error->getMessage();
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
