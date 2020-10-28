<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\Login;
/* @var $this yii\web\View */
/* @var $model backend\models\AktLabaRugi */

$this->title = 'Detail Laporan  Perubahan Ekuitas + Posisi Keuangan';
\yii\web\YiiAsset::register($this);
?>
<style>
    .table-ekuitas td {
        font-size: 18px;
        padding: 5px;
    }

    .table-border td,
    th {
        border: 1px solid #ddd;
        text-align: left;
    }

    table {
        border-collapse: collapse;
        width: 100%;
    }

    .table-border th,
    .table-border td {
        padding: 15px;
    }
</style>
<div class="akt-laba-rugi-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Laporan Laba Rugi + Perubahan Ekuitas + Posisi Keuangan', ['index']) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['index'], ['class' => 'btn btn-warning']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-edit"></span> Ubah', ['update', 'id' => $model->id_laba_rugi], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-trash"></span> Hapus', ['delete', 'id' => $model->id_laba_rugi], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Apakah anda yakin akan menghapus data ini? ini juga akan menghapus laporan yang sudah tersimpan.',
                'method' => 'post',
            ],
        ]) ?>
        <?php if ($model->status == 1) { ?>
            <?= Html::a('<span class="glyphicon glyphicon-print"></span> Cetak', ['cetak', 'id' => $model->id_laba_rugi], ['class' => 'btn btn-default', 'target' => '_blank']) ?>
        <?php } ?>
    </p>
    <div class="box">
        <div class="panel panel-primary">
            <div class="panel-heading"><span class="fa fa-file-text"></span> <?= $this->title ?></div>
            <div class="panel-body">
                <div class="col-md-12" style="padding: 0;">
                    <div class="box-body">
                        <?= DetailView::widget([
                            'model' => $model,
                            'attributes' => [
                                [
                                    'attribute' => 'tanggal',
                                    'value' => function ($model) {
                                        return tanggal_indo($model->tanggal);
                                    }
                                ],
                                [
                                    'attribute' => 'periode',
                                    'value' => function ($model) {
                                        if ($model->periode == 1) {
                                            return 'Bulanan';
                                        } else if ($model->periode == 2) {
                                            return 'Triwulan 1';
                                        } else if ($model->periode == 3) {
                                            return 'Triwulan 2';
                                        } else if ($model->periode == 4) {
                                            return 'Triwulan 3';
                                        } else if ($model->periode == 5) {
                                            return 'Triwulan 4';
                                        } else if ($model->periode == 6) {
                                            return 'Tahunan';
                                        }
                                    }
                                ],
                                [
                                    'attribute' => 'id_login',
                                    'format' => 'raw',
                                    'label' => 'Penyimpan',
                                    'value' => function ($model) {
                                        if ($model->id_login == null) {
                                            return 'Data ini belum disimpan';
                                        } else {
                                            $approver = Login::findOne($model->id_login);
                                            $date = tanggal_indo2(date('D, d F Y H:i', strtotime($model->tanggal_approve)));
                                            return "<span class='label label-success'>Data ini sudah disimpan pada " . $date . " oleh " . $approver->nama . "</span>";
                                        }
                                    }
                                ],
                            ],
                        ]) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="box">
        <div class="panel panel-primary">
            <div class="panel-body">
                <div class="col-md-12" style="padding: 0;">

                    <div class="box-body">

                        <ul class="nav nav-tabs" style="margin-bottom: 30px;">
                            <li class="active"><a data-toggle="tab" href="#laporan-laba-rugi">Laporan Laba Rugi</a></li>
                            <li><a data-toggle="tab" href="#laporan-ekuitas">Laporan Ekuitas</a></li>
                            <li><a data-toggle="tab" href="#laporan-posisi-keuangan">Laporan Posisi Keuangan</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="laporan-laba-rugi tab-pane fade in active" id="laporan-laba-rugi"">
                                <table class=" table-responsive table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th width="70%">Pendapatan</th>
                                        <th>Nominal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $total = 0;
                                    $no = 1;
                                    foreach ($akun as $data) {
                                        $total += $data['saldo_akun'];
                                    ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td> <?= $data['nama_akun'] ?></td>
                                            <td align="right"> <?= ribuan($data['saldo_akun']) ?></td>
                                        </tr>
                                    <?php } ?>

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td align="left" colspan="2">Total Pendapatan</td>
                                        <td align="right"><?= ribuan($total) ?></td>
                                    </tr>
                                </tfoot>
                                </table>
                                <table class="table-responsive table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th width="70%">Beban</th>
                                            <th>Nominal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no2 = 1;
                                        $total2 = 0;
                                        foreach ($beban as $data2) {
                                            $total2 += $data2['saldo_akun'];
                                        ?>
                                            <tr>
                                                <td> <?= $no2++ ?></td>
                                                <td> <?= $data2['nama_akun'] ?></td>
                                                <td align="right"> <?= ribuan($data2['saldo_akun']) ?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td align="left" colspan="2">Total Beban</td>
                                            <td align="right">(<?= ribuan($total2) ?>)</td>
                                        </tr>
                                        <tr>
                                            <td align="left" colspan="2" style="font-weight: bold;">Laba Bersih</td>
                                            <td align="right" style="font-weight: bold;">
                                                <?php
                                                $grandtotal = $total - $total2;
                                                if ($grandtotal >= 0) {
                                                    echo ribuan($total - $total2);
                                                } else {
                                                    echo '(' . ribuan($total - $total2) . ')';
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                    </tfoot>

                                </table>
                            </div>
                            <div class="tab-pane fade" id="laporan-ekuitas">
                                <table class="table-ekuitas" width="100%">
                                    <?php foreach ($ekuitas as $e) { ?>
                                        <tr>
                                            <td width="50%">Modal</td>
                                            <td width="5%">:</td>
                                            <td><?= ribuan($e->modal) ?></td>
                                        </tr>
                                        <tr>
                                            <td>Setoran modal tambahan</td>
                                            <td>:</td>
                                            <td>
                                                <?= ribuan($e->setor_tambahan) ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Laba Bersih</td>
                                            <td>:</td>
                                            <td>
                                                <?= ribuan($e->laba_bersih) ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Prive</td>
                                            <td>:</td>
                                            <td>
                                                <?= ribuan($e->prive) ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Total</td>
                                            <td>:</td>
                                            <td>
                                                <?= ribuan($e->modal + $e->setor_tambahan + $e->laba_bersih - $e->prive) ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </table>
                            </div>
                            <div class="tab-pane fade" id="laporan-posisi-keuangan">
                                <table class="table-border">
                                    <?php foreach ($jenis as $p) {
                                        if ($p['jenis'] == 1) {
                                            $nama_jenis = 'Aset Lancar';
                                        } elseif ($p['jenis'] == 2) {
                                            $nama_jenis = 'Aset Tetap';
                                        } elseif ($p['jenis'] == 3) {
                                            $nama_jenis = 'Aset Tetap Tidak Berwujud';
                                        } elseif ($p['jenis'] == 4) {
                                            $nama_jenis = 'Pendapatan';
                                        } elseif ($p['jenis'] == 5) {
                                            $nama_jenis = 'Liabilitas Jangka Pendek';
                                        } elseif ($p['jenis'] == 6) {
                                            $nama_jenis = 'Liabilitas Jangka Panjang';
                                        } elseif ($p['jenis'] == 7) {
                                            $nama_jenis = 'Ekuitas';
                                        } elseif ($p['jenis'] == 8) {
                                            $nama_jenis = 'Beban';
                                        }

                                        $lap_posisi = Yii::$app->db->createCommand("SELECT akt_laporan_posisi_keuangan.id_akun,akt_laporan_posisi_keuangan.nominal,akt_akun.nama_akun,akt_akun.jenis FROM akt_laporan_posisi_keuangan LEFT JOIN akt_akun ON akt_akun.id_akun = akt_laporan_posisi_keuangan.id_akun WHERE id_laba_rugi = '$model->id_laba_rugi' AND akt_akun.jenis = '$p[jenis]'")->query();


                                    ?>
                                        <tr>
                                            <td style="font-weight: bold;" colspan="2"><?= $nama_jenis ?></td>
                                        </tr>
                                        <?php
                                        $total_saldo = 0;
                                        foreach ($lap_posisi as $a) {
                                            if ($a['id_akun'] == 6 || $a['id_akun'] == 7 || $a['id_akun'] == 8) {
                                                $total_saldo = $total_saldo - $a['nominal'];
                                            } else {
                                                $total_saldo += $a['nominal'];
                                            }
                                        ?>
                                            <tr>
                                                <td><?= $a['nama_akun'] ?></td>
                                                <td align="right"><?= ribuan($a['nominal']) ?></td>
                                            </tr>

                                        <?php } ?>
                                        <tr>
                                            <td style="font-weight: bold; text-align:right;">Total</td>
                                            <td align="right"><?= ribuan($total_saldo) ?></td>
                                        </tr>
                                    <?php }  ?>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>