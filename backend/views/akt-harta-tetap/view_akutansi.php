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
        <?php // if ($model->status == 1 && $model->umur_ekonomis == null) { 
        ?>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#setting-depresiasi">
            <span class="glyphicon glyphicon-edit"></span> Setting Depresiasi
        </button>

        <?php // } else if ($model->status == 1 && $model->umur_ekonomis != null) { 
        ?>
        <?= Html::a('<span class="glyphicon glyphicon-check"></span> Terjual', ['terjual', 'id' => $model->id_pembelian_harta_tetap_detail], [
            'class' => 'btn btn-success'
        ]) ?>

        <?php // } 
        ?>
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
                                            'label' => 'Tanggal Beli / Tanggal Pakai',
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
                                <table id="w3" class="table table-striped table-bordered detail-view">
                                    <tr>
                                        <th>Akumulasi Beban</th>
                                        <td class="akumulasi_beban_detail"></td>
                                    </tr>
                                    <tr>
                                        <th>Beban Tahun Ini</th>
                                        <td class="beban_tahun_ini_detail"></td>
                                    </tr>
                                    <tr>
                                        <th>Terhitung Tanggal</th>
                                        <td><?= tanggal_indo($model->terhitung_tanggal) ?></td>
                                    </tr>
                                    <tr>
                                        <th>Nilai Buku</th>
                                        <td class="nilai_buku_detail"></td>
                                    </tr>
                                    <tr>
                                        <th>Beban per Bulan</th>
                                        <td class="beban_per_bulan_detail"></td>
                                    </tr>
                                </table>
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
                            <?php $tgl = Yii::$app->db->createCommand("SELECT tanggal FROM akt_pembelian_harta_tetap WHERE id_pembelian_harta_tetap = '$model->id_pembelian_harta_tetap'")->queryScalar(); ?>
                            <?= $form->field($model, 'tanggal_pakai')->textInput(['readonly' => true, 'value' => $tgl])->label('Tanggal Pakai / Tanggal Beli') ?>
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
                            <div class="form-group field-aktpembelianhartatetapdetail-akumulasi_beban">
                                <label class="control-label" for="aktpembelianhartatetapdetail-akumulasi_beban">Akumulasi Beban</label>
                                <input type="text" id="aktpembelianhartatetapdetail-akumulasi_beban" class="form-control" readonly>
                                <div class="help-block"></div>
                            </div>
                            <div class="form-group field-aktpembelianhartatetapdetail-beban_tahun_ini">
                                <label class="control-label" for="aktpembelianhartatetapdetail-beban_tahun_ini">Beban Tahun Ini</label>
                                <input type="text" id="aktpembelianhartatetapdetail-beban_tahun_ini" class="form-control" readonly>
                                <div class="help-block"></div>
                            </div>
                            <div class="form-group field-aktpembelianhartatetapdetail-beban_per_bulan">
                                <label class="control-label" for="aktpembelianhartatetapdetail-beban_per_bulan">Beban per Bulan</label>
                                <input type="text" id="aktpembelianhartatetapdetail-beban_per_bulan" class="form-control" name="beban_per_bulan" readonly>
                                <div class="help-block"></div>
                            </div>
                            <div class="form-group field-aktpembelianhartatetapdetail-nilai_buku">
                                <label class="control-label" for="aktpembelianhartatetapdetail-nilai_buku">Nilai Buku</label>
                                <input type="text" id="aktpembelianhartatetapdetail-nilai_buku" class="form-control" readonly>
                                <div class="help-block"></div>
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

    if($model->id_kelompok_aset_tetap != null ) {
        $.get('index.php?r=akt-harta-tetap/get-akt-kelompok-harta-tetap',{ id : $model->id_kelompok_aset_tetap },function(data){
            var data = $.parseJSON(data);
                if(data.metode_depresiasi ==  2) {
                    var hp = $harga_perolehan - $model->residu;

                    var beban_per_bulan = hp / (data.umur_ekonomis * 12);
                    var beban_tahun_ini= hp / data.umur_ekonomis;

                    saveBeban(beban_per_bulan, beban_tahun_ini,hp, data.umur_ekonomis, type = 'Detail');

                    $('.beban_per_bulan_detail').text(formatNumber(beban_per_bulan));

                    $('#aktpembelianhartatetapdetail-beban_per_bulan').attr('value', formatNumber(beban_per_bulan));

                } else {
                    $('.beban_tahun_ini_detail').text(formatNumber(beban_tahun_ini));
                    $('.beban_per_bulan_detail').text(formatNumber(beban_per_bulan));
                }
        });
        
    }


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

                    saveBeban(beban_per_bulan, beban_tahun_ini,hp, data.umur_ekonomis, type = 'Input');

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

    function saveBeban(beban_bulan, beban_tahun, hp, umur_ekonomis, type){

        var tanggal = $('#aktpembelianhartatetapdetail-tanggal_pakai').val();

        var bulan = tanggal.substr(5,2)
        var _tahun = tanggal.substr(0,4);
        
        var tahun = parseInt(_tahun);

        var tahun_ekonomis = tahun + parseInt(umur_ekonomis);
        var date = new Date(); 
        var year = date.getFullYear(); // Jika Ingin Pengecekan Rubah Disini


        var selisih = 0;
        if(tahun == year ) {
            selisih = (12 - bulan + 1) /12;
        } else if (tahun != year && year != tahun_ekonomis ) {
            selisih = 12/12;
        } else if( year == tahun_ekonomis ) {
            selisih = bulan/12;
        }

        var beban_fix_tahun = beban_tahun * selisih; 

        // console.log('selisih', selisih );
        // console.log('beban_fix_tahun', beban_fix_tahun);
        
        $('#aktpembelianhartatetapdetail-beban_tahun_ini').attr('value', formatNumber(beban_fix_tahun));

        var akumulasi_beban = umur_ekonomis * beban_fix_tahun;
        var nilai_buku = hp - akumulasi_beban;

        $('#aktpembelianhartatetapdetail-akumulasi_beban').attr('value', formatNumber(akumulasi_beban));
        $('#aktpembelianhartatetapdetail-nilai_buku').attr('value', formatNumber(nilai_buku));

        if(type == 'Detail') {

            $('.beban_tahun_ini_detail').text(formatNumber(beban_fix_tahun));
            $('#aktpembelianhartatetapdetail-beban_tahun_ini').attr('value', formatNumber(beban_fix_tahun));
            $('.akumulasi_beban_detail').text(formatNumber(akumulasi_beban));
            $('.nilai_buku_detail').text(formatNumber(nilai_buku));
        }
    }

    function formatNumber(number) {
        let formatNumbering = new Intl.NumberFormat("id-ID");
        return formatNumbering.format(number);
    };


JS;
    $this->registerJs($script);
    ?>