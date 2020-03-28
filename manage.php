<?php

require_once('settings.php');

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

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="SuSi Monitor">
    <meta name="author" content="Grzegorz Olszewski <grzegorz@olszewski.in>">
    <title><?= PAGE_TITLE ?></title>

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
          rel="stylesheet">

    <!-- Favicons TO DO-->

    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>
    <!-- Custom styles -->
    <link href="susi.css" rel="stylesheet">
</head>
<body>
<header>
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <a class="navbar-brand" href="index.php#"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse"
                data-target="#navbarCollapse" aria-controls="navbarCollapse"
                aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="index.php#">Uptime status</a>
                </li>
            </ul>
        </div>
    </nav>
</header>

<main role="main">
    <div style="min-height: 100px;"></div>

    <div class="container">

        <div class="row">
            <?php
            switch($_GET['action']){
                case 'edit':
                    //TODO: Implement editing

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


    <!-- FOOTER -->
    <footer class="container">
        <p class="float-right"><a href="index.php#">Back to top</a></p>
        <p><small><a href="https://github.com/greg-olszewski/susi-monitor">SuSi Monitor
                    v<?php echo RELEASE_VERSION; ?> </a>&nbsp; All times are in <?php echo date('T') ?> .</small></p>
    </footer>
</main>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<script>window.jQuery || document.write('<script src="https://getbootstrap.com/docs/4.4/assets/js/vendor/jquery.slim.min.js"><\/script>')</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>

</body>
</html>

