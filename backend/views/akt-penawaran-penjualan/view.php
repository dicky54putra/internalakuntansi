<?php

use backend\models\AktApprover;
use backend\models\AktPenawaranPenjualanDetail;
use backend\models\AktItemHargaJual;
use backend\models\AktLevelHarga;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPenawaranPenjualan */

$this->title = 'Detail Daftar Penawaran Penjualan : ' . $model->no_penawaran_penjualan;
// $this->params['breadcrumbs'][] = ['label' => 'Akt Penawaran Penjualans', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

$id_login = Yii::$app->user->id;
$the_approver = AktApprover::find()->leftJoin("akt_jenis_approver", "akt_jenis_approver.id_jenis_approver = akt_approver.id_jenis_approver")->where(['=', 'nama_jenis_approver', 'Penawaran Penjualan'])->all();

?>
<div class="akt-penawaran-penjualan-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Daftar Penawaran Penjualan', ['index']) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['index'], ['class' => 'btn btn-warning']) ?>
        <?php
        if ($model->status == 2 || $model->status == 3) {
            # code...
        ?>
            <?= Html::a('<span class="glyphicon glyphicon-repeat"></span> Pending', ['pending', 'id' => $model->id_penawaran_penjualan, 'id_login' => $id_login], [
                'class' => 'btn btn-primary',
                'data' => [
                    'confirm' => 'Apakah anda takin akan mempending Penawaran Penjualan : ' . $model->no_penawaran_penjualan . ' ?',
                    'method' => 'post',
                ],
            ]) ?>
        <?php } ?>
        <?php
        if ($model->status == 1) {
            # code...
        ?>
            <?= Html::a('<span class="glyphicon glyphicon-edit"></span> Ubah', ['update', 'id' => $model->id_penawaran_penjualan], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('<span class="glyphicon glyphicon-trash"></span> Hapus', ['delete', 'id' => $model->id_penawaran_penjualan], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>
            <?php
            foreach ($the_approver as $key => $value) {
                if ($id_login == $value['id_login']) {
            ?>
                    <?= Html::a('<span class="glyphicon glyphicon-ok"></span> Approve', ['approve', 'id' => $model->id_penawaran_penjualan, 'id_login' => $id_login], [
                        'class' => 'btn btn-success',
                        'data' => [
                            'confirm' => 'Apakah anda yakin akan menyetujui Penawaran Penjualan : ' . $model->no_penawaran_penjualan . ' ?',
                            'method' => 'post',
                        ],
                    ]) ?>
                    <?= Html::a('<span class="glyphicon glyphicon-remove"></span> Reject', ['reject', 'id' => $model->id_penawaran_penjualan, 'id_login' => $id_login], [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => 'Apakah anda takin akan menolak Penawaran Penjualan : ' . $model->no_penawaran_penjualan . ' ?',
                            'method' => 'post',
                        ],
                    ]) ?>
            <?php }
            } ?>
        <?php } ?>
        <?= Html::a('<span class="glyphicon glyphicon-print"></span> Cetak Penawaran', ['print-view', 'id' => $model->id_penawaran_penjualan], ['class' => 'btn btn-default', 'target' => '_BLANK']) ?>
    </p>

    <div class="box">
        <div class="panel panel-primary">
            <div class="panel-heading"><span class="fa fa-shopping-cart"></span> Penawaran Penjualan</div>
            <div class="panel-body">
                <div class="col-md-12" style="padding: 0;">
                    <div class="box-body">

                        <div class="row">
                            <div class="col-md-6">
                                <?= DetailView::widget([
                                    'model' => $model,
                                    'template' => '<tr><th style="width:40%;">{label}</th><td>{value}</td></tr>',
                                    'attributes' => [
                                        // 'id_penawaran_penjualan',
                                        'no_penawaran_penjualan',
                                        [
                                            'attribute' => 'tanggal',
                                            'value' => function ($model) {
                                                return tanggal_indo($model->tanggal, true);
                                            }
                                        ],
                                        [
                                            'attribute' => 'id_customer',
                                            'value' => function ($model) {
                                                return $model->customer->nama_mitra_bisnis;
                                            }
                                        ],
                                        [
                                            'attribute' => 'id_sales',
                                            'value' => function ($model) {
                                                return $model->sales->nama_sales;
                                            }
                                        ],
                                        [
                                            'attribute' => 'id_mata_uang',
                                            'value' => function ($model) {
                                                return $model->mata_uang->mata_uang;
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
                                        // 'id_penawaran_penjualan',
                                        // 'pajak',
                                        // [
                                        //     'attribute' => 'pajak',
                                        //     'format' => 'raw',
                                        //     'value' => function ($model) {
                                        //         if ($model->pajak == 1) {
                                        //             # code...
                                        //             return '<input type="checkbox" name="" id="" checked disabled>';
                                        //         } else {
                                        //             return '<input type="checkbox" name="" id="" disabled>';
                                        //             # code...
                                        //         }
                                        //     }
                                        // ],
                                        [
                                            'attribute' => 'id_penagih',
                                            'value' => function ($model) {
                                                return $model->penagih->nama_mitra_bisnis;
                                            }
                                        ],
                                        [
                                            'attribute' => 'id_pengirim',
                                            'value' => function ($model) {
                                                return $model->pengirim->nama_mitra_bisnis;
                                            }
                                        ],
                                        // [
                                        //     'attribute' => 'the_approver',
                                        //     'format' => 'raw',
                                        //     'value' => function ($model) {
                                        //         if (!empty($model->login->nama)) {
                                        //             # code...
                                        //             $retVal = ($model->status == 2) ? 'Approved : ' : 'Ditolak : ';
                                        //             $retValColor = ($model->status == 2) ? 'success : ' : 'danger : ';
                                        //             return $model->login->nama
                                        //                 . '<br>' .
                                        //                 "<span class='label label-$retValColor'>" . $retVal . "" . tanggal_indo2(date('D, d F Y H:i', strtotime($model->tanggal_approve))) . "</span>";
                                        //         } else {
                                        //             # code...
                                        //             return "<span class='label label-default'>Belum Ada Tanggapan</span>";
                                        //         }
                                        //     }
                                        // ],
                                        [
                                            'attribute' => 'status',
                                            'format' => 'raw',
                                            'value' => function ($model) {
                                                $retValStatus = ($model->status == 2) ? 'Disetujui pada ' : 'Ditolak pada ';
                                                $retValColor = ($model->status == 2) ? 'success pada ' : 'danger pada ';
                                                if ($model->status == 1) {
                                                    # code...
                                                    return "<span class='label label-warning'>Belum Disetujui</span>";
                                                } elseif ($model->status == 2) {
                                                    # code...
                                                    return "<span class='label label-$retValColor'>" . $retValStatus . "" . tanggal_indo2(date('D, d F Y H:i', strtotime($model->tanggal_approve))) . " oleh " . $model->login->nama . "</span>";
                                                } elseif ($model->status == 3) {
                                                    # code...
                                                    return "<span class='label label-$retValColor'>" . $retValStatus . "" . tanggal_indo2(date('D, d F Y H:i', strtotime($model->tanggal_approve))) . " oleh " . $model->login->nama . "</span>";
                                                }
                                            }
                                        ],
                                    ],
                                ]) ?>
                            </div>
                        </div>

                        <div class="" style="margin-top:20px;">
                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#data-barang-penjualan"><span class="fa fa-box"></span> Data Barang Penawaran Penjualan</a></li>
                            </ul>
                            <div class="tab-content">

                                <div id="data-barang-penjualan" class="tab-pane fade in active" style="margin-top:20px;">
                                    <div class="row">
                                        <div class="col-md-12">

                                            <?php
                                            if ($model->status == 1) {
                                                # code...
                                            ?>
                                                <div class="row">

                                                    <?php $form = ActiveForm::begin([
                                                        'method' => 'post',
                                                        'action' => ['akt-penawaran-penjualan-detail/create-from-penawaran-penjualan'],
                                                    ]); ?>

                                                    <?= $form->field($model_penawaran_penjualan_detail_baru, 'id_penawaran_penjualan')->textInput(['readonly' => true, 'type' => 'hidden'])->label(FALSE) ?>

                                                    <div class="col-md-4">
                                                        <?= $form->field($model_penawaran_penjualan_detail_baru, 'id_item_stok')->widget(Select2::classname(), [
                                                            'data' => $data_item_stok,
                                                            'language' => 'en',
                                                            'options' => ['placeholder' => 'Pilih Barang', 'id' => 'id_item_stok'],
                                                            'pluginOptions' => [
                                                                'allowClear' => true
                                                            ],
                                                        ])
                                                        ?>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <?= $form->field($model_penawaran_penjualan_detail_baru, 'id_item_harga_jual')->widget(DepDrop::classname(), [
                                                            'type' => DepDrop::TYPE_SELECT2,
                                                            'options' => ['id' => 'id-harga-jual', 'placeholder' => 'Pilih Jenis...'],
                                                            'select2Options' => ['pluginOptions' => ['allowClear' => true]],
                                                            'pluginOptions' => [
                                                                'depends' => ['id_item_stok'],
                                                                'url' => Url::to(['/akt-penawaran-penjualan/level-harga'])
                                                            ]
                                                        ])->label('Jenis');
                                                        ?>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <?= $form->field($model_penawaran_penjualan_detail_baru, 'harga')->textInput(["placeholder" => "Harga", "id" => "harga"]) ?>
                                                    </div>

                                                    <div class="col-md-1">
                                                        <?= $form->field($model_penawaran_penjualan_detail_baru, 'qty')->textInput(["placeholder" => "Qty", "id" => "qty"]) ?>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <?= $form->field($model_penawaran_penjualan_detail_baru, 'diskon')->textInput(["placeholder" => "Diskon %", "id" => "diskon"]) ?>
                                                    </div>

                                                    <div class="col-md-10">
                                                        <?= $form->field($model_penawaran_penjualan_detail_baru, 'keterangan')->textarea(["placeholder" => "Keterangan", "id" => "keterangan", 'rows' => 1])->label(FALSE) ?>
                                                    </div>

                                                    <div class="col-md-2">
                                                        <button type="submit" class="btn btn-success col-md-12"><span class="glyphicon glyphicon-plus"></span> Tambahkan</button>
                                                        <!-- <button type="reset" class="btn btn-danger"><span class="glyphicon glyphicon-remove-sign"></span> Reset</button> -->
                                                    </div>

                                                    <?php ActiveForm::end(); ?>
                                                </div>
                                            <?php } ?>

                                            <table class="table" style="overflow-x: scroll;">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 1%;">No.</th>
                                                        <th style="width: 20%;">Nama Barang</th>
                                                        <th style="width: 10%;">Jenis</th>
                                                        <th style="width: 10%;">Qty</th>
                                                        <th style="width: 10%;">Harga</th>
                                                        <th style="width: 10%;">Diskon %</th>
                                                        <th style="width: 25%;">Keterangan</th>
                                                        <th style="width: 10%;">Sub Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $no = 1;
                                                    $totalan_sub_total = 0;
                                                    $pp_detail = AktPenawaranPenjualanDetail::find()->where(['id_penawaran_penjualan' => $model->id_penawaran_penjualan])->all();
                                                    foreach ($pp_detail as $key => $d) {
                                                        # code...
                                                        $harga_jual = AktItemHargaJual::findOne($d['id_item_harga_jual']);
                                                        $level_harga = AktLevelHarga::findOne($harga_jual->id_level_harga);
                                                        $totalan_sub_total += $d['sub_total'];
                                                    ?>
                                                        <tr>
                                                            <td><?= $no++ ?></td>
                                                            <td><?= $d->item_stok->item['nama_item'] ?></td>
                                                            <td><?= $level_harga->keterangan ?></td>
                                                            <td><?= $d['qty'] ?></td>
                                                            <td align="right"><?= ribuan($d['harga']) ?></td>
                                                            <td><?= $d['diskon'] ?></td>
                                                            <td><?= $d['keterangan'] ?></td>
                                                            <td align="right"><?= ribuan($d['sub_total']) ?></td>
                                                            <?php
                                                            if ($model->status == 1) {
                                                            ?>
                                                                <td style="width:15%;" align="right">
                                                                    <p>
                                                                        <?= Html::a('<span class="glyphicon glyphicon-edit btn btn-sm btn-primary"></span>', ['akt-penawaran-penjualan-detail/update', 'id' => $d['id_penawaran_penjualan_detail']]) ?>
                                                                    </p>
                                                                    <p>
                                                                        <?= Html::a('<span class="glyphicon glyphicon-trash btn btn-sm btn-danger"></span>', ['akt-penawaran-penjualan-detail/delete', 'id' => $d['id_penawaran_penjualan_detail']], [
                                                                            'data' => [
                                                                                'confirm' => 'Are you sure you want to delete this item?',
                                                                                'method' => 'post',
                                                                            ],
                                                                        ]) ?>
                                                                    </p>
                                                                </td>
                                                            <?php } ?>
                                                        </tr>
                                                    <?php } ?>

                                                    <?= Html::beginForm(['view', 'aksi' => 'simpan_grand_total', 'id' => Yii::$app->request->get('id')], 'post') ?>
                                                    <tr>
                                                        <th colspan="8" style="text-align: right;">Total</th>
                                                        <td align="right"><b id="subtotal">
                                                                <?= ribuan($totalan_sub_total) ?></b>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <th colspan="8" style="text-align: right;">Diskon</th>
                                                        <td align="right" style="width: 10%;">
                                                            <?php
                                                            if ($model->status == 1) {
                                                                # code...
                                                            ?>
                                                                <input type="number" name="diskon" id="diskon_total" class="form-control" placeholder="Diskon %" value="<?= $model->diskon ?>" />
                                                            <?php } ?>
                                                            <?php
                                                            $nilai_diskon = ($totalan_sub_total * $model->diskon) / 100;
                                                            echo ribuan($nilai_diskon);
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th colspan="8" style="text-align: right;">Pajak 10%</th>
                                                        <td align="right">
                                                            <?php
                                                            if ($model->status == 1) {
                                                                # code...
                                                            ?>
                                                                <?php
                                                                if ($model->pajak == 10) {
                                                                    $check = 'checked';
                                                                } else {
                                                                    $check = '';
                                                                }
                                                                ?>
                                                                <input type="checkbox" id="pajak" name="pajak" <?= $check ?> value="1" />
                                                                <br>
                                                            <?php } ?>
                                                            <?php
                                                            $nilai_diskon = ($totalan_sub_total * $model->diskon) / 100;
                                                            $nilai_pajak = ($model->pajak > 0) ? (($totalan_sub_total - $nilai_diskon) * $model->pajak) / 100 : 0;
                                                            echo ribuan($nilai_pajak);
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th colspan="8" style="text-align: right;">Grand Total</th>
                                                        <td align="right"><?= ribuan($model->total) ?></td>
                                                    </tr>
                                                    <?php
                                                    if ($model->status == 1) {
                                                        # code...
                                                    ?>
                                                        <tr>
                                                            <td colspan="8"></td>
                                                            <td>
                                                                <button class="btn btn-success col-md-12"><span class="glyphicon glyphicon-floppy-saved"></span> Simpan</button>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                    <?= Html::endForm() ?>
                                                </tbody>
                                            </table>

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
</div>

<?php
$script = <<< JS

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
        url:'index.php?r=akt-penawaran-penjualan/get-harga-item',
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

<!-- <script>
    let grandTotal = document.querySelector('#grandtotal');
    let subTotal = document.querySelector('#subtotal').innerHTML;
    let pajakHtml = document.querySelector('#pajak');
    let subTotalInt = parseInt(subTotal);
    let diskon = document.querySelector('#diskon_total');

    function disk(pajakVal = 0, diskonVal = 0) {
        let diskonPersen = diskonVal / 100 * subTotal;
        grandTotal.value = `${subTotal-diskonPersen+pajakVal}`;
    }

    function diskonCek(pajakVal = 0) {
        diskon.addEventListener("input", () => {
            if (diskon.value > 0) {
                pajakHtml.onchange = function() {
                    if (pajakHtml.checked === true) {
                        let diskonPersen = diskon.value / 100 * subTotal;
                        let total = subTotal - diskonPersen;
                        let pajak = total * 10 / 100;
                        grandTotal.value = `${subTotal-diskonPersen+pajak}`;

                    } else if (pajakHtml.checked === false) {
                        disk(0, diskon.value)
                    }
                }
            }
            disk(0, diskon.value)
        })
    }

    function pajakCek() {
        pajakHtml.onchange = function() {
            if (pajakHtml.checked === true) {
                let pajak = subTotal * 10 / 100;
                disk(pajak, 0);
                diskon.addEventListener("input", () => {
                    if (diskon.value > 0) {
                        let diskonPersen = diskon.value / 100 * subTotal;
                        let total = subTotal - diskonPersen;
                        let pajak = total * 10 / 100;
                        grandTotal.value = `${subTotal-diskonPersen+pajak}`;
                    }
                })
            } else if (pajakHtml.checked === false) {
                disk(0, 0);
            }
        };
    }


    function setup() {
        pajakCek();
        diskonCek();
    }

    setup();
</script> -->