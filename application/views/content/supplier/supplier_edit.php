
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title"><?= $panel_title ?></h3>
    </div>
    <!-- /.box-header -->
    <!-- form start -->
    <div class="box-body">

        <?= form_open_multipart($url_controller . "submit", ' id="form-1" class="form-horizontal form-label-left" ') ?>
        <div class="row">
            <div class="col-md-6">
                <?= form_hidden('id_supplier', $id_supplier) ?>
                <div class="form-group">
                    <label class="col-sm-4" for="nama"> <span class="required">*</span>
                        Nama
                    </label>
                    <div class="col-sm-8">
                        <input type="text" id="nama" name="nama" value="<?= $nama ?>"  class="form-control col-md-7 col-xs-12">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-4" for="email"> <span class="required">*</span>
                        Email
                    </label>
                    <div class="col-sm-8">
                        <input type="text" id="email" name="email" value="<?= $email ?>" class="form-control col-md-7 col-xs-12">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-4" for="phone"> <span class="required">*</span>
                        Telp
                    </label>
                    <div class="col-sm-8">
                        <input type="text" id="phone" name="phone" value="<?= $phone ?>" class="form-control col-md-7 col-xs-12">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-4" for="phone_kantor"> <span class="required"></span>
                        Telp Kantor
                    </label>
                    <div class="col-sm-8">
                        <input type="text" id="phone_kantor" name="phone_kantor" value="<?= $phone_kantor ?>" class="form-control col-md-7 col-xs-12">
                    </div>
                </div>


            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="col-sm-4" for="regencies_id"> <span class="required">*</span>
                        Kota
                    </label>
                    <div class="col-sm-8">
                        <?= form_dropdown('regencies_id', $regencies_selected, $regencies_id, ' class="form-control" id="regencies_id" placeholder="Ketik Nama Kota" ') ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4" for="alamat"> <span class="required">*</span>
                        Alamat
                    </label>
                    <div class="col-sm-8">                
                        <textarea name="alamat" id="alamat" class="form-control" style="height:100px" ><?= $alamat ?></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">                
                <div class="col-md-12">
                    <?= form_submit('save', 'save', ' id="save" class="btn btn-primary" ') ?>
                    <a href="<?= base_url() . $url_controller ?>" class="btn btn-default">Cancel</a>
                </div>
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
    // on first focus (bubbles up to document), open the menu
    $(document).on('focus', '.select2-selection.select2-selection--single', function (e) {
        $(this).closest(".select2-container").siblings('select:enabled').select2('open');
    });

// steal focus during close - only capture once and stop propogation
    $('select.select2').on('select2:closing', function (e) {
        $(e.target).data("select2").$selection.one('focus focusin', function (e) {
            e.stopPropagation();
        });
    });


    $(document).ready(function () {
        $('#regencies_id').select2({
            placeholder: 'Ketik Nama Kota',
            ajax: {
                url: '<?= base_url($url_controller . "kota_ajax") ?>',
                delay:1000, 
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