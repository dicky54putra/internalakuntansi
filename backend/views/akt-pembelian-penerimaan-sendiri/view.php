<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\AktPembelianDetail;
use backend\models\AktItemStok;
use backend\models\AktItem;
use backend\models\AktGudang;
use backend\models\AktPembelianPenerimaan;
use backend\models\AktPembelianPenerimaanDetail;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\Aktpembelian */

$this->title = 'Detail Data Penerimaan. No Pembelian : ' . $model->no_pembelian;
// $this->params['breadcrumbs'][] = ['label' => 'Akt pembelians', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="akt-pembelian-pembelian-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Data Penerimaan Pembelian', ['index']) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['index'], ['class' => 'btn btn-warning']) ?>

        <?php if ($sum_penerimaan_detail < $sum_pembelian_detail) { ?>
            <!-- <?= Html::a('<span class="glyphicon glyphicon-flag"></span> Terima Barang', '#', [
                        'class' => 'btn btn-info terima',
                        'data-toggle' => 'modal',
                        'data-target' => '#modal-default',
                        'id-pembelian' => $model->id_pembelian
                    ]) ?> -->
            <?= Html::button(
                '<span class="glyphicon glyphicon-flag"></span> Terima Barang',
                [
                    'value' => Url::to(['akt-pembelian-penerimaan/create', 'id' => $model->id_pembelian]),
                    'title' => ' Terima Barang', 'class' => 'showModalButton btn btn-info'
                ]
            ); ?>

        <?php } ?>

        <?php if ($model->status == 3) {  ?>

            <?= Html::a('<span class="glyphicon glyphicon-edit"></span> Ubah Data Penerimaan Pembelian', ['update-data-pembelian-penerimaan', 'id' => $model->id_pembelian], ['class' => 'btn btn-primary']) ?>

            <?php if ($count_data_penerimaan_count == 0 && $count_data_penerimaan_count2 == 0) { ?>

                <?php
                // Html::a('<span class="glyphicon glyphicon-ok"></span> Di Terima', ['terima', 'id' => $model->id_pembelian], [
                //     'class' => 'btn btn-success',
                //     'data' => [
                //         'confirm' => 'Apakah anda yakin telah melakukan Penerimaan Data Penerimaan Pembelian : ' . $model->no_penerimaan . ' ?',
                //         'method' => 'post',
                //     ],
                // ]) 
                ?>

        <?php }
        } ?>


    </p>

    <div class="panel panel-primary">
        <div class="panel-heading"><span class="fa fa-truck"></span> <?= $this->title ?></div>
        <div class="panel-body">
            <div class="col-md-12" style="padding: 0;">
                <div class="box-body">

                    <!-- Pembelian -->

                    <div class="row">
                        <div class="col-md-6">
                            <?= DetailView::widget([
                                'model' => $model_pembelian,
                                'template' => '<tr><th style="width:40%;">{label}</th><td>{value}</td></tr>',
                                'attributes' => [
                                    // 'id_pembelian',
                                    'no_pembelian',
                                    [
                                        'attribute' => 'tanggal_pembelian',
                                        'value' => function ($model_pembelian) {
                                            if (!empty($model_pembelian->tanggal_pembelian)) {
                                                # code...
                                                return tanggal_indo($model_pembelian->tanggal_pembelian, true);
                                            } else {
                                                # code...
                                            }
                                        }
                                    ],
                                    [
                                        'atribute' => 'no_faktur_pembelian',
                                        'label' => 'No Faktur Pajak',
                                        'value' =>  function ($model_pembelian) {
                                            if (!empty($model_pembelian->no_faktur_pembelian)) {
                                                # code...
                                                return $model_pembelian->no_faktur_pembelian;
                                            }
                                        }
                                    ],
                                    [
                                        'attribute' => 'tanggal_faktur_pembelian',
                                        'label' => 'Tanggal Faktur Pajak',
                                        'value' => function ($model_pembelian) {
                                            if (!empty($model_pembelian->tanggal_faktur_pembelian)) {
                                                # code...
                                                return tanggal_indo($model_pembelian->tanggal_faktur_pembelian, true);
                                            } else {
                                                # code...
                                            }
                                        }
                                    ],
                                ],
                            ]) ?>
                        </div>
                        <div class="col-md-6">
                            <?= DetailView::widget([
                                'model' => $model_pembelian,
                                'template' => '<tr><th style="width:40%;">{label}</th><td>{value}</td></tr>',
                                'attributes' => [
                                    // 'id_pembelian',
                                    [
                                        'attribute' => 'jenis_bayar',
                                        'value' => function ($model_pembelian) {
                                            if ($model_pembelian->jenis_bayar == 1) {
                                                # code...
                                                return 'CASH';
                                            } elseif ($model_pembelian->jenis_bayar == 2) {
                                                # code...
                                                return 'CREDIT';
                                            } else {
                                                # code...
                                            }
                                        }
                                    ],
                                    [
                                        'attribute' => 'jatuh_tempo',
                                        'visible' => ($model_pembelian->jenis_bayar == 2) ? true : false,
                                    ],
                                    [
                                        'attribute' => 'tanggal_tempo',
                                        'visible' => ($model_pembelian->jenis_bayar == 2) ? true : false,
                                        'value' => function ($model_pembelian) {
                                            if (!empty($model_pembelian->tanggal_tempo)) {
                                                # code...
                                                return tanggal_indo($model_pembelian->tanggal_tempo, true);
                                            } else {
                                                # code...
                                            }
                                        }
                                    ],
                                    [
                                        'attribute' => 'status',
                                        'format' => 'raw',
                                        'value' => function ($model_pembelian) {
                                            if ($model_pembelian->status == 1) {
                                                # code...
                                                return "<span class='label label-default'>Order Pembelian</span>";
                                            } elseif ($model_pembelian->status == 2) {
                                                # code...
                                                return "<span class='label label-warning'>Pembelian</span>";
                                            } elseif ($model_pembelian->status == 3) {
                                                # code...
                                                return "<span class='label label-primary'>Penerimaan</span>";
                                            } elseif ($model_pembelian->status == 4) {
                                                # code...
                                                return "<span class='label label-success'>Selesai</span>";
                                            } elseif ($model_pembelian->status == 5) {
                                                # code...
                                                return "<span class='label label-info'>Proses Penerimaan</span>";
                                            }
                                        }
                                    ],
                                ],
                            ]) ?>
                        </div>
                    </div>


                    <!-- end pembelian -->
                    <div class="row hidden">
                        <div class="col-md-6">
                            <?= DetailView::widget([
                                'model' => $model,
                                'template' => '<tr><th style="width:40%;">{label}</th><td>{value}</td></tr>',
                                'attributes' => [
                                    // 'id_pembelian',
                                    'no_penerimaan',
                                    [
                                        'attribute' => 'tanggal_penerimaan',
                                        'value' => function ($model) {
                                            if (!empty($model->tanggal_penerimaan)) {
                                                # code...
                                                return tanggal_indo2(date('D, d F Y H:i', strtotime($model->tanggal_penerimaan)));
                                            } else {
                                                # code...
                                            }
                                        }
                                    ],
                                    'pengantar',
                                    // 'no_spb',
                                    [
                                        'attribute' => 'no_spb',
                                        'label' => 'No SPB',
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            return $model->no_spb;
                                        }
                                    ],
                                    [
                                        'attribute' => 'status',
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            if ($model->status == 1) {
                                                # code...
                                                return "<span class='label label-default'>Order Pembelian</span>";
                                            } elseif ($model->status == 2) {
                                                # code...
                                                return "<span class='label label-warning'>Pembelian</span>";
                                            } elseif ($model->status == 3) {
                                                # code...
                                                return "<span class='label label-primary'>Belum diterima</span>";
                                            } elseif ($model->status == 4) {
                                                # code...
                                                return "<span class='label label-success'>Diterima</span>";
                                            } elseif ($model->status == 5) {
                                                # code...
                                                return "<span class='label label-info'>Proses Penerimaan</span>";
                                            }
                                        }
                                    ],
                                ],
                            ]) ?>
                        </div>
                        <div class="col-md-6">
                            <?= DetailView::widget([
                                'model' => $model,
                                'template' => '<tr><th style="width:40%;">{label}</th><td>{value}</td></tr>',
                                'attributes' => [
                                    // 'id_pembelian',
                                    'keterangan_penerimaan',
                                    [
                                        'attribute' => 'tanggal_penerimaan',
                                        'value' => function ($model) {
                                            if (!empty($model->tanggal_penerimaan)) {
                                                # code...
                                                return tanggal_indo2(date('D, d F Y H:i', strtotime($model->tanggal_penerimaan)));
                                            } else {
                                                # code...
                                            }
                                        }
                                    ],
                                    'penerima',
                                    // [
                                    //     'attribute' => 'id_mitra_bisnis_alamat',
                                    //     'format' => 'raw',
                                    //     'value' => function ($model) {
                                    //         if (!empty($model->mitra_bisnis_alamat->keterangan_alamat)) {
                                    //             # code...
                                    //             return $model->mitra_bisnis_alamat->keterangan_alamat . '<br>' . $model->mitra_bisnis_alamat->alamat_lengkap . '<br>' . $model->mitra_bisnis_alamat->kota->nama_kota;
                                    //         } else {
                                    //             # code...
                                    //         }
                                    //     }
                                    // ],
                                ],
                            ]) ?>
                        </div>
                    </div>

                    <div class="" style="margin-top:20px;">
                        <ul class="nav nav-tabs" id="tabForRefreshPage">
                            <li class="active"><a data-toggle="tab" href="#data-barang"><span class="fa fa-box"></span> Data Barang Pembelian</a></li>
                            <li><a data-toggle="tab" href="#data-penerimaan"><span class="fa fa-box"></span> Data Penerimaan Barang</a></li>
                        </ul>
                        <div class="tab-content">

                            <div id="data-barang" class="tab-pane fade in active" style="margin-top:20px;">
                                <div class="row" style="margin-top:30px;">
                                    <div class="col-md-12" style="overflow: auto;">

                                        <table id="barang" class="table">
                                            <thead>
                                                <tr>
                                                    <th style="width: 1%;">#</th>
                                                    <th>Kode Barang</th>
                                                    <th>Nama Barang</th>
                                                    <th>Qty</th>
                                                    <th>Qty Diterima</th>
                                                    <th>Keterangan</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $no = 1;
                                                $query_detail = AktPembelianDetail::find()->where(['id_pembelian' => $model->id_pembelian])->all();
                                                foreach ($query_detail as $key => $data) {
                                                    # code...
                                                    $item_stok = AktItemStok::findOne($data['id_item_stok']);
                                                    $item = AktItem::findOne($item_stok->id_item);
                                                    $gudang = AktGudang::findOne($item_stok->id_gudang);
                                                ?>
                                                    <tr>
                                                        <td><?= $no++ . '.' ?></td>
                                                        <td><?= (!empty($item->kode_item)) ? $item->kode_item : '' ?></td>
                                                        <td><?= (!empty($item->nama_item)) ? $item->nama_item : '' ?></td>
                                                        <td><?= $data['qty'] ?></td>
                                                        <td>
                                                            <?php
                                                            $pembelian_penerimaan_detail = Yii::$app->db->createCommand("SELECT SUM(akt_pembelian_penerimaan_detail.qty_diterima) FROM `akt_pembelian_penerimaan_detail` INNER JOIN `akt_pembelian_detail` ON akt_pembelian_detail.id_pembelian_detail = akt_pembelian_penerimaan_detail.id_pembelian_detail INNER JOIN `akt_item_stok` ON akt_item_stok.id_item_stok = akt_pembelian_detail.id_item_stok INNER JOIN `akt_item` ON akt_item.id_item = akt_item_stok.id_item WHERE akt_pembelian_detail.id_pembelian_detail=" . $data['id_pembelian_detail'] . "")->queryScalar();
                                                            // var_dump($pembelian_penerimaan_detail);
                                                            if (!empty($pembelian_penerimaan_detail)) {
                                                                $ppd = $pembelian_penerimaan_detail;
                                                                echo $ppd;
                                                            } else {
                                                                $ppd = 0;
                                                                echo "0";
                                                            }
                                                            ?>
                                                        </td>
                                                        <td><?= $data['keterangan'] ?></td>
                                                        <td>
                                                            <?php
                                                            if ($ppd == 0) {
                                                                echo '<label class="label label-danger">Belum Diterima</label>';
                                                            } else {
                                                                if ($ppd < $data['qty']) {
                                                                    echo '<label class="label label-warning">Proses Pennerimaan</label>';
                                                                } else {
                                                                    echo '<label class="label label-success">Diterima</label>';
                                                                }
                                                            }
                                                            ?>
                                                        </td>
                                                    </tr>
                                                <?php
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div id="data-penerimaan" class="tab-pane fade in" style="margin-top:20px;">
                                <div class="box-group" id="accordion">
                                    <?php
                                    $penerimaan = AktPembelianPenerimaan::find()->where(['id_pembelian' => $model->id_pembelian])->all();
                                    $no = 1;
                                    foreach ($penerimaan as $d) {
                                    ?>
                                        <div class="panel">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $no; ?>" aria-expanded="true" aria-controls="collapseOne" class="drop">
                                                        #<?php echo $no . ' : ' . $d->no_penerimaan  . ' | ' . tanggal_indo($d->tanggal_penerimaan) ?>
                                                    </a>

                                                </div>
                                                <div class="col-sm-6">
                                                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $no; ?>" aria-expanded="true" aria-controls="collapseOne" style="float: right; margin-left:5px; transition: 0.5s;" class="btn btn-success drop btn-sm btn-flat">
                                                        <span id="glyphicon" style="transition: 0.5s;" class="glyphicon glyphicon-chevron-down"></span>
                                                    </a>
                                                    <?= Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete-pembelian-penerimaan', 'id' => $d->id_pembelian_penerimaan], [
                                                        'class' => 'btn btn-danger btn-sm btn-flat',
                                                        'style' => [
                                                            'float' => 'right',
                                                            'margin-left' => '5px'
                                                        ],
                                                    ]) ?>

                                                    <?= Html::button(
                                                        '<span class="glyphicon glyphicon-edit"></span>',
                                                        [
                                                            'value' => Url::to(['akt-pembelian-penerimaan/update', 'id' => $d->id_pembelian_penerimaan]),
                                                            'title' => ' Terima Barang', 'class' => 'showModalButton btn btn-primary btn-sm btn-flat',
                                                            'style' => [
                                                                'float' => 'right'
                                                            ],
                                                        ]
                                                    ); ?>
                                                    <!-- <?= Html::a('<span class="glyphicon glyphicon-print"></span> Surat Pengantar', ['akt-pembelian-penerimaan/cetak-surat-pengantar', 'id' => $d->id_pembelian_penerimaan], [
                                                                'class' => 'btn btn-default btn-sm btn-flat',
                                                                'style' => [
                                                                    'float' => 'right',
                                                                    'margin-right' => '5px',
                                                                ],
                                                                'target' => '_blank'
                                                            ]) ?>
                                                    <?= Html::a('<span class="glyphicon glyphicon-print"></span> Label Barang', ['akt-pembelian-penerimaan/cetak-label-barang', 'id' => $d->id_pembelian_penerimaan], [
                                                        'class' => 'btn btn-default btn-sm btn-flat',
                                                        'style' => [
                                                            'float' => 'right',
                                                            'margin-right' => '5px',
                                                        ],
                                                        'target' => '_blank'
                                                    ]) ?> -->
                                                </div>
                                            </div>
                                            <div id="collapse<?php echo $no; ?>" class="panel-collapse collapse collapseExample" role="tabpanel" aria-labelledby="headingOne">
                                                <div class="panel-body">
                                                    <div class="row">
                                                        <div class="col-sm-6" style="overflow: auto;">
                                                            <table class="table">
                                                                <tr>
                                                                    <td>Penerima</td>
                                                                    <td>:</td>
                                                                    <td><?= $d->penerima ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Pengantar</td>
                                                                    <td>:</td>
                                                                    <td><?= $d->pengantar ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Keterangan</td>
                                                                    <td>:</td>
                                                                    <td><?= $d->keterangan_pengantar ?></td>
                                                                </tr>
                                                            </table>

                                                        </div>
                                                        <div class="col-sm-6">
                                                            <table class="">
                                                                <tr>
                                                                    <td style="width: 10px;white-space: nowrap; vertical-align: text-top;">Foto Resi</td>
                                                                    <td style="vertical-align: text-top;">:</td>
                                                                    <td rowspan="4">
                                                                        <a target="_BLANK" href="/backend/web/upload/<?= $d->foto_resi ?>">
                                                                            <img src="/backend/web/upload/<?= $d->foto_resi ?>" style="width: 49%;height: auto;">
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div class="row" style="text-align:left;">
                                                        <div class="col-md-3" style="display: flex; justify-content:start;">
                                                            <?php
                                                            // if ($d->tanggal_penerimaan == date('Y-m-d')) {
                                                            ?>
                                                            <?= Html::a('<span class="glyphicon glyphicon-plus"></span> Tambah Detail Penerimaan', '#', [
                                                                'class' => 'btn btn-success plus ',
                                                                'data-toggle' => 'modal',
                                                                'data-target' => '#modal-penerimaan-detail',
                                                                'style' => [
                                                                    'float' => 'right'
                                                                ],
                                                                'data-id' => $d->id_pembelian_penerimaan
                                                            ]) ?>
                                                            <?php // } 
                                                            ?>
                                                        </div>
                                                    </div> <br>


                                                    <table class="table penerimaanTables">
                                                        <thead>
                                                            <tr>
                                                                <th>No</th>
                                                                <th>Nama Barang</th>
                                                                <th>Qty Diterima</th>
                                                                <th>Keterangan</th>
                                                                <?php
                                                                if ($d->tanggal_penerimaan == date('Y-m-d')) {
                                                                ?>
                                                                    <th>Aksi</th>
                                                                <?php } ?>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $no_detail = 1;
                                                            // $penerimaan_detail = AktPembelianPenerimaanDetail::find()
                                                            //     ->select('*')
                                                            //     ->innerJoin('akt_pembelian_detai', 'akt_pembelian_detail.id_pembelian_detail = akt_pembelian_penerimaan_detail.id_pembelian_detail')
                                                            //     ->innerJoin('akt_item_stok', 'akt_item_stok.id_item_stok = akt_pembelian_detail.id_item_stok')
                                                            //     ->innerJoin('akt_item', 'akt_item.id_item = akt_item_stok.id_item')
                                                            //     ->where(['id_pembelian_penerimaan' => $d->id_pembelian_penerimaan])
                                                            //     ->all();
                                                            $penerimaan_detail = Yii::$app->db->createCommand("SELECT * FROM `akt_pembelian_penerimaan_detail` INNER JOIN `akt_pembelian_detail` ON akt_pembelian_detail.id_pembelian_detail = akt_pembelian_penerimaan_detail.id_pembelian_detail INNER JOIN `akt_item_stok` ON akt_item_stok.id_item_stok = akt_pembelian_detail.id_item_stok INNER JOIN `akt_item` ON akt_item.id_item = akt_item_stok.id_item WHERE `id_pembelian_penerimaan`=$d->id_pembelian_penerimaan")->queryAll();

                                                            foreach ($penerimaan_detail as $k) {
                                                            ?>
                                                                <tr>
                                                                    <td><?= $no_detail++ ?></td>
                                                                    <td><?= $k['nama_item'] ?></td>
                                                                    <td><?= $k['qty_diterima'] ?></td>
                                                                    <td><?= $k['keterangan'] ?></td>
                                                                    <?php
                                                                    if ($d->tanggal_penerimaan == date('Y-m-d')) {
                                                                    ?>
                                                                        <td>
                                                                            <?= Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete-pembelian-penerimaan-detail', 'id' => $k['id_pembelian_penerimaan_detail']], [
                                                                                'class' => 'btn btn-sm btn-danger edit btn-sm btn-flat',
                                                                                'style' => [
                                                                                    'float' => 'right'
                                                                                ],
                                                                            ]) ?>
                                                                        </td>
                                                                    <?php } ?>
                                                                </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>

                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                        $no++;
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>


<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Terima Barang</h4>
            </div>
            <?php //$form = ActiveForm::begin(['akt-pembelian/view', 'aksi' => 'ubah_data_pembelian', 'id' => $model->id_pembelian]); 
            ?>
            <div class="modal-body">
                <?php $form = ActiveForm::begin([
                    'action' => '/backend/web/index.php?r=akt-pembelian-penerimaan-sendiri/view&aksi=terima_barang&id=' . $model->id_pembelian,
                    'id' => 'form-penerimaan',
                ]); ?>

                <div class="row">
                    <div class="col-md-6">
                        <?= $form->field($model2, 'no_penerimaan')->textInput(['maxlength' => true, 'readonly' => true]) ?>

                        <?= $form->field($model2, 'tanggal_penerimaan')->textInput(['type' => 'date', 'value' => date('Y-m-d')]) ?>

                        <?= $form->field($model2, 'penerima')->textInput(['maxlength' => true,]) ?>

                        <?= $form->field($model2, 'foto_resi')->fileInput() ?>
                    </div>
                    <div class="col-md-6">

                        <?= $form->field($model2, 'pengantar')->textInput(['maxlength' => true]) ?>

                        <?= $form->field($model2, 'keterangan_pengantar')->textarea(['rows' => 4]) ?>
                        <?= $form->field($model2, 'id_pembelian')->textInput(['value' => $model->id_pembelian, 'type' => 'hidden'])->label(false) ?>
                        <?= $form->field($model2, 'id_pembelian_penerimaan')->textInput(['value' => $model2->id_pembelian_penerimaan, 'type' => 'hidden'])->label(false) ?>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-saved"></span> Simpan', ['class' => 'btn btn-success']) ?>
                <?php // Html::endForm() 
                ?>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade" id="modal-penerimaan-detail">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Terima Barang Detail</h4>
            </div>
            <?php //$form = ActiveForm::begin(['akt-pembelian/view', 'aksi' => 'ubah_data_pembelian', 'id' => $model->id_pembelian]); 
            ?>
            <?php $form = ActiveForm::begin([
                'action' => '/backend/web/index.php?r=akt-pembelian-penerimaan-sendiri/view&aksi=terima_barang_detail&id=' . $model->id_pembelian,
            ]); ?>
            <div class="modal-body">

                <div class="row">
                    <div class="col-md-6">
                        <?= $form->field($model3, 'id_pembelian_detail')->widget(Select2::classname(), [
                            'data' => $query_for_pembelian_detail,
                            'language' => 'en',
                            'options' => ['placeholder' => 'Pilih Pembelian Detail'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label('Pembelian Detail')
                        ?>

                        <?= $form->field($model3, 'qty_diterima')->textInput() ?>

                        <?= $form->field($model3, 'id_pembelian_penerimaan')->textInput(['type' => 'hidden'])->label(false) ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model3, 'keterangan')->textarea(['rows' => 5]) ?>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-saved"></span> Simpan', ['class' => 'btn btn-success']) ?>
                <?php // Html::endForm() 
                ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<?php
$script = <<< JS

    $(document).ready(function(){ 
        
    // $('#barang').DataTable();
    // $('.penerimaanTables').DataTable();
    
    $('.plus').on('click', function() {
        // const id = $(this).data('id');
        const id = $(this).attr('data-id');
        $('#aktpembelianpenerimaandetail-id_pembelian_penerimaan').val(id)
        // console.log(id);
    })

    $('.terima').on('click', function() {
        // const id = $(this).data('id');
        const id = $(this).attr('data-id');
        const id_action = $(this).attr('id-pembelian');

        // console.log(id_action);
        $('#form-penerimaan').attr('action', '/backend/web/index.php?r=akt-pembelian-penerimaan-sendiri/view&aksi=terima_barang&id='+id_action+'');

        $('#aktpembelianpenerimaan-penerima').val('');
        $('#aktpembelianpenerimaan-pengantar').val('');
        $('#aktpembelianpenerimaan-keterangan_pengantar').val('');
        $('#aktpembelianpenerimaan-id_pembelian_penerimaan').val('');
       
        
    })

    $('.edit').on('click', function() {
        // const id = $(this).data('id');
        const id = $(this).attr('data-id');
        const id_action = $(this).attr('id-pembelian');
        // $('#aktpembelianpenerimaandetail-id_pembelian_penerimaan').val(id);

        $('#form-penerimaan').attr('action', '/backend/web/index.php?r=akt-pembelian-penerimaan-sendiri/view&aksi=edit_terima_barang&id='+id_action+'');

        $.ajax({
            url: 'index.php?r=akt-pembelian-penerimaan-sendiri/get-penerimaan',
            data: {id : id},
            type:'GET',
            dataType:'json',
            success: function(data) {
                //  $('#aktpembelianpenerimaandetail-id_pembelian_detail').val(data.);
                 $('#aktpembelianpenerimaan-penerima').val(data.penerima);
                 $('#aktpembelianpenerimaan-pengantar').val(data.pengantar);
                 $('#aktpembelianpenerimaan-keterangan_pengantar').val(data.keterangan_pengantar);
                 $('#aktpembelianpenerimaan-id_pembelian_penerimaan').val(data.id_pembelian_penerimaan);
                //  $('#id').val(data.id);
                //  console.log(id);
            }
        });
        
    })
})






JS;
$this->registerJs($script);
?>