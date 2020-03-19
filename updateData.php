<?php

require_once('settings.php');

function getListOfTargets($dbh)
{
    $stmt = $dbh->prepare('SELECT * FROM targets');
    $stmt->execute();

    return $stmt->fetchAll();
}

function callURL($url, $returnHTTPCode = false, $checkIfJSONContentType = false)
{
    $handle = curl_init();
    curl_setopt($handle, CURLOPT_URL, $url);
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($handle, CURLOPT_USERAGENT, UA_STRING);

    if (PROXY_ENABLED == 1) {
        curl_setopt($handle, CURLOPT_HTTPPROXYTUNNEL, PROXY_ENABLED);
        curl_setopt($handle, CURLOPT_PROXY, PROXY_HOST);
        curl_setopt($handle, CURLOPT_PROXYPORT, PROXY_PORT);
        curl_setopt($handle, CURLOPT_PROXYUSERPWD, PROXY_CREDENTIALS);
    }

    $output = curl_exec($handle);

    if ($returnHTTPCode === true) {
        if (!curl_errno($handle)) {
            $output = curl_getinfo($handle, CURLINFO_RESPONSE_CODE);
        } else {
            $output = curl_errno($handle);
        }
        print_r($output);
    }

    if ($checkIfJSONContentType === true) {
        $contentType = curl_getinfo($handle, CURLINFO_CONTENT_TYPE);
        print_r($contentType);
        if (strpos($contentType, 'json') === false) {
            return false;
        }
    }
    curl_close($handle);

    return $output;
}

function checkTargets($dbh, $listOfTargets)
{
    foreach ($listOfTargets as $target) {
        switch ($target['type']) {
            case 'json':
                //check if the URL serves proper JSON
                $output = callURL($target['url'], false, true);
                if (json_decode($output, true)) {
                    insertData($dbh, $target['id'], 1);
                } else {
                    insertData($dbh, $target['id'], 0);
                }
                break;
            default:
                //check if the URL is alive
                $HTTPCode = callURL($target['url'], true);
                if (in_array($HTTPCode, ['200', '301', '302'], false)) {
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
