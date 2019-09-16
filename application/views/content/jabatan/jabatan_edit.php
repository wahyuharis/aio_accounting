<style>
    .container-cb {
        display: block;
        position: relative;
        padding-left: 35px;
        margin-bottom: 25px;
        cursor: pointer;
        font-size: 22px;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    /* Hide the browser's default checkbox */
    .container-cb input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
        height: 0;
        width: 0;
    }

    /* Create a custom checkbox */
    .checkmark {
        position: absolute;
        top: 0;
        left: 0;
        height: 25px;
        width: 25px;
        /*background-color: #eee;*/
        border:1px solid #aaa;
    }

    /* On mouse-over, add a grey background color */
    .container-cb:hover input ~ .checkmark {
        /*background-color: #ccc;*/
    }

    /* When the checkbox is checked, add a blue background */
    .container-cb input:checked ~ .checkmark {
        /*background-color: #2196F3;*/
    }

    /* Create the checkmark/indicator (hidden when not checked) */
    .checkmark:after {
        content: "";
        position: absolute;
        display: none;
    }

    /* Show the checkmark when checked */
    .container-cb input:checked ~ .checkmark:after {
        display: block;
    }

    /* Style the checkmark/indicator */
    .container-cb .checkmark:after {
        left: 7px;
        top: 0px;
        width: 8px;
        height: 17px;
        border: solid #5d5d5d;
        border-width: 0 3px 3px 0;
        -webkit-transform: rotate(45deg);
        -ms-transform: rotate(45deg);
        transform: rotate(45deg);
    }
</style>

<?php
$this->load->model('_etc/Menu_model');
$menu_model = new Menu_model();
?>


<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title"><?= $panel_title ?></h3>
    </div>
    <!-- /.box-header -->
    <!-- form start -->
    <div class="box-body">
        <?= form_open_multipart($url_controller . "submit", ' id="form-1" class="form-horizontal form-label-left" ') ?>
        <?= form_hidden('id_jabatan', $id_jabatan) ?>
        <?= form_hidden('id_business', $id_business) ?>
        <div class="col-md-12">
            <div class="form-group">
                <label class="col-md-4" for="nama"> <span class="required">*</span>
                    Nama
                </label>
                <div class="col-md-8">
                    <input type="text" id="nama" name="nama" value="<?= $nama ?>"  class="form-control col-md-7 col-xs-12">
                </div>
            </div>
            <hr>
            <div class="form-group">
                <div class="col-sm-4">
                    <label>Hak Akses</label>
                </div>
                <div class="col-sm-8">
                    <table id="table-menu-list" class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Menu</th>
                                <th>
                                    <label class="container-cb">
                                        <input class="big-size" id="all" type="checkbox" >
                                        <span class="checkmark"></span>
                                    </label>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $level1 = $menu_model->get_menu(0, '');
                            ?>
                            <?php $no = 1 ?>
                            <?php foreach ($level1 as $row) { ?>
                                <?php $level2 = $menu_model->get_menu(1, $row['id_menu']); ?>
                                <?php if (count($level2) < 1) { ?>
                                    <?php
                                    $this->db->where(array('id_jabatan' => $id_jabatan, 'id_business' => $id_business, 'id_menu' => $row['id_menu']));
                                    $jabatan_row = $this->db->get('_menu_jabatan')->num_rows();
                                    $checked = "";
                                    if ($jabatan_row > 0) {
                                        $checked = ' checked="checked" ';
                                    }
                                    ?>
                                    <tr>
                                        <td><?= $no ?></td>
                                        <td><label for="menu-<?= $no ?>" ><?= $row['nama'] ?></label></td>
                                        <td>
                                            <label class="container-cb">
                                                <input class="big-size" type="checkbox" <?= $checked ?> id="menu-<?= $no ?>" name="menu[]" value="<?= $row['id_menu'] ?>" >
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                    </tr>
        <?php $no++ ?>
                                <?php } else { ?>
                                    <?php foreach ($level2 as $row2) { ?>
                                        <?php $level3 = $menu_model->get_menu(2, $row2['id_menu']); ?>
                                        <?php if (count($level3) < 1) { ?>
                                            <?php
                                            $this->db->where(array('id_jabatan' => $id_jabatan, 'id_business' => $id_business));
                                            $this->db->where_in('id_menu', array($row['id_menu'], $row2['id_menu']));
                                            $jabatan_row2 = $this->db->get('_menu_jabatan')->num_rows();
                                            $checked2 = "";
                                            if ($jabatan_row2 > 1) {
                                                $checked2 = ' checked="checked" ';
                                            }
                                            ?>
                                            <tr>
                                                <td><?= $no ?></td>
                                                <td><label for="menu-<?= $no ?>"><?= $row['nama'] ?> > <?= $row2['nama'] ?></label></td>
                                                <td>
                                                    <label class="container-cb">
                                                        <input  class="big-size" <?= $checked2 ?>  id="menu-<?= $no ?>" type="checkbox"  name="menu[]"  value="<?= $row['id_menu'] ?>_<?= $row2['id_menu'] ?>" >
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </td>
                                            </tr>
                <?php $no++ ?>
                                        <?php } else { ?>
                                            <?php foreach ($level3 as $row3) { ?>
                                                <?php
                                                $this->db->where(array('id_jabatan' => $id_jabatan, 'id_business' => $id_business));
                                                $this->db->where_in('id_menu', array($row['id_menu'], $row2['id_menu'], $row3['id_menu']));
                                                $jabatan_row3 = $this->db->get('_menu_jabatan')->num_rows();
                                                $checked3 = "";
                                                if ($jabatan_row3 > 2) {
                                                    $checked3 = ' checked="checked" ';
                                                }
                                                ?>
                                                <tr>
                                                    <td><?= $no ?></td>
                                                    <td><label  for="menu-<?= $no ?>"  ><?= $row['nama'] ?> > <?= $row2['nama'] ?> > <?= $row3['nama'] ?></label>
                                                    </td>
                                                    <td>
                                                        <label class="container-cb">
                                                            <input  class="big-size" <?= $checked3 ?>  id="menu-<?= $no ?>"  type="checkbox"  name="menu[]"  value="<?= $row['id_menu'] ?>_<?= $row2['id_menu'] ?>_<?= $row3['id_menu'] ?>" >
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </td>
                                                </tr>
                    <?php $no++ ?>
                                            <?php } ?>
                                        <?php } ?>
                                    <?php } ?>
                                <?php } ?>
                            <?php } ?>
                        </tbody>
                    </table>
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
    $(document).ready(function () {

    });

    $('#all').change(function (e) {
        var check_all = false;
        if ($(this).is(':checked')) {
            check_all = true;
        }

        $('#table-menu-list > tbody > tr').find('input[type=checkbox]').each(function () {
            $(this).prop('checked', check_all);
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
//                alert(JSON.stringify(err));
                alert("Cek Koneksi");
                $('#save').prop('disabled', false);
            }
        });
    });
</script>