<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title panel_title"><?= $panel_title ?></h3>
    </div>
    <div class="box-body">
        <div class="row">

        </div>

        <div class="row">
            <div class="col-md-6">
                <table class="table table-striped" id="table-jurnal">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Akun</th>
                            <th>Debit</th>
                            <th>Kredit</th>
                        </tr>    
                    </thead>
                    <tbody>
                        <tr>
                            <td></td>
                            <td><input type="text" class="form-control input-sm" /> </td>
                            <td><input type="text"  class="form-control input-sm" /> </td>
                            <td><input type="text"  class="form-control input-sm" /> </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><input type="text" class="form-control input-sm" /> </td>
                            <td><input type="text"  class="form-control input-sm" /> </td>
                            <td><input type="text"  class="form-control input-sm" /> </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><input type="text" class="form-control input-sm" /> </td>
                            <td><input type="text"  class="form-control input-sm" /> </td>
                            <td><input type="text"  class="form-control input-sm" /> </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-6"></div>
        </div>
    </div>
</div>
<?php require_once 'jurnal_edit_script.php'; ?>