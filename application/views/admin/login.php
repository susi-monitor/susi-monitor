<main role="main">
    <div style="min-height: 100px;"></div>

    <div class="container">

        <div class="row">

            <?php echo form_open('admin/loginAction'); ?>
                <div class="form-group"> <?php
                    if (isset($message) && !empty($message)) {
                        echo '<div class="alert alert-warning"><b>'.$message.'</b></div><br><br>';
                    }
                    ?>

                    <label for="inputName">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
        </div><!-- /.row -->

    </div><!-- /.container -->

