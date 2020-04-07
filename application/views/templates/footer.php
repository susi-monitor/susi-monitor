<!-- FOOTER -->
<footer class="container">
    <p class="float-right"><button type="button" class="btn btn-secondary" onclick="scrollToTop()">Back to top</button></p>
    <p><small><a href="https://github.com/greg-olszewski/susi-monitor" target="_blank">SuSi Monitor
                v<?php echo RELEASE_VERSION; ?> </a>&nbsp;|&nbsp; All times are in <?php echo date('T') ?>.&nbsp; | &nbsp;<a href="<?php echo site_url('admin/'); ?>">Administration</a></small></p>
</footer>
</main>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<script>window.jQuery || document.write('<script src="https://getbootstrap.com/docs/4.4/assets/js/vendor/jquery.slim.min.js"><\/script>')</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript">
    function scrollToTop() {
        if ('scrollRestoration' in history) {
            history.scrollRestoration = 'manual';
        }
        window.scrollTo(0, 0);
    }
</script>
<!-- graph data here if property with data provided -->
<?php
if (!empty($target_data)) {
    foreach ($target_data as $key => $data) {
        $dataReversed = array_reverse($data);
        print_r($dataReversed);
        $labels = '';
        $values = '';
        foreach ($dataReversed as $check) {
            $formattedDate = date('d/m/y H:i', $check['datetime']);
            $labels .= ",'".$formattedDate."'";
            $values .= ','.$check['status'];
        }
        $valuesWithLabels = str_replace(
            '1',
            '"UP"',
            str_replace('0', '"DOWN"', $values)
        );
        echo "<script>var ctx = document.getElementById('uptimechart-target".$check['target_id']."').getContext('2d');
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
}
?>
</body>
</html>