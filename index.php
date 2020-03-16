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
    <title>SuSi Monitor</title>

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

    <div class="container uptime">

        <div class="row">
            <div class="col-lg-4">
                <canvas id="uptimechart-target0"></canvas>
                <h2>Example domain</h2>
                <p><a href="https://example.com">https://example.com</a></p>
                <p><a class="btn btn-success"
                      role="button">UP </a></p>
            </div><!-- /.col-lg-4 -->
        </div><!-- /.row -->

    </div><!-- /.container -->


    <!-- FOOTER -->
    <footer class="container">
        <p class="float-right"><a href="index.php#">Back to top</a></p>
        <p><a href="https://github.com/greg-olszewski/susi-monitor">SuSi Monitor v0.1 </a></p>
    </footer>
</main>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<script>window.jQuery || document.write('<script src="https://getbootstrap.com/docs/4.4/assets/js/vendor/jquery.slim.min.js"><\/script>')</script>
<script src="js/bootstrap.bundle.min.js"
        integrity="sha384-6khuMg9gaYr5AxOqhkVIODVIvm9ynTT5J4V1cfthmT+emCG6yVmEZsRHdxlotUnm"
        crossorigin="anonymous"></script>
<script>
    var ctx = document.getElementById('uptimechart-target0').getContext('2d');
    var chart = new Chart(ctx, {
        type: 'line',

        data: {
            labels: ['08:00', '08:05', '08:10', '08:15', '08:20', '08:25', '08:30'],
            datasets: [{
                label: 'uptime',
                backgroundColor: 'rgb(34,146,255)',
                borderColor: 'rgb(34,146,255)',
                data: [0, 1, 1, 0, 1, 1, 1]
            }]
        },

        // Configuration options go here
        options: {}
    });
</script>
</body>
</html>

