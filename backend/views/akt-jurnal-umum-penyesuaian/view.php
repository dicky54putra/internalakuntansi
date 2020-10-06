<?php

use backend\models\AktJurnalUmumDetail;
use backend\models\AktAkun;
use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model backend\models\AktJurnalUmum */

$this->title = 'Detail Data Jurnal Penyesuaian : ' . $model->no_jurnal_umum;
// $this->params['breadcrumbs'][] = ['label' => 'Akt Jurnal Umums', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="akt-jurnal-umum-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Daftar Jurnal Penyesuaian', ['index']) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['index'], ['class' => 'btn btn-warning']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-edit"></span> Ubah', ['update', 'id' => $model->id_jurnal_umum], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-trash"></span> Hapus', ['delete', 'id' => $model->id_jurnal_umum], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <div class="box">
        <div class="panel panel-primary">
            <div class="panel-heading"><span class="fa fa-edit"></span> <?= $this->title ?></div>
            <div class="panel-body">
                <div class="col-md-12" style="padding: 0;">
                    <div class="box-body">
                        <?= DetailView::widget([
                            'model' => $model,
                            'attributes' => [
                                // 'id_jurnal_umum',
                                'no_jurnal_umum',
                                // 'tanggal',
                                [
                                    'attribute' => 'tanggal',
                                    'format' => 'raw',
                                    'value' => function ($model) {
                                        return tanggal_indo($model->tanggal);
                                    }
                                ],
                                // 'tipe',
                                [
                                    'attribute' => 'tipe',
                                    'value' => function ($model) {
                                        if ($model->tipe == 2) {
                                            return 'Jurnal Penyesuaian';
                                        }
                                    }
                                ]
                            ],
                        ]) ?>
                    </div>
                    <div class="" style="margin-top:20px;">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#data-barang-penjualan"><span class="fa fa-edit"></span> <?= $this->title ?></a></li>
                        </ul>
                        <div class="tab-content">

                            <div id="data-barang-penjualan" class="tab-pane fade in active" style="margin-top:20px;">
                                <div class="row">
                                    <div class="col-md-12">

                                        <div class="row">
                                            <?php $form = ActiveForm::begin([
                                                'method' => 'post',
                                                'action' => ['akt-jurnal-umum-penyesuaian-detail/create-from-jurnal-umum-penyesuaian'],
                                            ]); ?>

                                            <?= $form->field($model_jurnal_umum_detail, 'id_jurnal_umum')->textInput(['readonly' => true, 'type' => 'hidden'])->label(false) ?>

                                            <div class="col-md-6">
                                                <?= $form->field($model_jurnal_umum_detail, 'id_akun')->widget(Select2::classname(), [
                                                    'data' => $data_akun,
                                                    'language' => 'en',
                                                    'options' => ['placeholder' => 'Pilih Akun'],
                                                    'pluginOptions' => [
                                                        'allowClear' => true,
                                                        'tags' => true,
                                                        'tokenSeparators' => [',', ' '],
                                                        'maximumInputLength' => 10
                                                    ],
                                                ]) ?>
                                            </div>

                                            <div class="col-md-2">
                                                <?= $form->field($model_jurnal_umum_detail, 'debit')->widget(\yii\widgets\MaskedInput::className(), ['clientOptions' => ['alias' => 'decimal', 'groupSeparator' => '.', 'autoGroup' => true, 'removeMaskOnSubmit' => true, 'rightAlign' => false, 'min' => 0]]); ?>
                                            </div>

                                            <div class="col-md-2">
                                                <?= $form->field($model_jurnal_umum_detail, 'kredit')->widget(\yii\widgets\MaskedInput::className(), ['clientOptions' => ['alias' => 'decimal', 'groupSeparator' => '.', 'autoGroup' => true, 'removeMaskOnSubmit' => true, 'rightAlign' => false, 'min' => 0]]); ?>
                                            </div>

                                            <div class="col-md-2">
                                                <label>&nbsp;</label>
                                                <button type="submit" class="btn btn-success col-md-12"><span class="glyphicon glyphicon-plus"></span> Tambahkan</button>

                                            </div>

                                            <?php ActiveForm::end(); ?>
                                        </div>

                                        <table class="table table-condensed table-bordered">
                                            <thead>
                                                <tr>
                                                    <th style="width: 1%;">No.</th>
                                                    <th style="width: 10%;">No Akun</th>
                                                    <th>Nama Akun</th>
                                                    <th style="width: 15%; text-align: center;">Debit</th>
                                                    <th style="width: 15%; text-align: center;">Kredit</th>
                                                    <th style="width: 1%;">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $no = 1;
                                                $totalan_debit = 0;
                                                $totalan_kredit = 0;
                                                $jurnal_umum_detail = AktJurnalUmumDetail::find()->where(['id_jurnal_umum' => $model->id_jurnal_umum])->all();
                                                foreach ($jurnal_umum_detail as $key => $d) {
                                                    $akun = AktAkun::find()->where(['id_akun' => $d->id_akun])->one();

                                                    $totalan_debit += $d['debit'];
                                                    $totalan_kredit += $d['kredit'];
                                                ?>
                                                    <tr>
                                                        <td><?= $no++ ?></td>
                                                        <td style="white-space: nowrap;"><?= $akun->kode_akun ?></td>
                                                        <td style="white-space: nowrap;"><?= $akun->nama_akun ?></td>
                                                        <td style="text-align: right;"><?= ribuan($d['debit']) ?></td>
                                                        <td style="text-align: right;"><?= ribuan($d['kredit']) ?></td>
                                                        <td style="white-space: nowrap;">
                                                            <?= Html::a('<span class="glyphicon glyphicon-trash"></span>', ['akt-jurnal-umum-penyesuaian-detail/delete', 'id' => $d['id_jurnal_umum_detail']], [
                                                                'class' => 'btn btn-danger',
                                                                'data' => [
                                                                    'confirm' => 'Are you sure you want to delete this item?',
                                                                    'method' => 'post',
                                                                ],
                                                            ]) ?>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                            <tfoot>
                                                <th colspan="3">Total</th>
                                                <th style="text-align: right;"><?= ribuan($totalan_debit) ?></th>
                                                <th style="text-align: right;"><?= ribuan($totalan_kredit) ?></th>
                                            </tfoot>
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

<?php

$script = <<< JS
    $(document).ready(function () {
        $('#aktjurnalumumdetail-kredit').focus(function () {
            $('#aktjurnalumumdetail-debit').attr('readonly', 'true');
            $('#aktjurnalumumdetail-debit').val('0');
            $('#aktjurnalumumdetail-kredit').removeAttr('readonly');
            // console.log('ok');
        })
        $('#aktjurnalumumdetail-debit').focus(function () {
            $('#aktjurnalumumdetail-kredit').attr('readonly', 'true');
            $('#aktjurnalumumdetail-kredit').val('0');
            $('#aktjurnalumumdetail-debit').removeAttr('readonly');
            // console.log('okd');
        })
    })
JS;

$this->registerJs($script);

?>