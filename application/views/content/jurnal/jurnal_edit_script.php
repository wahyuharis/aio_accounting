<script>
    $(document).ready(function () {
        $('#table-jurnal > tbody > tr').on('keyup', function () {
            console.log( $(this).html() );
        });
    });
</script>