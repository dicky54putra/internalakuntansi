<style>
    .table1 {
        text-align: left;
        font-family: 'Source Sans Pro', 'Helvetica Neue', Helvetica, Arial, sans-serif;
        width: 100%;
        padding: 3px;
    }

    .table1 th,
    .table1 td {
        padding: 0px;
    }

    @media print {
        @page {
            size: auto;
            margin: 0mm;
        }
    }

    .margin-style {
        margin: 40px;
    }
</style>
<div class="margin-style">
    <table class="table1" border="0">
        <thead>
            <tr>
                <th>Kepada : <?= $model->penerima ?></th>
            </tr>
        </thead>
    </table>
    <table class="table1" border="0">
        <thead>
            <tr>
                <th style="width: 50%;">Pengirim :</th>
                <td style="width: 50%;"><strong>Ekspedisi : </strong><?= $model->pengantar ?></td>
            </tr>
            <tr>
                <td colspan="2"><?= $data_setting->nama ?></td>
            </tr>
            <tr>
                <td colspan="2"><?= $data_setting->alamat ?></td>
            </tr>
            <tr>
                <td colspan="2"><?= $data_setting->kota->nama_kota ?></td>
            </tr>
            <tr>
                <td colspan="2">Telephone : <?= $data_setting->telepon ?></td>
            </tr>
        </thead>
    </table>
</div>
<script>
    window.print();
    setTimeout(window.close, 1000);
</script>