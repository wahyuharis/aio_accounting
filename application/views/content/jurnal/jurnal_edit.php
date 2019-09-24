<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title panel_title"><?= $panel_title ?></h3>
    </div>
    <div class="box-body" id="ko-journal">
        <div class="col-md-12">
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="kode">Kode</label>
                    <input type="text" class="form-control" id="kode">
                </div>

                <div class="form-group">
                    <label for="tanggal"></label>
                    <input type="text" class="form-control" id="tanggal">
                </div>

                <div class="form-group">
                    <label for="kode">Kode</label>
                    <input type="text" class="form-control" id="kode">
                </div>
            </div>
            <div class="col-sm-6">

            </div>



        </div>


        <div class="col-md-12">
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
                    <tbody data-bind="foreach: journal_list">
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