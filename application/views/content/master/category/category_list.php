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

        <div class="text-right">
            <a href="#" class="btn btn-success">Export</a>
            <a href="<?= base_url() . $url_controller ?>add" class="btn btn-primary">Tambah</a>
        </div>

        <div style="height: 20px"></div>

        <table id="table-list" class="table table-bordered table-condensed table-strip">
            <thead class="bg">
                <tr>
                    <?php foreach ($table_header as $head) { ?>
                        <th><?= ucwords($head) ?></th>
                    <?php } ?>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
<script>
    $(document).ready(function() {
        var table = $('#table-list').DataTable({
            'ajax': {
                'url': '<?= base_url() . $url_controller ?>datatables',
                "complete": function(data, type) {
                    json = data.responseJSON;
                    console.log(json);
                    //                    $('#total_row').html(json.data.length);
                },
                "order": [
                    [1, "desc"]
                ],
                "processing": true,

            },
        });
    });

    function delete_row(id_row) {
        var answer = window.confirm("Anda Yakin Akan menghapus ?")
        if (answer) {
            window.location = '<?= base_url() . $url_controller . 'delete/' ?>' + id_row;
        } else {
            //some code
        }
    }
</script>