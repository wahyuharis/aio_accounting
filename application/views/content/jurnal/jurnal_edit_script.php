<script>
    $(document).ready(function () {
        $('#table-jurnal > tbody > tr').on('keyup', function () {
            console.log($(this).html());
        });
    });

    function add_journal_list(coa, debit, kredit, keterangan) {
        var self = this;

        self.coa = ko.observable(coa);
        self.debit = ko.observable(debit);
        self.kredit = ko.observable(kredit);
        self.keterangan = ko.observable(keterangan);
    }


    function journal_list_model() {
        var self = this;
        self.journal_list = ko.observableArray([]);
        
    }

    ko.applyBindings(new journal_list_model(), document.getElementById('ko-journal'));
</script>