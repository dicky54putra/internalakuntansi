<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\AktPenjualanDetail;
use backend\models\AktItemStok;
use backend\models\AktItem;
use backend\models\AktGudang;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use backend\models\AktItemHargaJual;
use backend\models\AktLevelHarga;
/* @var $this yii\web\View */
/* @var $model backend\models\AktPenjualan */

$this->title = 'Detail Data Penjualan : ' . $model->no_penjualan;
// $this->params['breadcrumbs'][] = ['label' => 'Akt Penjualans', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="akt-penjualan-penjualan-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Data Penjualan', ['index']) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['index'], ['class' => 'btn btn-warning']) ?>
        <?php
        if ($model->status == 2) {
            # code...
        ?>
            <?php // Html::a('<span class="glyphicon glyphicon-copy"></span> Ubah Data Penjualan', ['update-data-penjualan', 'id' => $model->id_penjualan], ['class' => 'btn btn-success']) 
            ?>
            <?php
            $show_hide = 0;
            $query_detail = AktPenjualanDetail::find()->where(['id_penjualan' => $model->id_penjualan])->all();
            $count_query_detail = AktPenjualanDetail::find()->where(['id_penjualan' => $model->id_penjualan])->count();
            foreach ($query_detail as $key => $data) {
                # code...
                $item_stok = AktItemStok::findOne($data['id_item_stok']);

                $a = ($data['qty'] > $item_stok->qty) ? 1 : 0;

                $show_hide += $a;
            }
            ?>
            <?php
            if ($show_hide == 0 && $count_query_detail != 0) {
                # code...
            ?>
                <?php
                if ($count_data_penjualan_count == 0) {
                    # code...
                ?>
                    <?= Html::a('<span class="fa fa-truck"></span> Pengiriman', ['pengiriman', 'id' => $model->id_penjualan], [
                        'class' => 'btn btn-success',
                        'data' => [
                            'confirm' => 'Apakah anda yakin akan menyetujui pengiriman Data Penjualan : ' . $model->no_penjualan . ' ?',
                            'method' => 'post',
                        ],
                    ]) ?>
                <?php
                }
                ?>
        <?php
            }
        }
        ?>
        <?php
        if ($model->status >= 2 && $model->status != 5) {
            # code...
        ?>
            <?= Html::a('<span class="glyphicon glyphicon-print"></span> Cetak Invoice', ['cetak-invoice', 'id' => $model->id_penjualan], ['class' => 'btn btn-default', 'target' => '_blank']) ?>
            <?= Html::a('<span class="glyphicon glyphicon-print"></span> Cetak Surat Pesanan', ['cetak-surat-pesanan', 'id' => $model->id_penjualan], ['class' => 'btn btn-default', 'target' => '_blank']) ?>
        <?php } ?>
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
                                    // 'id_penjualan',
                                    'no_penjualan',
                                    [
                                        'attribute' => 'tanggal_penjualan',
                                        'value' => function ($model) {
                                            if (!empty($model->tanggal_penjualan)) {
                                                # code...
                                                return tanggal_indo($model->tanggal_penjualan, true);
                                            } else {
                                                # code...
                                            }
                                        }
                                    ],
                                    'no_faktur_penjualan',
                                    [
                                        'attribute' => 'tanggal_faktur_penjualan',
                                        'value' => function ($model) {
                                            if (!empty($model->tanggal_faktur_penjualan)) {
                                                # code...
                                                return tanggal_indo($model->tanggal_faktur_penjualan, true);
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
                                    // 'id_penjualan',
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
                                        'attribute' => 'jumlah_tempo',
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
                                    [
                                        'attribute' => 'status',
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            $the_approver_name = "";
                                            if (!empty($model->approver->nama)) {
                                                # code...
                                                $the_approver_name = $model->approver->nama;
                                            }

                                            $the_approver_date = "";
                                            if (!empty($model->the_approver_date)) {
                                                # code...
                                                $the_approver_date = tanggal_indo2(date('D, d F Y H:i', strtotime($model->the_approver_date)));
                                            }

                                            if ($model->status == 1) {
                                                # code...
                                                return "<span class='label label-default'>Order Penjualan</span>";
                                            } elseif ($model->status == 2) {
                                                # code...
                                                return "<span class='label label-warning'>Penjualan disetujui pada " . $the_approver_date . " oleh " . $the_approver_name . "</span>";
                                            } elseif ($model->status == 3) {
                                                # code...
                                                return "<span class='label label-primary'>Pengiriman</span>";
                                            } elseif ($model->status == 4) {
                                                # code...
                                                return "<span class='label label-success'>Selesai</span>";
                                            } elseif ($model->status == 5) {
                                                # code...
                                                return "<span class='label label-danger'>Ditolak pada " . $the_approver_date . " oleh " . $the_approver_name . "</span>";
                                            }
                                        }
                                    ],
                                ],
                            ]) ?>
                        </div>
                    </div>

                    <div class="" style="margin-top:20px;">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#data-barang"><span class="fa fa-box"></span> Data Barang Penjualan</a></li>
                            <li><a data-toggle="tab" href="#isi-data-penjualan"> <span class="glyphicon glyphicon-shopping-cart"></span> Data Order Penjualan</a></li>
                            <li><a data-toggle="tab" href="#unggah-dokumen"><span class="fa fa-file-text"></span> Unggah Dokumen</a></li>
                            <li><a data-toggle="tab" href="#faktur"><span class="glyphicon glyphicon-list-alt"></span> Faktur</a></li>
                        </ul>
                        <div class="tab-content">

                            <div id="data-barang" class="tab-pane fade in active" style="margin-top:20px;">
                                <div class="row" style="margin-top:30px;">
                                    <div class="col-md-12">

                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th style="width: 1%;">No.</th>
                                                    <th style="width: 20%;">Nama Barang</th>
                                                    <th style="width: 10%;">Jenis</th>
                                                    <th style="width: 10%;">Gudang</th>
                                                    <th style="width: 5%;">Qty</th>
                                                    <th style="width: 10%;">Harga</th>
                                                    <th style="width: 10%;">Diskon %</th>
                                                    <th style="width: 20%;">Keterangan</th>
                                                    <th style="width: 10%;">Sub Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $no = 1;
                                                $totalan_total = 0;
                                                $query_detail = AktPenjualanDetail::find()->where(['id_penjualan' => $model->id_penjualan])->all();
                                                foreach ($query_detail as $key => $data) {
                                                    # code...
                                                    $item_stok = AktItemStok::findOne($data['id_item_stok']);
                                                    $item = AktItem::findOne($item_stok->id_item);
                                                    $gudang = AktGudang::findOne($item_stok->id_gudang);
                                                    $harga_jual = AktItemHargaJual::findOne($data['id_item_harga_jual']);
                                                    $level_harga = AktLevelHarga::findOne($harga_jual->id_level_harga);
                                                    $totalan_total += $data['total'];
                                                ?>
                                                    <tr>
                                                        <td><?= $no++ . '.' ?></td>
                                                        <td>
                                                            <?php
                                                            echo $item->nama_item;
                                                            if ($model->status == 2) {
                                                                # code...
                                                                echo "<br>";
                                                                if ($data['qty'] > $item_stok->qty) {
                                                                    # code...
                                                                    echo "<span class='label label-danger'>Melebihi Stok</span>";
                                                                } else {
                                                                    # code...
                                                                    echo "<span class='label label-success'>Stok Tersedia</span>";
                                                                }
                                                            }
                                                            ?>
                                                        </td>
                                                        <td><?= $level_harga->keterangan ?></td>
                                                        <td><?= (!empty($gudang->nama_gudang)) ? $gudang->nama_gudang : '' ?></td>
                                                        <td><?= $data['qty'] ?></td>
                                                        <td><?= ribuan($data['harga']) ?></td>
                                                        <td><?= $data['diskon'] ?></td>
                                                        <td><?= $data['keterangan'] ?></td>
                                                        <td style="text-align: right;"><?= ribuan($data['total']) ?></td>
                                                    </tr>
                                                <?php
                                                }
                                                ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th colspan="8" style="text-align: right;">Total</th>
                                                    <th style="text-align: right;"><?= ribuan($totalan_total) ?></th>
                                                </tr>
                                                <tr>
                                                    <th colspan="8" style="text-align: right;">Diskon <?= $model->diskon ?> %</th>
                                                    <th style="text-align: right;">
                                                        <?php
                                                        $diskon = ($model->diskon * $totalan_total) / 100;
                                                        echo ribuan($diskon);
                                                        ?>
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th colspan="8" style="text-align: right;">Pajak 10 % (<?= ($model->pajak == NULL) ? '' : $retVal = ($model->pajak == 1) ? '<span class="glyphicon glyphicon-ok"></span>' : '<span class="glyphicon glyphicon-remove"></span>' ?>)</th>
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
                                                    <th colspan="8" style="text-align: right;">Ongkir</th>
                                                    <th style="text-align: right;"><?= ribuan($model->ongkir) ?></th>
                                                </tr>
                                                <tr>
                                                    <th colspan="8" style="text-align: right;">Materai</th>
                                                    <th style="text-align: right;"><?= ribuan($model->materai) ?></th>
                                                </tr>
                                                <tr>
                                                    <th colspan="8" style="text-align: right;">Uang Muka</th>
                                                    <th style="text-align: right;"><?= ribuan($model->uang_muka) ?></th>
                                                </tr>
                                                <tr>
                                                    <th colspan="8" style="text-align: right;">Grand Total</th>
                                                    <th style="text-align: right;"><?= ribuan($model->total) ?></th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div id="isi-data-penjualan" class="tab-pane fade" style="margin-top:20px;">
                                <div class="row" style="margin-top:30px;">
                                    <div class="col-md-12">

                                        <div class="row">
                                            <div class="col-md-6">
                                                <?= DetailView::widget([
                                                    'model' => $model,
                                                    'template' => '<tr><th style="width:40%;">{label}</th><td>{value}</td></tr>',
                                                    'attributes' => [
                                                        // 'id_penjualan',
                                                        'no_order_penjualan',
                                                        [
                                                            'attribute' => 'tanggal_order_penjualan',
                                                            'value' => function ($model) {
                                                                return tanggal_indo($model->tanggal_order_penjualan, true);
                                                            }
                                                        ],
                                                        [
                                                            'attribute' => 'id_customer',
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
                                                        // 'id_penjualan',
                                                        [
                                                            'attribute' => 'id_sales',
                                                            'value' => function ($model) {
                                                                if (!empty($model->sales->nama_sales)) {
                                                                    # code...
                                                                    return $model->sales->nama_sales;
                                                                } else {
                                                                    # code...
                                                                }
                                                            }
                                                        ],
                                                        [
                                                            'attribute' => 'id_mata_uang',
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
                                                            'attribute' => 'tanggal_estimasi',
                                                            'value' => function ($model) {
                                                                if (!empty($model->tanggal_estimasi)) {
                                                                    # code...
                                                                    return tanggal_indo($model->tanggal_estimasi, true);
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
                                        <?= Html::beginForm(['akt-penjualan-penjualan/upload'], 'post', ['enctype' => 'multipart/form-data']) ?>
                                        <?= Html::hiddenInput("id_tabel", $model->id_penjualan) ?>
                                        <?= Html::hiddenInput("nama_tabel", "penjualan") ?>
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
                                                            <a target="_BLANK" href="/accounting/backend/web/upload/<?php echo $data->foto; ?>"><?php echo $data->foto; ?></a>
                                                        </th>
                                                        <th width="20%">
                                                            <a href="index.php?r=akt-penjualan-penjualan/view&id=<?php echo $model->id_penjualan; ?>&id_hapus=<?php echo $data->id_foto; ?>" onclick="return confirm('Anda yakin ingin menghapus?')"><img src='images/hapus.png' width='20'></a>
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

                                        <?= Html::beginForm(['faktur', 'id' => $model->id_penjualan], 'post') ?>

                                        <div class="form-group">
                                            <label for="no_faktur_penjualan">No. Faktur Pajak</label>
                                            <input type="text" id="no_faktur_penjualan" name="no_faktur_penjualan" placeholder="No. Faktur" value="<?= $model->no_faktur_penjualan ?>" class="form-control" autocomplete="off" required <?= ($model->status == 2) ? '' : 'readonly' ?>>
                                        </div>

                                        <div class="form-group">
                                            <label for="tanggal_faktur_penjualan">Tanggal Faktur Pajak</label>
                                            <input type="date" id="tanggal_faktur_penjualan" name="tanggal_faktur_penjualan" value="<?= $model->tanggal_faktur_penjualan ?>" class="form-control" required <?= ($model->status == 2) ? '' : 'readonly' ?>>
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

    // $('#id_item_stok').change(function(){
	// var id = $(this).val();

	// $.get('index.php?r=akt-penjualan-detail/get-harga-item',{ id : id },function(data){
	// 	var data = $.parseJSON(data);
	// 	$('#aktpenjualandetail-harga').attr('value',data.hpp);
	// });
    // });

    $(document).ready(function(){ 

    if ($("#aktpenjualan-jenis_bayar").val() == "1")
    {
        $("#aktpenjualan-jumlah_tempo").hide();
        $('#jumlah_tempo').hide(); 
        $("#aktpenjualan-tanggal_tempo").hide();
        $('#tanggal_tempo').hide(); 
            
    }
    
    if ($("#aktpenjualan-jenis_bayar").val() == "2")
    {
        $("#aktpenjualan-jumlah_tempo").show();
        $('#jumlah_tempo').show(); 
        $("#aktpenjualan-tanggal_tempo").show();
        $('#tanggal_tempo').show(); 
    }

    $("#aktpenjualan-jenis_bayar").change(function(){

    if ($("#aktpenjualan-jenis_bayar").val() == "1")
    {
        $("#aktpenjualan-jumlah_tempo").hide();
        $('#jumlah_tempo').hide(); 
        $("#aktpenjualan-tanggal_tempo").hide();
        $('#tanggal_tempo').hide(); 
            
    }
    
    if ($("#aktpenjualan-jenis_bayar").val() == "2")
    {
        $("#aktpenjualan-jumlah_tempo").show();
        $('#jumlah_tempo').show(); 
        $("#aktpenjualan-tanggal_tempo").show();
        $('#tanggal_tempo').show(); 
    }
    
    });
    });

    let harga = document.querySelector('#harga');
    harga.addEventListener('keyup', function(e){
        harga.value = formatRupiah(this.value);
    });
    
    function formatNumber (number) {
        const formatNumbering = new Intl.NumberFormat("id-ID");
        return formatNumbering.format(number);
    };
    
    function formatRupiah(angka){
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
        split   		= number_string.split(','),
        sisa     		= split[0].length % 3,
        rupiah     		= split[0].substr(0, sisa),
        ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);
        if(ribuan){
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }
    
        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return rupiah;
    }
    
    $('#id-harga-jual').on('change', function(){
        var id = $(this).val();
        $.ajax({
            url:'index.php?r=akt-penjualan-detail/get-harga-item',
            type : 'GET',
            data : 'id='+id,
            success : function(data){
                let dataJson = $.parseJSON(data);
                let hargaSatuan = formatNumber(dataJson.harga_satuan);
                harga.value = hargaSatuan;
            }
        })
    })

JS;
    $this->registerJs($script);
    ?>