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

        <div class="col-md-12">
            <button class="btn btn-block btn-primary" > <i class="fa fa-plus-circle"></i> Tambah Business</button>
            <br>
            <br>
        </div>

        <div class="col-md-12">
            <div class="row">
                <?php foreach ($business_data as $row) { ?>
                    <div class="col-md-4">
                        <div class="thumbnail">
                            <a href="#">
                                <?php
                                $url_image = base_url() . "uploads/business/blank-img.jpg";
                                if (!empty(trim($row['img_business']))) {
                                    $url_image = base_url() . "uploads/business/" . $row['img_business'];
                                }
                                ?>
                                <img src="<?= $url_image ?>" alt="Lights" style="max-height: 300px;max-width: 300px">
                                <div class="caption" style="height: 100px;">
                                    <h4 class="text-center"><?= $row['nama_business'] ?></h4>
                                    <p><?= limit_text($row['description_business'], 10) ?></p>
                                </div>
                            </a>
                        </div>
                    </div>
                <?php } ?>
            </div>

        </div>

    </div>
    <!-- /.box-body -->
</div>
<?php

function limit_text($text, $limit) {
    if (str_word_count($text, 0) > $limit) {
        $words = str_word_count($text, 2);
        $pos = array_keys($words);
        $text = substr($text, 0, $pos[$limit]) . '...';
    }
    return $text;
}
?>