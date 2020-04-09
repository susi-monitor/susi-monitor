<div class="container uptime">

    <div class="row">
        <h1>Last 24 hours</h1>
        <?php

            echo '<div class="col-lg-12" style="border: 1px solid #80808024;padding-top: 10px;">
                <canvas id="uptimechart-target'.$target['id'].'"></canvas>
                <h2>'.$target['name'].'</h2>
                <hr>
            <p>
              </p>
<p><b>URL:&nbsp;</b>'.$target['url'].'</p>

                <p>';


        $reversedTargetData = array_reverse($target_data[$target['id']]);
        $lastRow = array_pop($reversedTargetData);

            // last status check
            if ($lastRow !== false && $lastRow['status'] == 1) {
                echo '<p><b>Last known status:&nbsp;</b>UP</p>';
            } else {
                echo '<p><b>Last known status:&nbsp;</b>DOWN</p>';
            }
            echo '<button type="button" class="btn btn-secondary" onclick="location.href = \'../\';">Back</button>';

            echo '
</p>
            </div><!-- /.col-lg-4 -->';


        ?>
    </div><!-- /.row -->

</div><!-- /.container -->

