<div class="col-md-12">
    <div class="col-md-12">

        <form action="<?= base_url() . $url_controller . "/submit_add_business" ?>">
            <div class="form-group">
                <label for="nama_business">nama_business:</label>
                <input type="nama_business" class="form-control" id="nama_business" >
            </div>
            <div class="form-group">
                <label for="id_business_type">Password:</label>
                <select name="id_business_type" id="id_business_type" class="form-control">
                </select>
                <?= form_dropdown('id_business_type', $opt_id_business_type, $selected_id_business_type, ' class="form-control" ')?>
            </div>
            <div class="checkbox">
                <label><input type="checkbox"> Remember me</label>
            </div>
            <button type="submit" class="btn btn-default">Submit</button>
        </form>

    </div>
</div>