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

<?php if (empty(trim($id_journal))) { ?>
            self.journal_list.push(new add_journal_list('', '', '', ''));
<?php } ?>

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

        $('#save-default').click(function () {
            $('input[name=save_type]').val('0');
            $('#form-journal').submit();
        });
        $('#save-draft').click(function () {
            $('input[name=save_type]').val('1');
            $('#form-journal').submit();
        });
        change_row_handle();

        $('#form-journal').submit(function (e) {
            e.preventDefault();

            $('.submit-button').prop('disabled', true);

            $.ajax({
                url: "<?= base_url() . $url_controller ?>submit/", // Url to which the request is send
                type: "POST", // Type of request to be send, called as method
                data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
                contentType: false, // The content type used when sending data to the server.
                cache: false, // To unable request pages to be cached
                processData: false, // To send DOMDocument or non processed data file it is set to false
                success: function (data) // A function to be called if request succeeds
                {
                    console.log(data);

                    write_error(data.error_arr);
                    if (!data.status) {
                        $('#alert-error').show();
                        $('#alert-error-html').html(data.message);
                        setTimeout(function () {
                            $('#alert-error').fadeOut('slow');
                        }, 5000);
                    } else {
                        window.location = '<?= base_url() . $url_controller ?>';
                        console.log(data);
                    }

                    setTimeout(function () {
                        $('.submit-button').prop('disabled', false);
                    }, 200);
                },
                error: function (err) {
                    $('.submit-button').prop('disabled', false);
                    $('#alert-error').show();
                    $('#alert-error-html').html("Terjadi Kesalahan, Cek Koneksi Internet Anda");
                    setTimeout(function () {
                        $('#alert-error').fadeOut('slow');
                    }, 5000);
                    console.log(err);
                }
            });
        });

        $('#alert-error').click(function () {
            $(this).hide();
        });

    });

</script>