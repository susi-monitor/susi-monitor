<?php

require_once('settings.php');

require_once ('templates/header.php');
?>



<main role="main">
    <div style="min-height: 50px;"></div>

    <!-- Uptime boxes
    ================================================== -->
    <!-- Wrap the rest of the page in another container to center all the content. -->

    <div class="container uptime">

        <div class="row">
<h1>Last 24 hours</h1>
            <?php

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


                $stmt = $dbh->prepare(
                    'SELECT * FROM targets WHERE id = :id'
                );
                $stmt->execute(['id' => urldecode($_GET['id'])]);

            $targets = $stmt->fetchAll();
            foreach ($targets as $target) {
                echo '<div class="col-lg-12" style="border: 1px solid #80808024;padding-top: 10px;">
                <canvas id="uptimechart-target'.$target['id'].'"></canvas>
                <h2>'.$target['name'].'</h2>
                <hr>
            <p>
              </p>
<p><b>URL:&nbsp;</b>'.$target['url'].'</p>

                <p>';

                $stmt = $dbh->prepare(
                    'SELECT * FROM data WHERE target_id = :target_id ORDER BY datetime DESC LIMIT 1'
                );
                $stmt->execute(['target_id' => $target['id']]);
                $lastRow = $stmt->fetch();

                // last status check
                if ($lastRow !== false && $lastRow['status'] == 1) {
                    echo '<p><b>Last known status:&nbsp;</b>UP</p>';
                } else {
                    echo '<p><b>Last known status:&nbsp;</b>DOWN</p>';
                }
echo '<button type="button" class="btn btn-secondary" onclick="location.href = \'index.php\';">Back</button>';

                echo '
</p>
            </div><!-- /.col-lg-4 -->';
                //get last 24 hours
                $stmt = $dbh->prepare(
                    'SELECT * FROM data WHERE target_id = :target_id ORDER BY datetime DESC LIMIT 288'
                );
                $stmt->execute(['target_id' => $target['id']]);
                $targetData[$target['id']] = array_reverse($stmt->fetchAll());
            }

            $pdo = null;
            ?>
        </div><!-- /.row -->

    </div><!-- /.container -->

    <?php
    require_once('templates/footer.php');
    ?>

    <?php
    foreach ($targetData as $key => $data) {
        $labels = '';
        $values = '';
        foreach ($data as $check) {
            $formattedDate = date('d/m/y H:i', $check['datetime']);
            $labels .= ",'".$formattedDate."'";
            $values .= ','.$check['status'];
        }
        $valuesWithLabels = str_replace(
            '1',
            '"UP"',
            str_replace('0', '"DOWN"', $values)
        );
        echo "<script>var ctx = document.getElementById('uptimechart-target".$key."').getContext('2d');
    var chart = new Chart(ctx, {
        type: 'line',

        data: {
            labels: [".$labels."],
            datasets: [{
                label: 'status',
                backgroundColor: 'rgb(34,146,255)',
                borderColor: 'rgb(34,146,255)',
                data: [".$valuesWithLabels."]
            }]
        },

        // Configuration options go here
        options: {
            legend: {
                display: false
            },
            scales: {
            yAxes: [{
                type: 'category',
                labels: ['UP', 'DOWN'],
                 ticks: {
                    min: 'UP'
                }
            }]
        }
        }
    });</script>";
    }
    ?>
    </body>
    </html>

