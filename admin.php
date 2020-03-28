<?php

require_once('settings.php');
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

    <!-- Uptime boxes
    ================================================== -->
    <!-- Wrap the rest of the page in another container to center all the content. -->

    <div class="container">

        <div class="row">
            <h1>Monitored Services</h1>
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">URL</th>
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
      <td>'.$target['category'].'</td>
      <td><a href="manage.php?action=edit&id="'.$target['id'].' alt="Edit entry">📝</a><br>
      <a href="manage.php?action=delete&id="'.$target['id'].' alt="Delete entry">🗑️</a></td>';


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

