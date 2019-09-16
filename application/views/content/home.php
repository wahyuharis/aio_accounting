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

<!--        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab1" data-toggle="tab">Shipping</a></li>
                <li><a href="#tab2" data-toggle="tab">Quantities</a></li>
                <li><a href="#tab3" data-toggle="tab">Summary</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab1">
                </div>
                <div class="tab-pane" id="tab2">
                </div>
                <div class="tab-pane" id="tab3">
                </div>
            </div>

            <a class="btn btn-primary btnPrevious">Previous</a>
            <a class="btn btn-primary btnNext">Next</a>
        </div>-->

    </div>
    <!-- /.box-body -->
</div>
<script>
    $('.btnNext').click(function () {
        $('.nav-tabs > .active').next('li').find('a').trigger('click');
    });

    $('.btnPrevious').click(function () {
        $('.nav-tabs > .active').prev('li').find('a').trigger('click');
    });
</script>

