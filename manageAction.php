<?php

require_once('settings.php');

$action = $_GET['action'];
$targetId = $_GET['id'];

switch ($_GET['action']) {
    case 'delete':
        try {
            $dbh = new PDO(
                'mysql:host='.DB_HOST.';port='.DB_PORT.';dbname='.DB_NAME
                .'',
                DB_USER,
                DB_PASSWORD
            );
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $dbh->prepare(
                'DELETE FROM targets WHERE id = :target_id'
            );
            $stmt->execute(['target_id' => $targetId]);

            $stmt = $dbh->prepare(
                'DELETE FROM data WHERE target_id = :target_id'
            );
            $stmt->execute(['target_id' => $targetId]);

            header('Location: admin.php');
        } catch (PDOException $e) {
            echo $e->getMessage();
        }

        $conn = null;
        break;
}

?>