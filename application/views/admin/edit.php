<main role="main">
    <div style="min-height: 100px;"></div>

    <div class="container">
        <?php echo validation_errors(); ?>

        <?php echo form_open('news/create'); ?>

        <?php
                   echo '<div class="form-group">
                            <label for="inputName">Name</label>
                            <input type="text" class="form-control" id="inputName" value="'.$target['name'].'" name="inputName" aria-describedby="nameHelp" maxlength="128" required>
                            <small id="emailHelp" class="form-text text-muted">Just a user-friendly name so that user knows what service is checked.</small>
                        </div>
                        <div class="form-group">
                            <label for="inputURL">URL</label>
                            <input type="url" class="form-control" id="inputURL" name="inputURL" value="'.$target['url'].'" aria-describedby="URLHelp" required>
                            <small id="URLHelp" class="form-text text-muted">URL of a resource that should be checked.</small>
                        </div>
                        <div class="form-group">
                            <label for="inputType">Type of check</label>
                            <select class="form-control" id="inputType" name="inputType" aria-describedby="inputTypeHelp" required>';
                   ?>

                                <option <?php if($target['type']=='default') echo 'selected="selected"'; ?> >default</option>
                                <option <?php if($target['type']=='json') echo 'selected="selected"'; ?> >json</option>
            <?php
                            echo '</select>
                            <small id="inputTypeHelp" class="form-text text-muted"><b>default</b> -> check if HTTP response happens and if is a success code
                                <br><b>json</b> -> same as above AND check if it is a valid JSON</small>
                        </div>
                        <div class="form-group">
                            <label for="inputCategory">Category (optional)</label>
                            <input type="text" class="form-control" id="inputCategory" aria-describedby="categoryHelp" name="inputCategory" maxlength="128" value="'.$target['category'].'">
                            <small id="categoryHelp" class="form-text text-muted">Match one of existing categories or add a new one.</small>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="button" class="btn btn-secondary" onclick="location.href = \''.site_url('/admin/').'\';">Back</button>
                    </form>
                    ';
                            ?>
        <div class="row">

        </div>
    </div>