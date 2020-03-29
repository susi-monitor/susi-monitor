<?php

require_once('settings.php');

session_start();
if(empty($_SESSION["authenticated"]) || $_SESSION["authenticated"] != 'true') {
    header('Location: login.php');
}

require_once ('templates/header.php');
?>

<main role="main">
    <div style="min-height: 100px;"></div>

    <div class="container">

        <div class="row">
            <h1>Monitored Services</h1>
            <table class="table table-hover">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">URL</th>
                    <th scope="col">type</th>
                    <th scope="col">Category</th>
                    <th scope="col">Actions</th>
                </tr>
                </thead>
                <tbody>

            <?php

            $orderNumber = 0;

            try {
                $dbh = new PDO(
                    'mysql:host='.DB_HOST.';port='.DB_PORT.';dbname='.DB_NAME
                    .'',
                    DB_USER,
                    DB_PASSWORD
                );
                $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $error) {
                echo 'Connection failed with error: '.$error->getMessage();
            }

            $stmt = $dbh->query('SELECT * FROM targets');
            $targets = $stmt->fetchAll();
            foreach ($targets as $target) {
                $orderNumber++;
                echo '<tr>
<th scope="row">'.$orderNumber.'</th>
      <td>'.$target['name'].'</td>
      <td>'.$target['url'].'</td>
      <td>'.$target['type'].'</td>
      <td>'.$target['category'].'</td>
      <td><a href="manage.php?action=edit&id='.$target['id'].'" alt="Edit entry">📝</a><br>
      <a href="manage.php?action=delete&id='.$target['id'].'" alt="Delete entry">🗑️</a></td>
      ';


                echo '
</p>
            </div><!-- /.col-lg-4 -->';
                $stmt = $dbh->prepare(
                    'SELECT * FROM data WHERE target_id = :target_id ORDER BY datetime DESC LIMIT 12'
                );
                $stmt->execute(['target_id' => $target['id']]);
                $targetData[$target['id']] = array_reverse($stmt->fetchAll());
            }

            $pdo = null;
            ?>
                </tbody>
            </table>
            <br>
            <a href="manage.php?action=add"><button type="button" class="btn btn-primary">➕ Add new</button></a>
        </div><!-- /.row -->

    </div><!-- /.container -->


    <?php
    require_once ('templates/header.php');
    ?>

</body>
</html>

