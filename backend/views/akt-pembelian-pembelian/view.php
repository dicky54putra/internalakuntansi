<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\AktPembelianDetail;
use backend\models\AktItemStok;
use backend\models\AktItem;
use backend\models\AktGudang;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use backend\models\Login;
/* @var $this yii\web\View */
/* @var $model backend\models\Aktpembelian */

$this->title = 'Detail Data Pembelian : ' . $model->no_pembelian;
// $this->params['breadcrumbs'][] = ['label' => 'Akt pembelians', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="akt-pembelian-pembelian-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Data Pembelian', ['index']) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['index'], ['class' => 'btn btn-warning']) ?>
        <?php
        if ($model->status == 2) {
            # code...
        ?>
            <?= Html::a('<span class="glyphicon glyphicon-copy"></span> Ubah Data Pembelian', ['update-data-pembelian', 'id' => $model->id_pembelian], ['class' => 'btn btn-success hidden']) ?>
            <?php
            $show_hide = 0;
            $query_detail = AktPembelianDetail::find()->where(['id_pembelian' => $model->id_pembelian])->all();
            $count_query_detail = AktPembelianDetail::find()->where(['id_pembelian' => $model->id_pembelian])->count();
            foreach ($query_detail as $key => $data) {
                # code...
                $item_stok = AktItemStok::findOne($data['id_item_stok']);
                $a = ($data['qty'] > $item_stok->qty) ? 1 : 0;
                $show_hide += $a;
            }
            ?>
            <?php
            // if ($show_hide == 0 && $count_query_detail != 0) {
            if ($count_query_detail != 0) {
                # code...
                // if ($count_data_pembelian_count == 0) {
                # code...
            ?>
                <?= Html::a('<span class="fa fa-truck"></span> Penerimaan', ['penerimaan', 'id' => $model->id_pembelian], [
                    'class' => 'btn btn-success',
                    'data' => [
                        'confirm' => 'Apakah anda yakin akan menyetujui penerimaan Data Pembelian : ' . $model->no_pembelian . ' ?',
                        'method' => 'post',
                    ],
                ]) ?>
        <?php
                // }
            }
        }
        ?>
    </p>

    <div class="panel panel-primary">
        <div class="panel-heading"><span class="glyphicon glyphicon-copy"></span> <?= $this->title ?></div>
        <div class="panel-body">
            <div class="col-md-12" style="padding: 0;">
                <div class="box-body">

                    <div class="row">
                        <div class="col-md-6">
                            <?= DetailView::widget([
                                'model' => $model,
                                'template' => '<tr><th style="width:40%;">{label}</th><td>{value}</td></tr>',
                                'attributes' => [
                                    // 'id_pembelian',
                                    'no_pembelian',
                                    [
                                        'attribute' => 'tanggal_pembelian',
                                        'value' => function ($model) {
                                            if (!empty($model->tanggal_pembelian)) {
                                                # code...
                                                return tanggal_indo($model->tanggal_pembelian, true);
                                            } else {
                                                # code...
                                            }
                                        }
                                    ],
                                    [
                                        'atribute' => 'no_faktur_pembelian',
                                        'label' => 'No Faktur Pajak',
                                        'value' =>  function ($model) {
                                            if (!empty($model->no_faktur_pembelian)) {
                                                # code...
                                                return $model->no_faktur_pembelian;
                                            }
                                        }
                                    ],
                                    [
                                        'attribute' => 'tanggal_faktur_pembelian',
                                        'label' => 'Tanggal Faktur Pajak',
                                        'value' => function ($model) {
                                            if (!empty($model->tanggal_faktur_pembelian)) {
                                                # code...
                                                return tanggal_indo($model->tanggal_faktur_pembelian, true);
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
                                'model' => $model,
                                'template' => '<tr><th style="width:40%;">{label}</th><td>{value}</td></tr>',
                                'attributes' => [
                                    // 'id_pembelian',
                                    [
                                        'attribute' => 'jenis_bayar',
                                        'value' => function ($model) {
                                            if ($model->jenis_bayar == 1) {
                                                # code...
                                                return 'CASH';
                                            } elseif ($model->jenis_bayar == 2) {
                                                # code...
                                                return 'CREDIT';
                                            } else {
                                                # code...
                                            }
                                        }
                                    ],
                                    [
                                        'attribute' => 'jatuh_tempo',
                                        'visible' => ($model->jenis_bayar == 2) ? true : false,
                                    ],
                                    [
                                        'attribute' => 'tanggal_tempo',
                                        'visible' => ($model->jenis_bayar == 2) ? true : false,
                                        'value' => function ($model) {
                                            if (!empty($model->tanggal_tempo)) {
                                                # code...
                                                return tanggal_indo($model->tanggal_tempo, true);
                                            } else {
                                                # code...
                                            }
                                        }
                                    ],
                                    // 'materai',
                                    // [
                                    //     'attribute' => 'id_penagih',

                                    //     'label' => 'Nama Penagih',
                                    //     'value' => function ($model) {
                                    //         if (!empty($model->penagih->nama_mitra_bisnis)) {
                                    //             # code...
                                    //             return $model->penagih->nama_mitra_bisnis;
                                    //         } else {
                                    //             # code...
                                    //         }
                                    //     }
                                    // ],
                                    [
                                        'attribute' => 'status',
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            if ($model->status == 1) {
                                                # code...
                                                return "<span class='label label-default'>Order Pembelian</span>";
                                            } elseif ($model->status == 2) {
                                                # code...
                                                $nama_approver = Login::find()->where(['id_login' => $model->id_login])->one();
                                                return "<span class='label label-warning'>Pembelian, Disetujui pada " . tanggal_indo2(date('D, d F Y H:i', strtotime($model->tanggal_approve))) . " oleh " . $nama_approver->nama . "</span>";
                                            } elseif ($model->status == 3) {
                                                # code...
                                                return "<span class='label label-primary'>Penerimaan</span>";
                                            } elseif ($model->status == 4) {
                                                # code...
                                                return "<span class='label label-success'>Selesai</span>";
                                            } elseif ($model->status == 5) {
                                                # code...
                                                return "<span class='label label-info'>Proses Penerimaan</span>";
                                            }
                                        }
                                    ],
                                ],
                            ]) ?>
                        </div>
                    </div>

                    <div class="" style="margin-top:20px;">
                        <ul class="nav nav-tabs" id="tabForRefreshPage">
                            <li class="active"><a data-toggle="tab" class="link-tab" href="#data-barang"><span class="fa fa-box"></span> Data Barang Pembelian</a></li>
                            <li><a data-toggle="tab" class="link-tab" href="#isi-data-pembelian"> <span class="glyphicon glyphicon-shopping-cart"></span> Data Order Pembelian</a></li>
                            <li><a data-toggle="tab" class="link-tab" href="#unggah-dokumen"><span class="fa fa-file-text"></span> Unggah Dokumen</a></li>
                            <li><a data-toggle="tab" class="link-tab" href="#faktur"><span class="glyphicon glyphicon-list-alt"></span> Faktur Pajak</a></li>
                        </ul>
                        <div class="tab-content">

                            <div id="data-barang" class="tab-pane fade in active" style="margin-top:20px;">
                                <div class="row" style="margin-top:30px;">
                                    <div class="col-md-12" style="overflow: auto;">
                                        <table id="barang" class="table">
                                            <thead>
                                                <tr>
                                                    <th style="width: 1%;">#</th>
                                                    <th style="width: 30%;">Nama Barang</th>
                                                    <th style="width: 10%;">Gudang</th>
                                                    <th style="width: 5%;">Qty</th>
                                                    <th style="width: 8%;">Harga</th>
                                                    <th style="width: 7%;">Diskon %</th>
                                                    <th style="width: 20%;">Keterangan</th>
                                                    <th style="width: 10%;">Sub Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $no = 1;
                                                $totalan_total = 0;
                                                $query_detail = AktPembelianDetail::find()->where(['id_pembelian' => $model->id_pembelian])->all();
                                                foreach ($query_detail as $key => $data) {
                                                    # code...
                                                    $item_stok = AktItemStok::findOne($data['id_item_stok']);
                                                    $item = AktItem::findOne($item_stok->id_item);
                                                    $gudang = AktGudang::findOne($item_stok->id_gudang);

                                                    $totalan_total += $data['total'];
                                                ?>
                                                    <tr>
                                                        <td><?= $no++ . '.' ?></td>
                                                        <td>
                                                            <?php
                                                            echo $item->nama_item;
                                                            // if ($model->status == 2) {
                                                            //     # code...
                                                            //     echo "<br>";
                                                            //     if ($data['qty'] > $item_stok->qty) {
                                                            //         # code...
                                                            //         echo "<span class='label label-danger'>Stok Kosong</span>";
                                                            //     } else {
                                                            //         # code...
                                                            //         echo "<span class='label label-success'>Stok Tersedia</span>";
                                                            //     }
                                                            // }
                                                            ?>
                                                        </td>
                                                        <td><?= (!empty($gudang->nama_gudang)) ? $gudang->nama_gudang : '' ?></td>
                                                        <td><?= $data['qty'] ?></td>
                                                        <td><?= ribuan($data['harga']) ?></td>
                                                        <td><?= $data['diskon'] ?></td>
                                                        <td><?= $data['keterangan'] ?></td>
                                                        <td style="text-align: right;"><?= ribuan($data['total']) ?></td>
                                                        <?php
                                                        if ($model->status == 2) {
                                                            # code...
                                                        ?>
                                                            <!-- <td> -->
                                                            <?php // Html::a('<span class="glyphicon glyphicon-edit"></span>', ['akt-pembelian-detail/update-from-data-pembelian', 'id' => $data['id_pembelian_detail']], ['class' => 'btn btn-primary']) 
                                                            ?>
                                                            <?php  // Html::a('<span class="glyphicon glyphicon-trash"></span>', ['akt-pembelian-detail/delete-from-data-pembelian', 'id' => $data['id_pembelian_detail']], [
                                                            //     'class' => 'btn btn-danger',
                                                            //     'data' => [
                                                            //         'confirm' => 'Are you sure you want to delete this item?',
                                                            //         'method' => 'post',
                                                            //     ],
                                                            // ]) 
                                                            ?>
                                                            <!-- </td> -->
                                                        <?php } ?>
                                                    </tr>
                                                <?php
                                                }
                                                ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th colspan="7" style="text-align: right;">Total</th>
                                                    <th style="text-align: right;"><?= ribuan($totalan_total) ?></th>
                                                </tr>
                                                <tr>
                                                    <th colspan="7" style="text-align: right;">Diskon <?= $model->diskon ?> %</th>
                                                    <th style="text-align: right;">
                                                        <?php
                                                        $diskon = ($model->diskon * $totalan_total) / 100;
                                                        echo ribuan($diskon);
                                                        ?>
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th colspan="7" style="text-align: right;">Pajak 10 % (<?= ($model->pajak == NULL) ? '' : $retVal = ($model->pajak == 1) ? '<span class="glyphicon glyphicon-ok"></span>' : '<span class="glyphicon glyphicon-remove"></span>' ?>)</th>
                                                    <th style="text-align: right;">
                                                        <?php
                                                        $diskon = ($model->diskon * $totalan_total) / 100;
                                                        $pajak_ = (($totalan_total - $diskon) * 10) / 100;
                                                        $pajak = ($model->pajak == 1) ? $pajak_ : 0;
                                                        echo ribuan($pajak);
                                                        ?>
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th colspan="7" style="text-align: right;">Ongkir</th>
                                                    <th style="text-align: right;"><?= ribuan($model->ongkir) ?></th>
                                                </tr>
                                                <tr>
                                                    <th colspan="7" style="text-align: right;">Materai</th>
                                                    <th style="text-align: right;"><?= ribuan($model->materai) ?></th>
                                                </tr>
                                                <tr>
                                                    <th colspan="7" style="text-align: right;">Uang Muka</th>
                                                    <th style="text-align: right;"><?= ribuan($model->uang_muka) ?></th>
                                                </tr>
                                                <tr>
                                                    <th colspan="7" style="text-align: right;">Grand Total</th>
                                                    <th style="text-align: right;"><?= ribuan($model->total) ?></th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div id="isi-data-pembelian" class="tab-pane fade" style="margin-top:20px;">
                                <div class="row" style="margin-top:30px;">
                                    <div class="col-md-12">

                                        <div class="row">
                                            <div class="col-md-6">
                                                <?= DetailView::widget([
                                                    'model' => $model,
                                                    'template' => '<tr><th style="width:40%;">{label}</th><td>{value}</td></tr>',
                                                    'attributes' => [
                                                        // 'id_pembelian',
                                                        'no_order_pembelian',
                                                        [
                                                            'attribute' => 'tanggal_order_pembelian',
                                                            'value' => function ($model) {
                                                                return tanggal_indo($model->tanggal_order_pembelian, true);
                                                            }
                                                        ],
                                                        [
                                                            'attribute' => 'id_customer',

                                                            'label' => 'Nama Customer',
                                                            'value' => function ($model) {
                                                                if (!empty($model->customer->nama_mitra_bisnis)) {
                                                                    # code...
                                                                    return $model->customer->nama_mitra_bisnis;
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
                                                    'model' => $model,
                                                    'template' => '<tr><th style="width:40%;">{label}</th><td>{value}</td></tr>',
                                                    'attributes' => [
                                                        [
                                                            'attribute' => 'id_mata_uang',

                                                            'label' => 'Jenis Mata Uang',
                                                            'value' => function ($model) {
                                                                if (!empty($model->mata_uang->mata_uang)) {
                                                                    # code...
                                                                    return $model->mata_uang->mata_uang;
                                                                } else {
                                                                    # code...
                                                                }
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
                                                                    return "<span class='label label-primary'>penerimaan</span>";
                                                                } elseif ($model->status == 4) {
                                                                    # code...
                                                                    return "<span class='label label-success'>Completed</span>";
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

                            <div id="unggah-dokumen" class="tab-pane fade" style="margin-top:20px;">
                                <div class="row" style="margin-top:30px;">
                                    <div class="col-md-12">
                                        <?= Html::beginForm(['akt-pembelian-pembelian/upload'], 'post', ['enctype' => 'multipart/form-data']) ?>
                                        <?= Html::hiddenInput("id_tabel", $model->id_pembelian) ?>
                                        <?= Html::hiddenInput("nama_tabel", "pembelian") ?>
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th colspan="2">UPLOAD FOTO ATAU DOKUMEN</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <input class='btn btn-warning' type="file" name="foto" id="exampleInputFile" required><br>
                                                        <b style="color: red;">Catatan:<br>- File harus bertype jpg, png, jpeg, excel, work, pdf<br>- Ukuran maksimal 2 MB.</b>
                                                    </td>
                                                    <td>
                                                        <?= Html::submitButton('Submit', ['class' => 'btn btn-success']) ?>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <?= Html::endForm() ?>
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>DOKUMEN :</th>
                                                </tr>
                                            </thead>
                                        </table>
                                        <?php foreach ($foto as $data) { ?>
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th width="80%">
                                                            <figure class="figure">
                                                                <img src="/accounting/backend/web/upload/<?php echo $data->foto; ?>" alt="image" class="img-thumbnail figure-img img-fluid" width="200px">
                                                                <figcaption class="figure-caption" style="margin-top: 2rem;">
                                                                    <a target="_BLANK" href="/accounting/backend/web/upload/<?php echo $data->foto; ?>"><?php echo $data->foto; ?></a>
                                                                </figcaption>
                                                            </figure>
                                                        </th>
                                                        <th width="20%">
                                                            <div class="" style="display: flex; align-items:center; margin-bottom:50px;">
                                                                <a href="index.php?r=akt-pembelian-pembelian/view&id=<?php echo $model->id_pembelian; ?>&id_hapus=<?php echo $data->id_foto; ?>"><img src='images/hapus.png' width="40px"></a>
                                                            </div>
                                                        </th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>

                            <div id="faktur" class="tab-pane fade" style="margin-top:20px;">
                                <div class="row" style="margin-top:30px;">
                                    <div class="col-md-12">

                                        <?= Html::beginForm(['akt-pembelian-pembelian/view', 'aksi' => 'faktur', 'id' => $model->id_pembelian], 'post') ?>

                                        <div class="form-group">
                                            <label for="no_faktur_pembelian">No. Faktur</label>
                                            <input type="text" id="no_faktur_pembelian" name="no_faktur_pembelian" placeholder="No. Faktur" value="<?= $model->no_faktur_pembelian ?>" class="form-control" autocomplete="off" required <?= ($model->status == 3) ? 'readonly' : '' ?>>
                                        </div>

                                        <div class="form-group">
                                            <label for="tanggal_faktur_pembelian">Tanggal Faktur</label>
                                            <input type="date" id="tanggal_faktur_pembelian" name="tanggal_faktur_pembelian" value="<?= $model->tanggal_faktur_pembelian ?>" class="form-control" required <?= ($model->status == 3) ? 'readonly' : '' ?>>
                                        </div>

                                        <div class="form-group">
                                            <?php
                                            if ($model->status == 2) {
                                                # code...
                                            ?>
                                                <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-saved"></span> Simpan', ['class' => 'btn btn-success']) ?>
                                            <?php
                                            }
                                            ?>
                                        </div>

                                        <?= Html::endForm() ?>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <?php
    $script = <<< JS


    $(document).ready(function(){ 
        
    $('#barang').DataTable();

    if ($("#aktpembelian-jenis_bayar").val() == "1")
    {
        $("#aktpembelian-jatuh_tempo").hide();
        $('#jatuh_tempo').hide(); 
        $("#aktpembelian-tanggal_tempo").hide();
        $('#tanggal_tempo').hide(); 
            
    }
    
    if ($("#aktpembelian-jenis_bayar").val() == "2")
    {
        $("#aktpembelian-jatuh_tempo").show();
        $('#jatuh_tempo').show(); 
        $("#aktpembelian-tanggal_tempo").show();
        $('#tanggal_tempo').show(); 
    }

    $("#aktpembelian-jenis_bayar").change(function(){

    if ($("#aktpembelian-jenis_bayar").val() == "1")
    {
        $("#aktpembelian-jatuh_tempo").hide();
        $('#jatuh_tempo').hide(); 
        $("#aktpembelian-tanggal_tempo").hide();
        $('#tanggal_tempo').hide(); 
            
    }
    
    if ($("#aktpembelian-jenis_bayar").val() == "2")
    {
        $("#aktpembelian-jatuh_tempo").show();
        $('#jatuh_tempo').show(); 
        $("#aktpembelian-tanggal_tempo").show();
        $('#tanggal_tempo').show(); 
    }
    
    });
    });

JS;
    $this->registerJs($script);
    ?>