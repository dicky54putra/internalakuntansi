<?php

use yii\helpers\Html;
use kartik\select2\Select2;
use backend\models\AktAkun;
use backend\models\AktKlasifikasi;
use backend\models\AktSaldoAwalAkun;
use backend\models\AktSaldoAwalAkunDetail;

$this->title = 'Laporan Arus Kas';
?>

<div class="absensi-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Daftar Laporan Akuntansi', ['index']) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['index'], ['class' => 'btn btn-warning']) ?>
    </p>

    <div class="box">
        <div class="panel panel-primary">
            <div class="panel-heading"><span class="fa fa-file-text"></span> <?= $this->title ?></div>
            <div class="panel-body">
                <div class="col-md-12" style="padding: 0;">
                    <div class="box-body">

                        <?= Html::beginForm(['', array('class' => 'form-inline')]) ?>

                        <table border="0" width="100%">
                            <tr>
                                <td width="10%">
                                    <div class="form-group">Dari Tanggal</div>
                                </td>
                                <td align="center" width="5%">
                                    <div class="form-group">:</div>
                                </td>
                                <td width="30%">
                                    <div class="form-group">
                                        <input type="date" name="tanggal_awal" class="form-control" required>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td width="10%">
                                    <div class="form-group">Sampai Tanggal</div>
                                </td>
                                <td align="center" width="5%">
                                    <div class="form-group">:</div>
                                </td>
                                <td width="30%">
                                    <div class="form-group">
                                        <input type="date" name="tanggal_akhir" class="form-control" required>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td>
                                    <div class="form-group">
                                        <?= Html::submitButton('Submit', ['class' => 'btn btn-success']) ?>
                                    </div>
                                </td>
                            </tr>
                        </table>

                        <?= Html::endForm() ?>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
    if (!empty($tanggal_awal) && !empty($tanggal_akhir)) {
        # code...
    ?>
        <p style="font-weight: bold; font-size: 20px;">
            <?= 'Periode : ' . date('d/m/Y', strtotime($tanggal_awal)) . ' s/d ' . date('d/m/Y', strtotime($tanggal_akhir)) ?>
            <?= Html::a('Cetak', ['laporan-arus-kas-cetak', 'tanggal_awal' => $tanggal_awal, 'tanggal_akhir' => $tanggal_akhir], ['class' => 'btn btn-primary', 'target' => '_blank', 'method' => 'post']) ?>
            <?= Html::a('Export', ['laporan-arus-kas-excel', 'tanggal_awal' => $tanggal_awal, 'tanggal_akhir' => $tanggal_akhir], ['class' => 'btn btn-success', 'target' => '_blank', 'method' => 'post']) ?>
        </p>

        <div class="box">
            <div class="panel panel-primary">
                <div class="panel-heading">Arus kas dari aktivitas operasi</div>
                <div class="panel-body">
                    <div class="col-md-12" style="padding: 0;">
                        <div class="box-body">

                            <table class="table">
                                <thead>
                                    <?php
                                    $saldo_awal = AktSaldoAwalAkunDetail::find()
                                        ->select('*')
                                        ->innerJoin('akt_akun', 'akt_akun.id_akun = akt_saldo_awal_akun_detail.id_akun')
                                        ->where(['=', 'akt_akun.nama_akun', 'kas'])
                                        ->limit(1)
                                        ->one();
                                    ?>
                                    <tr>
                                        <td>Saldo Awal Kas</td>
                                        <td style="text-align: right;width: 20%;">
                                            <?php
                                            if (!empty($saldo_awal->debet)) {
                                                $saldo_awal_ = $saldo_awal->debet;
                                                echo ribuan($saldo_awal->debet);
                                            } elseif (!empty($saldo_awal->kredit)) {
                                                echo '-' . ribuan($saldo_awal->kredit);
                                                $saldo_awal_ = $saldo_awal->kredit;
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <?php
                                    $kredit = 0;
                                    $debit = 0;
                                    foreach ($jurnal_umum_detail as $k) {
                                        $akun = AktAkun::find()->where(['id_akun' => $k->id_akun])->one();
                                        // $akun = 
                                        // echo $k->id_akun;
                                        // var_dump($akun->nama_akun);
                                    ?>
                                        <tr>
                                            <td><?= $k->keterangan ?></td>
                                            <td style="text-align: right;width: 20%;">
                                                <?php
                                                if ($k->kredit == 0) {
                                                    echo ribuan($k->debit);
                                                } elseif ($k->debit == 0) {
                                                    echo '-' . ribuan($k->kredit);
                                                }
                                                ?></td>
                                        </tr>
                                    <?php
                                        $debit += $k->debit;
                                        $kredit += $k->kredit;
                                    }
                                    // die; 
                                    ?>
                                    <!-- <tr>
                                        <td>Dikurangi pembayaran kas untuk beban dan pembayaran untuk kreditor</td>
                                        <td style="text-align: right;width: 20%;">0</td>
                                    </tr> -->
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th style="text-align: right;">Arus kas bersih dari aktivitas operasi</th>
                                        <th style="text-align: right;width: 20%;color: white" bgcolor="grey">
                                            <?php
                                            if (!empty($saldo_awal->debet)) {
                                                $hasil = $saldo_awal->debet + $debit - $kredit;
                                                // echo 'Rp. ' . ribuan($hasil);
                                                echo ribuan($hasil);
                                            } elseif (!empty($saldo_awal->kredit)) {
                                                $hasil = $debit - $kredit - $saldo_awal->debet;
                                                // echo 'Rp. ' . ribuan($hasil);
                                                echo ribuan($hasil);
                                            }
                                            ?>
                                        </th>
                                    </tr>
                                </tfoot>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="box hidden">
            <div class="panel panel-primary">
                <div class="panel-heading">Arus kas dari aktivitas investasi</div>
                <div class="panel-body">
                    <div class="col-md-12" style="padding: 0;">
                        <div class="box-body">

                            <table class="table">
                                <thead>
                                    <tr>
                                        <td>Kas yang diterima dari investasi</td>
                                        <td style="text-align: right;width: 20%;">0</td>
                                    </tr>
                                    <tr>
                                        <td>Pembayaran kas untuk investasi</td>
                                        <td style="text-align: right;width: 20%;">0</td>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th style="text-align: right;">Arus kas bersih dari aktivitas investasi</th>
                                        <th style="text-align: right;width: 20%;color: white" bgcolor="grey">0</th>
                                    </tr>
                                </tfoot>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="box hidden">
            <div class="panel panel-primary">
                <div class="panel-heading">Arus kas dari aktivitas pendanaan</div>
                <div class="panel-body">
                    <div class="col-md-12" style="padding: 0;">
                        <div class="box-body">

                            <table class="table">
                                <thead>
                                    <tr>
                                        <td>Kas yang diterima sebagai investasi pemilik</td>
                                        <td style="text-align: right;width: 20%;">0</td>
                                    </tr>
                                    <tr>
                                        <td>Dikurangi penarikan kas oleh pemilik</td>
                                        <td style="text-align: right;width: 20%;">0</td>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th style="text-align: right;">Arus kas bersih dari aktivitas pendanaan</th>
                                        <th style="text-align: right;width: 20%;color: white" bgcolor="grey">0</th>
                                    </tr>
                                </tfoot>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="box hidden">
            <div class="panel panel-primary">
                <div class="panel-heading"></div>
                <div class="panel-body">
                    <div class="col-md-12" style="padding: 0;">
                        <div class="box-body">

                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Kenaikan (Penurunan) Bersih Kas dan Setara Ka</th>
                                        <th style="text-align: right;width: 20%;color: white;" bgcolor="#337ab7">0</th>
                                    </tr>
                                    <tr>
                                        <th>Kas bersih dan saldo kas awal periode</th>
                                        <th style="text-align: right;width: 20%;color: white;" bgcolor="grey">0</th>
                                    </tr>
                                    <tr>
                                        <th>Kas bersih dan saldo kas akhir periode</th>
                                        <th style="text-align: right;width: 20%;color: white;" bgcolor="grey">0</th>
                                    </tr>
                                </thead>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    <?php } ?>

</div>