<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title panel_title"><?= $panel_title ?></h3>
    </div>
    <div class="box-body" id="ko-journal">
        <div class="col-md-12">
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="kode">Kode</label>
                    <input type="text" class="form-control" id="kode" name="kode">
                </div>

                <div class="form-group">
                    <label for="tanggal">Tanggal</label>
                    <input type="text" class="form-control" id="tanggal" name="tanggal">
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="tanggal">Keterangan</label>
                    <textarea id="keterangan" name="keterangan" class="form-control" style="height: 108px" ></textarea>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <br>
            <hr>
            <br>
        </div>

        <div class="col-md-12">
            <!--<div class="col-md-6">-->
            <table class="table table-striped " id="table-jurnal">
                <thead>
                    <tr>
                        <th>#</th>
                        <th style="width: 300px" >Akun</th>
                        <th>Debit</th>
                        <th>Kredit</th>
                        <th>Keterangan</th>
                        <th></th>
                    </tr>    
                </thead>
                <tbody data-bind="foreach : journal_list">
                    <tr>
                        <td>#</td>
                        <td>
                            <select data-bind="
                                    value:m_coa,
                                    valueAllowUnset: true,
                                    options: $root.m_coa_opt,
                                    optionsText: 'text',
                                    optionsValue: 'id',
                                    "  class="form-control ajax-akun" style="width: 100%" >
                                                                    <!--select2: { placeholder: 'Pilih Akun...', allowClear: true }-->

                            </select>
                        </td>
                        <td><input type="text" data-bind="textInput: debit"  class="form-control  cleave-number" /> </td>
                        <td><input type="text" data-bind="textInput: kredit" class="form-control  cleave-number" /> </td>
                        <td><input type="text" data-bind="value: keterangan" class="form-control " /> </td>
                        <td><a data-bind="click: $root.remove_journal_list" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a></td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="6">
                            <div class="btn-group btn-group-justified" role="group" aria-label="">
                                <a data-bind="click: add_journal_list_click" class="btn btn-block btn-primary"><i class="fa fa-plus-circle"></i> Tambah</a>
                            </div>
                        </th>
                    </tr>
                    <tr>
                        <th colspan="2" class="text-center" >Total : </th>
                        <th><span data-bind="text:debit_total"></span></th>
                        <th><span data-bind="text:kredit_total"></span></th>
                        <th></th>
                        <th></th>
                    </tr>
                    <tr>
                        <th colspan="2" class="text-center" >Selisih : </th>
                        <th></th>
                        <th><span data-bind="text:selisih"></span></th>
                        <th></th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
            <input type="hidden" name="ko-json" data-bind="value: ko.toJSON($root)">

            <!--</div>-->
            <!--<div class="col-md-6"></div>-->
            <div class="text-right">
                <button class="btn btn-default" >Cancel</button>
                <button class="btn btn-primary" >Simpan</button>
            </div>
        </div>
    </div>
</div>
<?php require_once 'jurnal_edit_script.php'; ?>