<div class="container uptime">

    <div class="row">
<?php foreach ($targets as $target): ?>
    <div class="col-lg-4" style="border: 1px solid #80808024;padding-top: 10px;">
    <canvas id="uptimechart-target<?php echo $target['id']; ?>"></canvas>
    <h2><?php echo $target['name']; ?></h2>
    <hr>
    <p>

        <button type="button" class="btn btn-secondary" onclick="location.href = '<?php echo site_url('details/'.$target['id']); ?>';">🔍&nbsp;Last 24 hrs</button>
    </p>
    <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#urlModal<?php echo $target['id']; ?>"">🌎&nbsp;URL</button>
    </p>
    <!-- URL modal -->
    <div class="modal fade" id="urlModal<?php echo $target['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="urlModal<?php echo $target['id']; ?>Label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="urlModal<?php echo $target['id']; ?>Label">URL of monitored service</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <a href="<?php echo $target['url']; ?>"><?php echo $target['url']; ?></a>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <p>

    </div>
<?php endforeach; ?>
    </div><!-- /.row -->

</div><!-- /.container -->

