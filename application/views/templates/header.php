<?php
if (isset($verifyLogin) && !empty($verifyLogin) && $verifyLogin === true){
    session_start();
    if(empty($_SESSION["authenticated"]) || $_SESSION["authenticated"] != 'true') {
        header('Location: '.site_url('/admin/login'));
    }

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
    <title><?php echo $title; ?></title>

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
          rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css"
          rel="stylesheet">

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
    <link href="<?php echo site_url('/'); ?>susi.css" rel="stylesheet">
    <!--Favicons-->
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo site_url('/'); ?>img/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo site_url('/'); ?>img/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo site_url('/'); ?>img/favicon-16x16.png">
    <link rel="manifest" href="<?php echo site_url('/'); ?>img/site.webmanifest">
    <link rel="mask-icon" href="<?php echo site_url('/'); ?>img/safari-pinned-tab.svg" color="#5bbad5">
    <link rel="shortcut icon" href="<?php echo site_url('/'); ?>img/favicon.ico">
    <meta name="msapplication-TileColor" content="#00a300">
    <meta name="msapplication-config" content="<?php echo site_url('/'); ?>img/browserconfig.xml">
    <meta name="theme-color" content="#ffffff">

</head>
<body>
<header style="min-height: 20px !important;">
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <a class="navbar-brand" href="<?php echo site_url(''); ?>"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse"
                data-target="#navbarCollapse" aria-controls="navbarCollapse"
                aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="<?php echo site_url(''); ?>">Service monitor</a>
                </li>
            </ul>
        </div>
        <style>
            .toggle.susi, .toggle-on.susi, .toggle-off.susi {
                max-height: 1.5rem;
                min-width: 9rem;
            }
        </style>
        <?php
        if (!isset($hideResponseTimeToggle)
            || $hideResponseTimeToggle === false
        ) {
            echo '
        <input name="responseTimeToggle"
            ';
            if (isset($showResponseTimes) && $showResponseTimes === true) {
                echo 'checked';
            }
            echo '
               id="responseTimeToggle" type="checkbox" data-toggle="toggle"
               data-on="Response times" data-off="Just uptime"
               data-onstyle="success" data-offstyle="secondary"
               data-style="susi">
           ';
        }
        ?>
    </nav>
</header>