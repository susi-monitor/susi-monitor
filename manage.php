<?php

require_once('settings.php');

session_start();
if(empty($_SESSION["authenticated"]) || $_SESSION["authenticated"] != 'true') {
    header('Location: login.php');
}

function getTargetData($targetId)
{
    try {
        $dbh = new PDO(
            'mysql:host='.DB_HOST.';port='.DB_PORT.';dbname='.DB_NAME
            .'',
            DB_USER,
            DB_PASSWORD
        );
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $error) {
        die('Connection failed with error: '.$error->getMessage());
    }

    $stmt = $dbh->prepare(
        'SELECT * FROM targets WHERE id = :target_id LIMIT 1'
    );
    $stmt->execute(['target_id' => $targetId]);
    $data = $stmt->fetch();
    $dbh = null;

    return $data;
}
?>

<?php
require_once ('templates/header.php');
?>

<main role="main">
    <div style="min-height: 100px;"></div>

    <div class="container">

        <div class="row">
            <?php
            switch($_GET['action']){
                case 'edit':
                    $targetData = getTargetData($_GET['id']);
                   echo '<form method="post" action="manageAction.php?action=edit&id='.$_GET['id'].'">
                        <div class="form-group">
                            <label for="inputName">Name</label>
                            <input type="text" class="form-control" id="inputName" value="'.$targetData['name'].'" name="inputName" aria-describedby="nameHelp" maxlength="128" required>
                            <small id="emailHelp" class="form-text text-muted">Just a user-friendly name so that user knows what service is checked.</small>
                        </div>
                        <div class="form-group">
                            <label for="inputURL">URL</label>
                            <input type="url" class="form-control" id="inputURL" name="inputURL" value="'.$targetData['url'].'" aria-describedby="URLHelp" required>
                            <small id="URLHelp" class="form-text text-muted">URL of a resource that should be checked.</small>
                        </div>
                        <div class="form-group">
                            <label for="inputType">Type of check</label>
                            <select class="form-control" id="inputType" name="inputType" aria-describedby="inputTypeHelp" required>';
                   ?>

                                <option <?php if($targetData['type']=='default') echo 'selected="selected"'; ?> >default</option>
                                <option <?php if($targetData['type']=='json') echo 'selected="selected"'; ?> >json</option>
            <?php
                            echo '</select>
                            <small id="inputTypeHelp" class="form-text text-muted"><b>default</b> -> check if HTTP response happens and if is a success code
                                <br><b>json</b> -> same as above AND check if it is a valid JSON</small>
                        </div>
                        <div class="form-group">
                            <label for="inputCategory">Category (optional)</label>
                            <input type="text" class="form-control" id="inputCategory" aria-describedby="categoryHelp" name="inputCategory" maxlength="128" value="'.$targetData['category'].'">
                            <small id="categoryHelp" class="form-text text-muted">Match one of existing categories or add a new one.</small>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>';

                    break;
                case 'delete':
                    $targetData = getTargetData($_GET['id']);
                    echo 'Are you sure you want to delete <b>'.$targetData['name'].'</b>?&nbsp;&nbsp;
<a href="manageAction.php?action=delete&id='.$targetData['id'].'"><button>Yes</button></a>&nbsp;
<a href="admin.php"><button>No</button></a>';
                    break;
                case 'add':
                    ?>
                    <form method="post" action="manageAction.php?action=add">
                        <div class="form-group">
                            <label for="inputName">Name</label>
                            <input type="text" class="form-control" id="inputName" name="inputName" aria-describedby="nameHelp" maxlength="128" required>
                            <small id="emailHelp" class="form-text text-muted">Just a user-friendly name so that user knows what service is checked.</small>
                        </div>
                        <div class="form-group">
                            <label for="inputURL">URL</label>
                            <input type="url" class="form-control" id="inputURL" name="inputURL" aria-describedby="URLHelp" required>
                            <small id="URLHelp" class="form-text text-muted">URL of a resource that should be checked.</small>
                        </div>
                        <div class="form-group">
                            <label for="inputType">Type of check</label>
                            <select class="form-control" id="inputType" name="inputType" aria-describedby="inputTypeHelp" required>
                                <option>default</option>
                                <option>json</option>
                            </select>
                            <small id="inputTypeHelp" class="form-text text-muted"><b>default</b> -> check if HTTP response happens and if is a success code
                                <br><b>json</b> -> same as above AND check if it is a valid JSON</small>
                        </div>
                        <div class="form-group">
                            <label for="inputCategory">Category (optional)</label>
                            <input type="text" class="form-control" id="inputCategory" aria-describedby="categoryHelp" name="inputCategory" maxlength="128">
                            <small id="categoryHelp" class="form-text text-muted">Match one of existing categories or add a new one.</small>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
            <?php
                default:
                    break;
            }
            ?>
        </div><!-- /.row -->

    </div><!-- /.container -->

    <?php
    require_once ('templates/header.php');
    ?>

</body>
</html>

