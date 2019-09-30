<script>
    function floatval(target) {
        if (target.length < 1) {
            target = "0";
        }

        var str = target.replace(new RegExp(',', 'g'), '');
        return parseFloat(str);
    }

    function format_uang(intejer) {
        return numeral(intejer).format('0,0.00');
    }



    function change_row_handle() {
        var increment = 0;
        $('.key-arrow-move').keydown(function (e) {
            var posisi_cursor = parseInt($(this).val().length) - parseInt($(this).caret());
            if (e.keyCode == 39) {
                if (posisi_cursor == 0) {
                    increment++;
                    if (increment > 2) {
                        $(this).closest('td').nextAll().find('input').first().focus();
                        increment = 0;
                    }
                }
            } else if (e.keyCode == 37) {
                if ($(this).caret() == 0) {
                    increment++;
                    if (increment > 2) {
                        $(this).closest('td').prevAll().find('input').first().focus();
                        increment = 0;
                    }
                }
            }
        });
        $('.key-arrow-move').keyup(function (e) {
            if (e.keyCode == 40) {
                $(this).closest('tr').next().find('td:eq(' + $(this).closest('td').index() + ')').find('input').focus();
            } else if (e.keyCode == 38) {
                $(this).closest('tr').prev().find('td:eq(' + $(this).closest('td').index() + ')').find('input').focus();
            }
        });
    }



    $(document).ready(function () {
        $('#table-jurnal > tbody > tr').on('keyup', function () {
            console.log($(this).html());
        });


        $('input[name="tanggal"]').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            locale: {
                format: 'DD/MM/YYYY'
            },
//            minYear: 1901,
//            maxYear: parseInt(moment().format('YYYY'), 10)
        }, function (start, end, label) {
//            var years = moment().diff(start, 'years');
//            alert("You are " + years + " years old!");
        });

        change_row_handle();
    });


    $('#table-jurnal').bind("DOMSubtreeModified", function () {
        for (let field of $('.cleave-number').toArray()) {
            new Cleave(field, {
                numeral: true,
                numeralThousandsGroupStyle: 'thousand',
            });
        }
        change_row_handle();
    });

    setInterval(function () {
        $('#table-jurnal > tbody > tr').each(function (index, value) {
            element = $(this).find('.ajax-akun');
            if (!element.hasClass("select2-hidden-accessible")) {
                element.select2({
                    placeholder: "Pilih Akun",
                    ajax: {
                        url: '<?= base_url() . $url_controller . 'ajax_akun' ?>',
                        dataType: 'json'
                    }
                });
            }
        });
    }, 200);


    function add_journal_list(m_coa, debit, kredit, keterangan) {
        var self = this;

        self.m_coa = ko.observable(m_coa);
        self.debit = ko.observable(debit);
        self.kredit = ko.observable(kredit);

        self.keterangan = ko.observable(keterangan);
    }


    function journal_list_model() {
        var self = this;
        self.journal_list = ko.observableArray([]);

        self.m_coa_opt = ko.observableArray([]);

        self.debit_total = ko.computed(function () {
            var total = 0;
            for (var i = 0; i < self.journal_list().length; i++) {
                debit_i = floatval(self.journal_list()[i].debit());
                total = total + parseFloat(debit_i);
            }
            return format_uang(total);
        });
        self.kredit_total = ko.computed(function () {
            var total = 0;
            for (var i = 0; i < self.journal_list().length; i++) {
                debit_i = floatval(self.journal_list()[i].kredit());
                total = total + parseFloat(debit_i);
            }
            return format_uang(total);
        });

        self.selisih = ko.computed(function () {
            var total = 0;
            for (var i = 0; i < self.journal_list().length; i++) {
                debit_i = floatval(self.journal_list()[i].debit());
                total = total + parseFloat(debit_i);
            }


            var total1 = 0;
            for (var i = 0; i < self.journal_list().length; i++) {
                debit_i = floatval(self.journal_list()[i].kredit());
                total1 = total1 + parseFloat(debit_i);
            }

            total = total - total1;

            if (total < 0) {
                total = total * (-1);
            }

            return format_uang(total);
        });

        self.add_journal_list_click = function (e) {
            self.journal_list.push(new add_journal_list('', '', '', ''));
        }

        self.remove_journal_list = function (row) {
            self.journal_list.remove(row);
        }

//        $('#table-jurnal > tbody > tr').each(function (index, value) {
//            element = $(this).find('.ajax-akun');
//            if (!element.hasClass("select2-hidden-accessible")) {
//                element.select2({
//                    allowClear: true,
//                });
//            }
//        });

//        $('.ajax-akun').select2();

    }

    ko.applyBindings(new journal_list_model(), document.getElementById('ko-journal'));



</script>