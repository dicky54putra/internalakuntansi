<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\AktPembelianHartaTetap;
use backend\models\AktKelompokHartaTetap;
use backend\models\AktAkun;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\AktHartaTetap */

$this->title = 'Detail Harta Tetap : ' .  $model->kode_pembelian;
// $this->params['breadcrumbs'][] = ['label' => 'Akt Harta Tetaps', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="akt-harta-tetap-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Daftar Harta Tetap', ['index-akutansi']) ?></li>
        <li class="active"><?= $model->kode_pembelian ?></li>
    </ul>


    <p>
        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['index-akutansi'], ['class' => 'btn btn-warning']) ?>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#setting-depresiasi">
            <span class="glyphicon glyphicon-edit"></span> Setting Depresiasi
        </button>
        <?= Html::a('<span class="glyphicon glyphicon-trash"></span> Hapus', ['delete', 'id' => $model->id_pembelian_harta_tetap_detail], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <div class="box">
        <div class="panel panel-primary">
            <div class="panel-heading"><span class="fa fa-car"></span> Detail Harga Tetap</div>
            <div class="panel-body">
                <div class="col-md-12" style="padding: 0;">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6">
                                <?= DetailView::widget([
                                    'model' => $model,
                                    'attributes' => [
                                        [
                                            'label' => 'Kode Pembelian',
                                            'value' => function ($model) {
                                                return $model->akt_pembelian_harta_tetap->no_pembelian_harta_tetap;
                                            }
                                        ],
                                        [
                                            // 'attribute' => 'kode_pembelian',
                                            'label' => 'Kode Harta',
                                            'value' => function ($model) {
                                                return $model->kode_pembelian;
                                            }
                                        ],
                                        [
                                            // 'attribute' => 'kode_pembelian',
                                            'label' => 'Nama Barang',
                                            'value' => function ($model) {
                                                return $model->nama_barang;
                                            }
                                        ],
                                    ],
                                ]) ?>
                            </div>
                            <div class="col-md-6">
                                <?= DetailView::widget([
                                    'model' => $model,
                                    'attributes' => [
                                        [
                                            'label' => 'Tanggal',
                                            'value' => function ($model) {
                                                return tanggal_indo($model->akt_pembelian_harta_tetap->tanggal);
                                            }
                                        ],
                                        [
                                            'label' => 'Harga Perolehan',
                                            'value' => function ($model) {
                                                $total = $model->qty * $model->harga;
                                                $diskon = $total * $model->diskon / 100;
                                                $sub_total = $total - $diskon;

                                                $akt_harta_tetap = AktPembelianHartaTetap::find()->where(['id_pembelian_harta_tetap' => $model->id_pembelian_harta_tetap])->one();
                                                $diskon_harta_tetap = $sub_total * $akt_harta_tetap->diskon / 100;

                                                $akt_harta_tetap->pajak == 0 ? $pajak = 0 : $pajak = ($sub_total - $diskon_harta_tetap) * 0.1;
                                                $harga_perolehan = $sub_total + $akt_harta_tetap->ongkir + $akt_harta_tetap->materai + $pajak - $diskon_harta_tetap;

                                                return ribuan($harga_perolehan);
                                            }
                                        ],
                                        [
                                            'label' => 'Status',
                                            'value' => function ($model) {

                                                if ($model->status == 1) {
                                                    # code...
                                                    return 'Ada';
                                                } else {
                                                    return 'Terjual';
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

            <div class="panel-heading" style="border:none; border-radius:0;"> Setting Depresiasi </div>
            <div class="panel-body">
                <div class="col-md-12" style="padding: 0;">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6">
                                <?= DetailView::widget([
                                    'model' => $model,
                                    'attributes' => [
                                        [
                                            'label' => 'Tipe Harta Tetap',
                                            'value' => function ($model) {
                                                if ($model->tipe_harta_tetap == 1) {
                                                    return 'Berwujud';
                                                } else if ($model->tipe_harta_tetap == 2) {
                                                    return 'Tidak Berwujud';
                                                } else {
                                                    return $model->tipe_harta_tetap;
                                                }
                                            }
                                        ],
                                        [
                                            'label' => 'Tanggal Pakai',
                                            'value' => function ($model) {
                                                if ($model->tanggal_pakai != null) {
                                                    return tanggal_indo($model->tanggal_pakai);
                                                } else {
                                                    return $model->tanggal_pakai;
                                                }
                                            }
                                        ],
                                        [
                                            'label' => 'Lokasi',
                                            'value' => function ($model) {
                                                return $model->lokasi;
                                            }
                                        ],
                                        [
                                            'label' => 'Kelompok Aset Tetap',
                                            'value' => function ($model) {
                                                $akt_kelompok_harta_tetap = AktKelompokHartaTetap::findOne($model->id_kelompok_aset_tetap);
                                                if ($model->id_kelompok_aset_tetap != null) {
                                                    return $akt_kelompok_harta_tetap->nama;
                                                } else {
                                                    return $model->id_kelompok_aset_tetap;
                                                }
                                            }
                                        ],
                                        [
                                            'label' => 'Umur Ekonomis ( Tahun )',
                                            'value' => function ($model) {
                                                return ribuan($model->umur_ekonomis);
                                            }
                                        ],
                                    ],
                                ]) ?>
                            </div>
                            <div class="col-md-6">
                                <?= DetailView::widget([
                                    'model' => $model,
                                    'attributes' => [
                                        [
                                            'label' => 'Akumulasi Beban',
                                            'value' => function ($model) {
                                                return ribuan($model->akumulasi_beban);
                                            }
                                        ],
                                        [
                                            'label' => 'Beban Tahun Ini',
                                            'value' => function ($model) {
                                                return ribuan($model->beban_tahun_ini);
                                            }
                                        ],
                                        [
                                            'label' => 'Terhitung Tanggal',
                                            'value' => function ($model) {
                                                if ($model->terhitung_tanggal != null) {
                                                    return tanggal_indo($model->terhitung_tanggal);
                                                } else {
                                                    return $model->terhitung_tanggal;
                                                }
                                            }
                                        ],
                                        [
                                            'label' => 'Nilai Buku',
                                            'value' => function ($model) {
                                                return ribuan($model->nilai_buku);
                                            }
                                        ],
                                        [
                                            'label' => 'Beban per Bulan',
                                            'value' => function ($model) {
                                                return ribuan($model->beban_per_bulan);
                                            }
                                        ]
                                    ],
                                ]) ?>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    @media (min-width: 992px) {
        .modal-content {
            margin: 0 -150px;
        }

    }
</style>
<div class="modal fade" id="setting-depresiasi">
    <div class="modal-dialog">
        <div class="modal-content modal-lg">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Setting Depresiasi</h4>
            </div>
            <div class="modal-body">
                <?php $form = ActiveForm::begin([
                    'action' => ['setting-depresiasi', 'id' => $model->id_pembelian_harta_tetap_detail],
                    'method' => 'post',
                    'options' => [
                        'class' => 'form-setting'
                    ]
                ]); ?>
                <div class="row">


                    <div class="col-md-6">

                        <div class="form-group">
                            <?php

                            $total = $model->qty * $model->harga;
                            $diskon = $total * $model->diskon / 100;
                            $sub_total = $total - $diskon;

                            $akt_harta_tetap = AktPembelianHartaTetap::find()->where(['id_pembelian_harta_tetap' => $model->id_pembelian_harta_tetap])->one();
                            $diskon_harta_tetap = $sub_total * $akt_harta_tetap->diskon / 100;

                            $akt_harta_tetap->pajak == 0 ? $pajak = 0 : $pajak = ($sub_total - $diskon_harta_tetap) * 0.1;
                            $harga_perolehan = $sub_total + $akt_harta_tetap->ongkir + $akt_harta_tetap->materai + $pajak - $diskon_harta_tetap;


                            if ($model->id_kelompok_aset_tetap != null) {
                                $akt_kelompok_harta_tetap = AktKelompokHartaTetap::findOne($model->id_kelompok_aset_tetap);
                                $akun_harta = AktAkun::findOne($akt_kelompok_harta_tetap['id_akun_harta']);
                                $akun_akumulasi = AktAkun::findOne($akt_kelompok_harta_tetap['id_akun_akumulasi']);
                                $akun_depresiasi = AktAkun::findOne($akt_kelompok_harta_tetap['id_akun_depresiasi']);
                            }

                            ?>
                            <label for="harga_perolehan">Harga Perolehan</label>
                            <input type="text" class="form-control" value="<?= ribuan($harga_perolehan) ?>" readonly>
                        </div>
                        <div class="form-group">
                            <?= $form->field($model, 'tipe_harta_tetap')->dropDownList(array(1 => "Berwujud", 2 => "Tidak Berwujud")) ?>
                        </div>
                        <div class="form-group">
                            <?= $form->field($model, 'lokasi')->textInput() ?>
                        </div>
                        <div class="form-group">
                            <?= $form->field($model, 'tanggal_pakai')->widget(\yii\jui\DatePicker::classname(), [
                                'clientOptions' => [
                                    'changeMonth' => true,
                                    'changeYear' => true,
                                ],
                                'dateFormat' => 'yyyy-MM-dd',
                                'options' => ['class' => 'form-control']
                            ]) ?>
                        </div>
                        <div class="form-group">
                            <?= $form->field($model, 'id_kelompok_aset_tetap')->widget(Select2::classname(), [
                                'data' => $data_akt_kelompok_harta_tetap,
                                'language' => 'en',
                                'options' => ['placeholder' => 'Pilih Kelompok Aset Tetap'],
                                'pluginOptions' => [
                                    'allowClear' => true,
                                    'class' => 'kelompok_aset'
                                ],
                            ])->label('Kelompok Aset Tetap');
                            ?>
                        </div>
                        <div class="form-group">
                            <?= $form->field($model, 'umur_ekonomis')->textInput()->label('Umur Ekonomis ( Tahun )') ?>
                        </div>

                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <?= $form->field($model, 'akumulasi_beban')->textInput(['readonly' => true, 'value' =>  $model->akumulasi_beban != null ? ribuan(($model->akumulasi_beban)) : '']) ?>
                        </div>
                        <div class="form-group">
                            <?= $form->field($model, 'beban_tahun_ini')->textInput(['readonly' => true, 'value' =>  $model->beban_tahun_ini != null ? ribuan(($model->beban_tahun_ini)) : '']) ?>
                        </div>
                        <div class="form-group">
                            <?= $form->field($model, 'beban_per_bulan')->textInput(['readonly' => true, 'value' =>  $model->beban_per_bulan != null ? ribuan(($model->beban_per_bulan)) : '']) ?>
                        </div>
                        <div class="form-group">
                            <?= $form->field($model, 'nilai_buku')->textInput(['readonly' => true, 'value' =>  $model->nilai_buku != null ? ribuan(($model->nilai_buku)) : '']) ?>
                        </div>
                        <div class="form-group">
                            <?= $form->field($model, 'terhitung_tanggal')->textInput(['value' => date('Y') . '-' . 12 . '-' . 31, 'readonly' => true]) ?>
                        </div>
                        <div class="form-group">
                            <label for="harga_perolehan">Akun Harta</label>
                            <input type="text" id="akun_harta" class="form-control" readonly value="<?= $model->id_kelompok_aset_tetap == null ? '' : $akun_harta['nama_akun'] ?>">
                        </div>
                        <div class="form-group">
                            <label for="harga_perolehan">Akun Akumulasi</label>
                            <input type="text" id="akun_akumulasi" class="form-control" readonly value="<?= $model->id_kelompok_aset_tetap == null ? '' : $akun_akumulasi['nama_akun'] ?>">
                        </div>
                        <div class=" form-group">
                            <label for="harga_perolehan">Akun Depresiasi</label>
                            <input type="text" id="akun_depresiasi" class="form-control" readonly value="<?= $model->id_kelompok_aset_tetap == null ? '' : $akun_depresiasi['nama_akun'] ?>">
                        </div>
                    </div>
                </div>


            </div>
            <div class=" modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-saved"></span> Simpan', ['class' => 'btn btn-success']) ?>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<?php
$script = <<< JS

    $('.form-setting').change(function(e){
        
        var id_form = e.target.id;

        if(id_form == 'aktpembelianhartatetapdetail-id_kelompok_aset_tetap') {
            var id = $('#aktpembelianhartatetapdetail-id_kelompok_aset_tetap').val();
            getHartaTetap(id);
        } 
    });


    function getHartaTetap(id) {

        $.get('index.php?r=akt-harta-tetap/get-akt-kelompok-harta-tetap',{ id : id },function(data){
                var data = $.parseJSON(data);
                if(data.metode_depresiasi ==  2) {
                    var hp = $harga_perolehan - $model->residu;

                    var beban_per_bulan = hp / (data.umur_ekonomis * 12);
                    var beban_tahun_ini= hp / data.umur_ekonomis;

                    saveBeban(beban_per_bulan, beban_tahun_ini,hp);

                    $('#aktpembelianhartatetapdetail-beban_tahun_ini').attr('value', formatNumber(beban_tahun_ini));
                    $('#aktpembelianhartatetapdetail-beban_per_bulan').attr('value', formatNumber(beban_per_bulan));

                } else {
                    $('#aktpembelianhartatetapdetail-beban_tahun_ini').attr('value',0);
                    $('#aktpembelianhartatetapdetail-beban_per_bulan').attr('value',0);
                }

                $('#aktpembelianhartatetapdetail-umur_ekonomis').attr('value',data.umur_ekonomis);
                $('#akun_harta').attr('value',data.akun_harta.nama_akun);
                $('#akun_akumulasi').attr('value',data.akun_akumulasi.nama_akun);
                $('#akun_depresiasi').attr('value',data.akun_depresiasi.nama_akun);
            
            });

    }

    function saveBeban(beban_bulan, beban_tahun, hp){

        var tanggal = $('#aktpembelianhartatetapdetail-tanggal_pakai').val();
        var bulan = tanggal.substr(5,2);

        var selisih = 12 - bulan;
        var akumulasi_beban = selisih * beban_bulan;
        var nilai_buku = hp - akumulasi_beban;

        $('#aktpembelianhartatetapdetail-akumulasi_beban').attr('value', formatNumber(akumulasi_beban));
        $('#aktpembelianhartatetapdetail-nilai_buku').attr('value', formatNumber(nilai_buku));
    }

    function formatNumber(number) {
        let formatNumbering = new Intl.NumberFormat("id-ID");
        return formatNumbering.format(number);
    };


JS;
$this->registerJs($script);
?>