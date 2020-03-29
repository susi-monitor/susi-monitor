<!-- FOOTER -->
<footer class="container">
    <p class="float-right"><button type="button" class="btn btn-secondary" onclick="scrollToTop()">Back to top</button></p>
    <p><small><a href="https://github.com/greg-olszewski/susi-monitor" target="_blank">SuSi Monitor
                v<?php echo RELEASE_VERSION; ?> </a>&nbsp;|&nbsp; All times are in <?php echo date('T') ?>.&nbsp; | &nbsp;<a href="admin.php">Administration</a></small></p>
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