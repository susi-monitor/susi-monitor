<!-- FOOTER -->
<footer class="container">
    <?php
    if (isset($targets) && !is_null($targets) && count(array_keys($targets)) > 3) {
        echo ' <p class="float-right"><button type="button" class="btn btn-secondary" onclick="scrollToTop()">Back to top</button></p>';
    }

    if (!isset($removeFooterLinks) || is_null($removeFooterLinks) && $removeFooterLinks === false){
        echo '<p><small><a href="https://github.com/greg-olszewski/susi-monitor" target="_blank">SuSi Monitor
                v'.RELEASE_VERSION.' </a>&nbsp;|&nbsp; All times are in '.date('T').'.&nbsp; | &nbsp;<a href="'.site_url('admin/').'">Administration</a></small></p>';
    }
        ?>

</footer>
</main>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<script>window.jQuery || document.write('<script src="https://getbootstrap.com/docs/4.4/assets/js/vendor/jquery.slim.min.js"><\/script>')</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
<!-- Handling the uptime/response time toggle -->
<script type="text/javascript">
    $(function () {
        $('#responseTimeToggle').change(function () {
            if ($(this).prop('checked') == true) {
                document.cookie = "showResponseTimes=yes";
                location.reload();
            } else {
                document.cookie = "showResponseTimes=no";
                location.reload();
            }
        })
    })
</script>
<!-- Scroll back to top script -->
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
if (isset($showResponseTimes) && $showResponseTimes === true && !empty($target_data)) {
    foreach ($target_data as $key => $data) {
        $dataReversed = array_reverse($data);

        $labels = '';
        $values = '';
        foreach ($dataReversed as $check) {
            $formattedDate = date('d/m/y H:i', $check['datetime']);
            $labels .= ",'".$formattedDate."'";
            $values .= ','.$check['response_time'];
        }
        $lastValueItem = end($dataReversed);

        if ($lastValueItem['status'] === '0' && $lastValueItem['response_time'] > 0) {
            $backgroundColor = 'rgb(246,227,28)';
            $borderColor = 'rgb(198,183,22)';
        } elseif ($lastValueItem['response_time'] == 0) {
            $backgroundColor = 'rgb(194,45,45)';
            $borderColor = 'rgb(87,9,9)';
        } else {
            $backgroundColor = 'rgb(100,171,100)';
            $borderColor = 'rgb(40,167,69)';
        }
        echo "<script>var ctx = document.getElementById('uptimechart-target".$check['target_id']."').getContext('2d');
    var chart = new Chart(ctx, {
        type: 'line',

        data: {
            labels: [".$labels."],
            datasets: [{
                label: 'Response time [s]',
                backgroundColor: '".$backgroundColor."',
                borderColor: '".$borderColor."',
                data: [".$values."]
            }]
        },

        // Configuration options go here
        options: {
            legend: {
                display: false
            },
        }
    });</script>";
    }
} elseif (!empty($target_data)) {
    foreach ($target_data as $key => $data) {
        $dataReversed = array_reverse($data);

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