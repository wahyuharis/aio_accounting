<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title"><?= $panel_title ?></h3>
    </div>
    <!-- /.box-header -->
    <!-- form start -->
    <div class="box-body">
        <?= form_open_multipart($url_controller . "submit", ' id="form-1" class="form-horizontal form-label-left" ') ?>
        <div class="col-md-6">
            <?= form_hidden('id', $id) ?>
            <div class="form-group">
                <label class="col-md-4" for="nama"> <span class="required">*</span>
                    Nama
                </label>
                <div class="col-md-8">
                    <input type="text" id="nama" name="nama" value="<?= $nama ?>"  class="form-control col-md-7 col-xs-12">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4" for="is_package"> <span class="required">*</span>
                    Adalah Satuan Paket
                </label>
                <div class="col-md-8">
                    <?= form_checkbox('is_package', '1', $is_package, ' id="is_package" ') ?>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div id="is_package_toggle" style="visibility:hidden" >
                <div class="form-group" >
                    <label class="col-md-4" for="id_child"> <span class="required">*</span>
                        Satuan Ecer
                    </label>
                    <div class="col-md-8">
                        <?= form_dropdown('id_child', $opt_child, $id_child, ' class="form-control select2" ') ?>
                    </div>
                </div>

                <div class="form-group" >
                    <label class="col-md-4" for="nama"> <span class="required">*</span>
                        Qty Ecer
                    </label>
                    <div class="col-md-8">
                        <input type="text" id="qty_child" name="qty_child" value="<?= $qty_child ?>"  class="form-control col-md-7 col-xs-12">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">                
            <div class="col-md-8">
                <?= form_submit('save', 'save', ' id="save" class="btn btn-primary" ') ?>
                <a href="<?= base_url() . $url_controller ?>" class="btn btn-default">Cancel</a>
            </div>
        </div>
        <?= form_close() ?>
    </div>
</div>
<style>
    .fixed-alert{
        position: fixed;
        z-index: 9999;
        width: 300px;
        bottom: 10px;
        right: 10px;
    }
</style>
<div id="alert-error" class="alert alert-danger fixed-alert" style="display: none;" >
    <strong>Alert !</strong>
    <p id="alert-error-html"></p>
</div>

<script>
    $('#is_package').change(function () {
        if ($(this).is(':checked')) {
            $('#is_package_toggle').css('visibility', 'visible');

        } else {
            $('#is_package_toggle').css('visibility', 'hidden');
        }
    });

    $(document).ready(function () {
        $('.select2').select2();
        if ($('#is_package').is(':checked')) {
            $('#is_package_toggle').css('visibility', 'visible');
        }
//        $('#regencies_id').select2({
//            placeholder: 'Ketik Nama Kota',
//            ajax: {
//                url: '<?= base_url($url_controller . "kota_ajax") ?>',
//
//            },
//            allowClear: true,
//        });

        $('#alert-error').click(function () {
            $(this).hide();
        });


    });
    $('#form-1').submit(function (e) {
        e.preventDefault();

        $('#save').prop('disabled', true);

        $.ajax({
            url: '<?= base_url() . $url_controller . 'submit' ?>', // Url to which the request is send
            type: "POST", // Type of request to be send, called as method
            data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
            contentType: false, // The content type used when sending data to the server.
            cache: false, // To unable request pages to be cached
            processData: false, // To send DOMDocument or non processed data file it is set to false
            success: function (data)   // A function to be called if request succeeds
            {
                if (!data.status) {
                    $('#alert-error').show();
                    $('#alert-error-html').html(data.message);
                    setTimeout(function () {
                        $('#alert-error').fadeOut('slow');
                    }, 2000);
                } else {
                    window.location = '<?= base_url() . $url_controller ?>';
                }
                $('#save').prop('disabled', false);

            },
            error: function (err) {
                alert(JSON.stringify(err));
                $('#save').prop('disabled', false);
            }
        });

    });
</script>