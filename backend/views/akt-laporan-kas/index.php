<?php

use yii\helpers\Html;

$this->title = 'Daftar Laporan Kas';
?>

<div class="absensi-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <div class="box">
        <div class="panel panel-primary">
            <div class="panel-heading"><span class="fa fa-file-text"></span> <?= $this->title ?></div>
            <div class="panel-body">
                <div class="col-md-12" style="padding: 0;">
                    <div class="box-body">
                        <table class="table table-condensed">
                            <tr>
                                <td><?= Html::a('<span class="fa fa-file-text"></span> Laporan Kartu Kas', ['laporan-kartu-kas']) ?></td>
                            </tr>
                            <tr>
                                <td><?= Html::a('<span class="fa fa-file-text"></span> Laporan Transfer Kas', ['laporan-transfer-kas']) ?></td>
                            </tr>
                            <tr>
                                <td><?= Html::a('<span class="fa fa-file-text"></span> Laporan Detail Pembayaran', ['laporan-detail-pembayaran']) ?></td>
                            </tr>
                            <tr>
                                <td><?= Html::a('<span class="fa fa-file-text"></span> Laporan Detail Penerimaan Pembayaran', ['laporan-detail-penerimaan-pembayaran']) ?></td>
                            </tr>
                            <tr>
                                <td><?= Html::a('<span class="fa fa-file-text"></span> Laporan Rekap Transfer Kas', ['laporan-rekap-transfer-kas']) ?></td>
                            </tr>
                            <tr>
                                <td><?= Html::a('<span class="fa fa-file-text"></span> Laporan Rekap Arus Kas', ['akt-rekap-arus-kas']) ?></td>
                            </tr>
                            <tr>
                                <td><?= Html::a('<span class="fa fa-file-text"></span> Laporan Saldo Uang Muka', ['laporan-saldo-uang-muka']) ?></td>
                            </tr>
                            <tr>
                                <td><?= Html::a('<span class="fa fa-file-text"></span> Laporan Hutang vs Piutang Jatuh Tempo', ['laporan-hutang-vs-piutang'])
                                    ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>