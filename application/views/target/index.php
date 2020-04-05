<h2><?php echo $title; ?></h2>

<?php foreach ($targets as $target): ?>

    <h3><?php echo $target['name']; ?></h3>
    <div class="main">
        <?php echo $target['url']; ?>
    </div>
<div> <?php echo $target['type']; ?></div>
    <p><a href="<?php echo site_url('category/'.$target['category']); ?>">View category <?php echo $target['category']; ?></a></p>
<hr>
<?php endforeach; ?>