<main role="main">
    <div style="min-height: 100px;"></div>

    <div class="container">

        <div class="row">
            <h1>Monitored Services</h1>
            <?php
            if (isset($successMessage) && !empty($successMessage)) {
                echo '<div style="padding-top: 50px; padding-bottom: 30px;"><br><b>✔️&nbsp;'.$successMessage.'</b><br></div>';
            }
            ?>
            <table class="table table-hover">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">URL</th>
                    <th scope="col">type</th>
                    <th scope="col">Category</th>
                    <th scope="col">Actions</th>
                </tr>
                </thead>
                <tbody>

                <?php

                $orderNumber = 0;
                foreach ($targets as $target) {
                    $orderNumber++;
                    echo '<tr>
<th scope="row">'.$orderNumber.'</th>
      <td>'.$target['name'].'</td>
      <td>'.$target['url'].'</td>
      <td>'.$target['type'].'</td>
      <td>'.$target['category'].'</td>
      <td><a href="'.site_url('/admin/edit/').$target['id'].'" alt="Edit entry">📝</a><br>
      <a href="'.site_url('/admin/delete/').$target['id'].'" alt="Delete entry">🗑️</a></td>
      ';


                    echo '
</p>
            </div><!-- /.col-lg-4 -->';
                }
                ?>
                </tbody>
            </table>
            <br>
            <a href="<?php echo site_url('/admin/add/'); ?>">
                <button type="button" class="btn btn-primary">➕ Add new</button>
            </a>
        </div><!-- /.row -->

    </div><!-- /.container -->