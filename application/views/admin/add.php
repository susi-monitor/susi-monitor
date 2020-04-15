<main role="main">
    <div style="min-height: 50px;"></div>

    <div class="container">

        <div class="row">

            <?php echo form_open('admin/addAction'); ?>
            <h1>Add new target</h1>
            <div class="form-group">
                <div>
                    <?php echo validation_errors('<br><b>⚠️&nbsp;', '</b>'); ?>
                </div>
                <br>
                    <label for="inputName">Name</label>
                    <input type="text" class="form-control" id="inputName"
                           name="inputName" aria-describedby="nameHelp"
                           maxlength="128" required>
                    <small id="nameHelp" class="form-text text-muted">Just a
                        user-friendly name so that user knows what service is
                        checked.</small>
                </div>
                <div class="form-group">
                    <label for="inputURL">URL</label>
                    <input type="url" class="form-control" id="inputURL"
                           name="inputURL" aria-describedby="URLHelp" required>
                    <small id="URLHelp" class="form-text text-muted">URL of a
                        resource that should be checked.</small>
                </div>
                <div class="form-group">
                    <label for="inputType">Type of check</label>
                    <select class="form-control" id="inputType" name="inputType"
                            aria-describedby="inputTypeHelp" required>
                        <option>default</option>
                        <option>json</option>
                    </select>
                    <small id="inputTypeHelp" class="form-text text-muted"><b>default</b>
                        -> check if HTTP response happens and if is a success
                        code
                        <br><b>json</b> -> same as above AND check if it is a
                        valid JSON</small>
                </div>
                <div class="form-group">
                    <label for="inputCategory">Category (optional)</label>
                    <input type="text" class="form-control" id="inputCategory"
                           aria-describedby="categoryHelp" name="inputCategory"
                           maxlength="128">
                    <small id="categoryHelp" class="form-text text-muted">Match
                        one of existing categories or add a new one.</small>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
                <button type="button" class="btn btn-secondary"
                        onclick="location.href = '<?php echo site_url('/admin'); ?>';">Back
                </button>
            </form>
        </div><!-- /.row -->

    </div><!-- /.container -->