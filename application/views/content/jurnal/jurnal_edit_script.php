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


    $(document).ready(function () {
        $('#table-jurnal > tbody > tr').on('keyup', function () {
            console.log($(this).html());
        });
    });


    $('#table-jurnal').bind("DOMSubtreeModified", function () {
        for (let field of $('.cleave-number').toArray()) {
            new Cleave(field, {
                numeral: true,
                numeralThousandsGroupStyle: 'thousand',
            });
        }
    });

    setInterval(function () {
        $('#table-jurnal > tbody > tr').each(function (index, value) {
            element = $(this).find('.ajax-akun');
            if (!element.hasClass("select2-hidden-accessible")) {
                element.select2({
                    placeholder: "Pilih Akun",
                    ajax: {
                        url: '<?=base_url().$url_controller .'ajax_akun'?>',
                        dataType: 'json'
                                // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
                    }
                });
            }
        });
    }, 500);


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