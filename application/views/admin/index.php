<main role="main">
    <div style="min-height: 100px;"></div>

    <div class="container">

        <div class="row">
            <h1>Monitored Services</h1>
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
      <td><a href="manage.php?action=edit&id='.$target['id'].'" alt="Edit entry">📝</a><br>
      <a href="manage.php?action=delete&id='.$target['id'].'" alt="Delete entry">🗑️</a></td>
      ';


                    echo '
</p>
            </div><!-- /.col-lg-4 -->';
                }
                ?>
                </tbody>
            </table>
            <br>
            <a href="manage.php?action=add">
                <button type="button" class="btn btn-primary">➕ Add new</button>
            </a>
        </div><!-- /.row -->

    </div><!-- /.container -->