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


    $('#table-jurnal > tbody').bind("DOMSubtreeModified", function () {
        for (let field of $('.cleave-number').toArray()) {
            new Cleave(field, {
                numeral: true,
                numeralThousandsGroupStyle: 'thousand',
            });
        }
    });



    ko.bindingHandlers.select2 = {
        after: ["options", "value"],
        init: function (el, valueAccessor, allBindingsAccessor, viewModel) {
            $(el).select2(ko.unwrap(valueAccessor()));
            ko.utils.domNodeDisposal.addDisposeCallback(el, function () {
                $(el).select2('destroy');
            });
        },
        update: function (el, valueAccessor, allBindingsAccessor, viewModel) {
            var allBindings = allBindingsAccessor();
            var select2 = $(el).data("select2");
            if ("value" in allBindings) {
                var newValue = "" + ko.unwrap(allBindings.value);
                if ((allBindings.select2.multiple || el.multiple) && newValue.constructor !== Array) {
                    select2.val([newValue.split(",")]);
                } else {
                    select2.val([newValue]);
                }
            }
        }
    };


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

        self.m_coa_opt = ko.observableArray(<?= json_encode($m_coa) ?>);

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

    }

    ko.applyBindings(new journal_list_model(), document.getElementById('ko-journal'));
</script>