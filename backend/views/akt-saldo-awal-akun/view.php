<?php

use backend\controllers\AktSaldoAwalAkunController;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use backend\models\AktAkun;
use backend\models\AktSaldoAwalAkunDetail;
/* @var $this yii\web\View */
/* @var $model backend\models\AktSaldoAwalAkun */

$this->title = 'Detail Saldo Awal Akun : ' . $model->no_jurnal;
\yii\web\YiiAsset::register($this);
?>
<div class="akt-saldo-awal-akun-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Daftar Saldo Awal Akun', ['index']) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['index'], ['class' => 'btn btn-warning']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-edit"></span> Ubah', ['update', 'id' => $model->id_saldo_awal_akun], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-trash"></span> Hapus', ['delete', 'id' => $model->id_saldo_awal_akun], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <div class="panel panel-primary">
        <div class="panel-heading"><span class="fa fa-bank"></span> <?= $this->title ?></div>
        <div class="panel-body">
            <div class="col-md-12" style="padding: 0;">
                <div class="box-body">
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'no_jurnal',
                            [
                                'attribute' => 'tanggal',
                                'value' => function ($model) {
                                    return tanggal_indo($model->tanggal);
                                }
                            ],
                            [
                                'attribute' => 'tipe',
                                'value' => function ($model) {
                                    if ($model->tipe == 1) {
                                        return 'Saldo Awal';
                                    }
                                }
                            ],
                        ],
                    ]) ?>
                    <div class="box box-success" style="margin:20px 0;"> </div>
                    <div class="" style="margin-top:20px;">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#pegawai"> <span class="fa fa-check"></span> Akun</a></li>
                        </ul>

                        <div class="tab-content">
                            <div class="row">
                                <div class="box-body" style="margin-top:10px;">
                                    <?php $form = ActiveForm::begin([
                                        'method' => 'post',
                                        'action' => ['akt-saldo-awal-akun-detail/create'],
                                    ]); ?>
                                    <?= $form->field($model_detail, 'id_saldo_awal_akun')->textInput(['readonly' => true, 'type' => 'hidden'])->label(FALSE) ?>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <?= $form->field($model_detail, 'id_akun')->widget(Select2::classname(), [
                                                'data' => $data_akun,
                                                'language' => 'en',
                                                'options' => ['placeholder' => 'Pilih Akun', 'id' => 'id-akun'],
                                                'pluginOptions' => [
                                                    'allowClear' => true
                                                ],
                                            ])->label('Pilih Akun');
                                            ?>
                                        </div>
                                        <div class="col-md-3" id="debet">
                                            <?= $form->field($model_detail, 'debet')->widget(\yii\widgets\MaskedInput::className(), [
                                                'clientOptions' => ['alias' => 'decimal', 'groupSeparator' => '.', 'autoGroup' => true, 'removeMaskOnSubmit' => true, 'rightAlign' => false, 'min' => 0],
                                            ]); ?>
                                        </div>
                                        <div class="col-md-3" id="kredit">
                                            <?= $form->field($model_detail, 'kredit')->widget(\yii\widgets\MaskedInput::className(), [
                                                'clientOptions' => ['alias' => 'decimal', 'groupSeparator' => '.', 'autoGroup' => true, 'removeMaskOnSubmit' => true, 'rightAlign' => false, 'min' => 0],
                                            ]); ?>
                                        </div>
                                        <div class="col-md-2">
                                            <button class="btn btn-success btn-tambah" style="width: 100%; margin-top:25px;"><span class="glyphicon glyphicon-plus"></span> Tambahkan</button>
                                        </div>
                                    </div>
                                    <?php ActiveForm::end(); ?>
                                </div>
                            </div>
                            <div id="pegawai" class="tab-pane fade in active">
                                <table class="table" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th width="40%">Nama Akun</th>
                                            <th width="20%">Debet</th>
                                            <th width="20%">Kredit</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        $query = AktSaldoAwalAkunDetail::find()->where(['id_saldo_awal_akun' => $model->id_saldo_awal_akun])->all();
                                        foreach ($query as $key => $data) {
                                            $akun = AktAkun::findOne($data['id_akun']);
                                        ?>
                                            <tr>
                                                <td><?= $no++ . '.' ?></td>
                                                <td><?= $akun->nama_akun ?></td>
                                                <td><?= ribuan($data['debet']) ?></td>
                                                <td><?= ribuan($data['kredit']) ?></td>
                                                <td>
                                                    <?= Html::a('<span class="glyphicon glyphicon-edit"></span>', ['akt-saldo-awal-akun-detail/update', 'id' => $data['id_saldo_awal_akun_detail']], ['class' => 'btn btn-primary']) ?>
                                                    <?= Html::a('<span class="glyphicon glyphicon-trash"></span>', ['akt-saldo-awal-akun-detail/delete', 'id' => $data['id_saldo_awal_akun_detail']], [
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

<?php
$script = <<< JS
    const debet = document.querySelector('#debet');
    const kredit = document.querySelector('#kredit');
    debet.style.display = 'none';
    kredit.style.display = 'none';
    $('#id-akun').on('change', function(){
        var id = $(this).val();
        $.ajax({
            url:'index.php?r=akt-saldo-awal-akun/get-saldo-normal',
            type : 'GET',
            data : 'id='+id,
            success : function(data){
                let dataJson = $.parseJSON(data);
                if(dataJson.saldo_normal === 1) {
                    debet.style.display = 'block';
                    $("#aktsaldoawalakundetail-debet").attr("required", "true");
                    $("#aktsaldoawalakundetail-kredit").removeAttr("required");
                    kredit.style.display = 'none';
                } else if (dataJson.saldo_normal === 2 ) {
                    kredit.style.display = 'block';
                    $("#aktsaldoawalakundetail-kredit").attr("required", "true");
                    $("#aktsaldoawalakundetail-debet").removeAttr("required");
                    debet.style.display = 'none';
                }
            }
        })
    })
     
JS;
$this->registerJs($script);
?>