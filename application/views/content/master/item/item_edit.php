<div class="x_panel">
    <div class="x_title">
        <h2><?= $panel_title ?></h2>
        <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="#">Settings 1</a>
                    </li>
                    <li><a href="#">Settings 2</a>
                    </li>
                </ul>
            </li>
            <li><a class="close-link"><i class="fa fa-close"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">

        <?= form_open_multipart($url_controller . "submit", ' id="form-1" class="form-horizontal form-label-left" ') ?>
        <div class="col-md-6">
            <?= form_hidden('id_item', $id_item)?>
            <div class="form-group">
                <label class="col-md-4" for="nama"> <span class="required">*</span>
                    Nama
                </label>
                <div class="col-md-8">
                    <input type="text" id="nama_item" name="nama_item" value="<?=$nama_item?>"  class="form-control col-md-7 col-xs-12">
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-md-4" for="satuan"> <span class="required">*</span>
                    Satuan
                </label>
                <div class="col-md-8">
                    <?= form_dropdown('satuan', $opt_satuan, $satuan , ' class="form-control" id="satuan" ')?>
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-md-4" for="satuan"> <span class="required">*</span>
                    Punya Stok
                </label>
                <div class="col-md-8">
                    <?= form_checkbox('is_have_stock', '1', $is_have_stock, '  ')?>
                </div>
            </div>

        </div>
        <div class="col-md-6">
            
        </div>
        <div class="col-md-12">                
            <div class="col-md-8">
                <?= form_submit('save', 'save', ' id="save" class="btn btn-primary" ') ?>
                <a href="<?=base_url().$url_controller?>" class="btn btn-default">Cancel</a>
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
    $(document).ready(function () {
        $('#regencies_id').select2({
            placeholder: 'Ketik Nama Kota',
            ajax: {
                url: '<?= base_url($url_controller . "kota_ajax") ?>',
                
            },
            allowClear: true,
        });

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