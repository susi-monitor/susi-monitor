<main role="main">
    <div style="min-height: 100px;"></div>

    <div class="container">

        <div class="row">
            <div style="min-height: 100px;"></div>

            <?php
            echo 'Are you sure you want to delete&nbsp; 
<b>'.$target['name'].'</b>?&nbsp;&nbsp;
<a href="'.site_url('/admin/deleteAction/').$target['id'].'">
    <button>Yes</button>
</a>&nbsp;
<a href="'.site_url('/admin/').'">
    <button>No</button>
</a>';
            ?>
        </div>
    </div>
