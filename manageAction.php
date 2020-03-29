<?php

require_once('settings.php');

session_start();
if(empty($_SESSION["authenticated"]) || $_SESSION["authenticated"] != 'true') {
    header('Location: login.php');
}

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
            $conn = null;
            header('Location: admin.php');
        } catch (PDOException $e) {
            echo $e->getMessage();
        }

        break;
    case 'add':
        try {
            $dbh = new PDO(
                'mysql:host='.DB_HOST.';port='.DB_PORT.';dbname='.DB_NAME
                .'',
                DB_USER,
                DB_PASSWORD
            );
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            if (strlen($_POST['inputCategory']) < 1) {
                $category = null;
            } else {
                $category = $_POST['inputCategory'];
            }
            $data = [
                'name' => $_POST['inputName'],
                'url' => $_POST['inputURL'],
                'type' => $_POST['inputType'],
                'category' => $category
            ];
            $sql = 'INSERT INTO targets (name, url, type, category) VALUES (:name, :url, :type, :category)';
            $stmt= $dbh->prepare($sql);
            $stmt->execute($data);
            
            $conn = null;
            header('Location: admin.php');
        } catch (PDOException $e) {
            echo $e->getMessage();
        }

        break;
    case 'edit':
        try {
            $dbh = new PDO(
                'mysql:host='.DB_HOST.';port='.DB_PORT.';dbname='.DB_NAME
                .'',
                DB_USER,
                DB_PASSWORD
            );
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            if (strlen($_POST['inputCategory']) < 1) {
                $category = null;
            } else {
                $category = $_POST['inputCategory'];
            }

            $data = [
                'id' => $_GET['id'],
                'name' => $_POST['inputName'],
                'url' => $_POST['inputURL'],
                'type' => $_POST['inputType'],
                'category' => $category
            ];
            $sql = 'UPDATE targets SET name=:name, url=:url, type=:type, category=:category WHERE id=:id';
            $stmt= $dbh->prepare($sql);
            $stmt->execute($data);

            $conn = null;
            header('Location: admin.php');
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        break;
}

?>