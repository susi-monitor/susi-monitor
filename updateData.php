<?php

require_once('settings.php');

function getListOfTargets($dbh)
{
    $stmt = $dbh->prepare('SELECT * FROM targets');
    $stmt->execute();

    return $stmt->fetchAll();
}

function callURL($url, $returnHTTPCode = false)
{
    $handle = curl_init();
    curl_setopt($handle, CURLOPT_URL, $url);
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($handle,CURLOPT_USERAGENT,UA_STRING);

    $output = curl_exec($handle);
    curl_close($handle);

    if ($returnHTTPCode === true) {
        if (!curl_errno($handle)) {
            $output = curl_getinfo($handle, CURLINFO_RESPONSE_CODE);
        } else {
            $output = curl_errno($handle);
        }
    }

    return $output;
}

function checkTargets($dbh, $listOfTargets)
{
    foreach ($listOfTargets as $target) {
        switch ($target['type']) {
            case 'json':
                //check if the URL serves proper JSON
                $output = callURL($target['url']);
                if (json_decode($output, true)) {
                    insertData($dbh, $target['id'], 1);
                } else {
                    insertData($dbh, $target['id'], 0);
                }
                break;
            default:
                //check if the URL is alive
                $HTTPCode = callURL($target['url'], true);
                if ($HTTPCode == 200) {
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
