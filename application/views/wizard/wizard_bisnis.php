<link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<link rel="stylesheet" href="<?php echo base_url() ?>AdminLTE-2.4.2/wizard/wizard.css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title"><?= $panel_title ?></h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
        </div>
        <!-- /.box-tools -->
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div class="stepwizard">
            <div class="stepwizard-row setup-panel">
                <div class="stepwizard-step col-xs-4">
                    <a href="#step-1" type="button" class="btn btn-success btn-circle"><i class="fa fa-briefcase" aria-hidden="true"></i></a>
                    <p><small>Tipe Bisnis</small></p>
                </div>
                <div class="stepwizard-step col-xs-4">
                    <a href="#step-2" type="button" class="btn btn-default btn-circle" disabled="disabled"><i class="fa fa-map-marker" aria-hidden="true"></i></a>
                    <p><small>Detil Bisnis</small></p>
                </div>
                <div class="stepwizard-step col-xs-4">
                    <a href="#step-3" type="button" class="btn btn-default btn-circle" disabled="disabled"><i class="fa fa-picture-o" aria-hidden="true"></i></a>
                    <p><small>Deskripsi Bisnis</small></p>
                </div>
            </div>
        </div>
        <form role="form">
            <div class="panel panel-primary setup-content" id="step-1">
                <div class="panel-heading">
                    <h3 class="panel-title">Tipe Bisnis</h3>
                </div>
                <div class="panel-body">
                    <?php
                    $idbs = $this->session->userdata('business_type');
                    $idjs = $this->session->userdata('jenis_usaha');
                    $bussiness_type = $this->db->query("SELECT * FROM m_business_type WHERE id_business_type='$idbs'")->row_array();
                    $jenis_usaha = $this->db->query("SELECT * FROM m_jenis_usaha WHERE id_business_type='$idjs'")->row_array();
                    ?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Tipe Bisnis</label>
                                <select name="business_type" id="business_type" class="form-control">
                                    <?php if ($idbisnis == NULL) {; ?>
                                        <option value="0">Pilih Tipe Bisnis</option>
                                    <?php } else {; ?>
                                        <option value="<?php echo $bussiness_type['id_jenis_usaha']; ?>"><?php echo $bussiness_type['nama_usaha']; ?></option>
                                    <?php }; ?>
                                    <?php foreach ($bs_type as $rw) : ?>
                                        <option value="<?php echo $rw->id; ?>"><?php echo $rw->name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Jenis Usaha</label>
                                <select name="jenis_usaha" id="jenis_usaha" class="form-control">
                                    <option value="1">Usaha</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Stok</label>
                                <select name="jenis_usaha" id="jenis_usaha" class="form-control">
                                    <option value="1">Pakai Stok</option>
                                    <option value="0">Tidak Pakai Stok</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary nextBtn pull-right" type="button"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> Next</button>
                </div>
            </div>

            <div class="panel panel-primary setup-content" id="step-2">
                <div class="panel-heading">
                    <h3 class="panel-title">Detail Bisnis</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Nama Bisnis</label>
                                <input type="text" class="form-control" id="business_name" name="business_name" placeholder="Nama Bisnis">
                            </div>
                            <div class="form-group">
                                <label class="control-label">Email Bisnis</label>
                                <input type="number" required="required" class="form-control" placeholder="@mail.com" />
                            </div>
                            <div class="form-group">
                                <label class="control-label">Telepon</label>
                                <input type="number" required="required" class="form-control" placeholder="+62-9877-997" />
                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Propinsi</label>
                                <input type="text" class="form-control" id="id_provinsi" name="business_name" placeholder="Provinsi">
                            </div>
                            <div class="form-group">
                                <label class="control-label">Kabupaten</label>
                                <input type="text" class="form-control" id="business_name" name="business_name" placeholder="Kabupaten">
                            </div>
                            <div class="form-group">
                                <label class="control-label">Kecamatan</label>
                                <input type="text" class="form-control" id="business_name" name="business_name" placeholder="Kecamatan">
                            </div>
                            <div class="form-group">
                                <label class="control-label">Alamat</label>
                                <textarea name="alamat_bisnis" id="alamat_bisnis" cols="30" rows="5" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary nextBtn pull-right" type="button"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> Next</button>
                </div>
            </div>
            <div class="panel panel-primary setup-content" id="step-3">
                <div class="panel-heading">
                    <h3 class="panel-title">Deskripsi Bisnis</h3>
                </div>
                <div class="panel-body">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Deskripsi Bisnis</label>
                            <textarea name="desc_bisnis" id="desc_bisnis" cols="30" rows="5" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Logo Bisnis</label>
                            <input type="File" required="required" class="form-control" placeholder="Enter Company Address" />
                        </div>
                    </div>
                    <button class="btn btn-success pull-right" type="submit">Finish!</button>
                </div>
            </div>

            <!-- <div class="panel panel-primary setup-content" id="step-4">
                <div class="panel-heading">
                    <h3 class="panel-title">Cargo</h3>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="control-label">Company Name</label>
                        <input maxlength="200" type="text" required="required" class="form-control" placeholder="Enter Company Name" />
                    </div>
                    <div class="form-group">
                        <label class="control-label">Company Address</label>
                        <input maxlength="200" type="text" required="required" class="form-control" placeholder="Enter Company Address" />
                    </div>
                    <button class="btn btn-success pull-right" type="submit">Finish!</button>
                </div>
            </div> -->
        </form>
    </div>
    <!-- /.box-body -->
</div>

<script>
    $(function() {
        $.ajaxSetup({
            type: "POST",
            url: "<?php echo base_url('wizard/ambil_data'); ?>",
            cache: false,
        });
        $("#business_type").change(function() {
            var value = $(this).val();
            if (value > 0) {
                $.ajax({
                    data: {
                        modul: 'jenis_usaha',
                        id: value
                    },
                    success: function(respond) {
                        $("#jenis_usaha").html(respond);
                    }
                })
            }
        });
    })

    $(document).ready(function() {
        var navListItems = $('div.setup-panel div a'),
            allWells = $('.setup-content'),
            allNextBtn = $('.nextBtn');

        allWells.hide();

        navListItems.click(function(e) {
            e.preventDefault();
            var $target = $($(this).attr('href')),
                $item = $(this);

            if (!$item.hasClass('disabled')) {
                navListItems.removeClass('btn-success').addClass('btn-default');
                $item.addClass('btn-success');
                allWells.hide();
                $target.show();
                $target.find('input:eq(0)').focus();
            }
        });

        allNextBtn.click(function() {
            var curStep = $(this).closest(".setup-content"),
                curStepBtn = curStep.attr("id"),
                nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
                curInputs = curStep.find("input[type='text'],input[type='url']"),
                isValid = true;

            $(".form-group").removeClass("has-error");
            for (var i = 0; i < curInputs.length; i++) {
                if (!curInputs[i].validity.valid) {
                    isValid = false;
                    $(curInputs[i]).closest(".form-group").addClass("has-error");
                }
            }

            if (isValid) nextStepWizard.removeAttr('disabled').trigger('click');
        });

        $('div.setup-panel div a.btn-success').trigger('click');
    });
</script>