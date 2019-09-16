<style>
    .table-bordered>thead>tr>th,
    .table-bordered>tbody>tr>th,
    .table-bordered>tfoot>tr>th,
    .table-bordered>thead>tr>td,
    .table-bordered>tbody>tr>td,
    .table-bordered>tfoot>tr>td {
        border: 1px solid #ccc;
    }
    .container-cb {
        display: block;
        position: relative;
        padding-left: 35px;
        margin-bottom: 25px;
        cursor: pointer;
        font-size: 22px;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    /* Hide the browser's default checkbox */
    .container-cb input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
        height: 0;
        width: 0;
    }

    /* Create a custom checkbox */
    .checkmark {
        position: absolute;
        top: 0;
        left: 0;
        height: 25px;
        width: 25px;
        /*background-color: #eee;*/
        border:1px solid #aaa;
    }

    /* On mouse-over, add a grey background color */
    .container-cb:hover input ~ .checkmark {
        /*background-color: #ccc;*/
    }

    /* When the checkbox is checked, add a blue background */
    .container-cb input:checked ~ .checkmark {
        /*background-color: #2196F3;*/
    }

    /* Create the checkmark/indicator (hidden when not checked) */
    .checkmark:after {
        content: "";
        position: absolute;
        display: none;
    }

    /* Show the checkmark when checked */
    .container-cb input:checked ~ .checkmark:after {
        display: block;
    }

    /* Style the checkmark/indicator */
    .container-cb .checkmark:after {
        left: 7px;
        top: 0px;
        width: 8px;
        height: 17px;
        border: solid #5d5d5d;
        border-width: 0 3px 3px 0;
        -webkit-transform: rotate(45deg);
        -ms-transform: rotate(45deg);
        transform: rotate(45deg);
    }
</style>
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title panel_title"><?= $panel_title ?></h3>
    </div>
    <div class="box-body">
        <?= $content ?>
    </div>
</div>

<script>
    $(document).ready(function () {
        title_act = $('.title-act').html();
//        alert(title_act);
        $('.panel_title').html(title_act);
    });
</script>

