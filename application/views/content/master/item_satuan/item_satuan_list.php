<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title"><?= $panel_title ?></h3>
    </div>
    <!-- /.box-header -->
    <!-- form start -->
    <div class="box-body">

        <div class="row">
            <div class="col-md-6">
                <a href="<?= base_url() . $url_controller ?>add" class="btn btn-primary"><i class="fa fa-plus floatL t3"></i> Tambah</a>
            </div>
            <div class="col-md-6 text-right">
                <a href="#" class="btn btn-default"><i class="fa fa-cloud-download floatL t3"></i> Export</a>
            </div>
        </div>

        <div style="height: 20px"></div>

        <table id="table-list" class="table table-bordered table-condensed table-strip">
            <thead class="bg">
                <tr>
                    <th width="200px" >#</th>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Sebanding</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
<script>
    $(document).ready(function () {
        var table = $('#table-list').DataTable({
            'ajax': {
                'url': '<?= base_url() . $url_controller ?>datatables',
                "complete": function (data, type) {
                    json = data.responseJSON;
                    console.log(json);
//                    $('#total_row').html(json.data.length);
                },
                "order": [[1, "desc"]],
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

