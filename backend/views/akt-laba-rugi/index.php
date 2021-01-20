<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\AktLabaRugiSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Laporan Perubahan Ekuitas + Posisi Keuangan';
?>
<div class="akt-laba-rugi-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>


    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <div class="akt-laba-rugi-form">
        <div class="panel panel-primary">
            <div class="panel-heading"><span class="fa fa-file-text"></span> <?= $this->title; ?></div>
            <div class="panel-body">
                <div class="col-md-12" style="padding: 0;">
                    <div class="box-body">
                        <?php $form = ActiveForm::begin([
                            'method' => 'post',
                            'action' => ['create'],
                        ]); ?>
                        <div class="row">
                            <div class="col-md-4">
                                <?= $form->field($model, 'tanggal')->textInput(['value' => date("Y-m-d"), 'readonly' => true]) ?>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="setor">Setor Tambahan</label>
                                    <input type="number" name="setor_tambahan" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <?= $form->field($model, 'periode')->dropDownList(array(1 => 'Bulanan', 2 => 'Triwulan 1', 3 => 'Triwulan 2', 4 => 'Triwulan 3',  5 => 'Triwulan 4', 6 => 'Tahunan')) ?>
                            </div>
                        </div>
                        <div class="form-group" style="text-align:center; margin-top:10px;">
                            <?= Html::submitButton('<span class="glyphicon glyphicon-eye-open"></span> Preview', ['class' => 'btn btn-primary', 'name' => 'post_preview', 'formtarget' => '_blank']) ?>
                            <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> Simpan', ['class' => 'btn btn-success', 'name' => 'post_simpan']) ?>
                        </div>

                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'tanggal',
                'value' => function ($model) {
                    return tanggal_indo($model->tanggal);
                }
            ],
            [
                'attribute' => 'periode',
                'filter' => array(
                    1 => 'Bulanan',
                    2 => 'Triwulan 1',
                    3 => 'Triwulan 2',
                    4 => 'Triwulan 3',
                    5 => 'Triwulan 4',
                    6 => 'Tahunan'
                ),
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
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Aksi',
                'headerOptions' => ['style' => 'color:#337ab7'],
                'template' => "{view} {update} {delete}",
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('<button class = "btn btn-info"><span class="glyphicon glyphicon-eye-open"></span> Detail </button>', $url, [
                            'title' => Yii::t('app', 'lead-view'),
                        ]);
                    },

                    'update' => function ($url, $model) {
                        return Html::a('<button class = "btn btn-primary"><span class="glyphicon glyphicon-edit"></span> Ubah</button>', $url, [
                            'title' => Yii::t('app', 'lead-update'),
                        ]);
                    },
                    'delete' => function ($url, $model) {
                        return Html::a('<button class = "btn btn-danger"><span class="glyphicon glyphicon-trash"></span> Hapus</button>', $url, [
                            'title' => Yii::t('app', 'lead-delete'),
                            'data' => [
                                'confirm' => 'Anda yakin ingin menghapus data?',
                                'method' => 'post'
                            ],
                        ]);
                    },

                ],
                'urlCreator' => function ($action, $model, $key, $index) {
                    if ($action === 'view') {
                        $url = 'index.php?r=akt-laba-rugi/view&id=' . $model->id_laba_rugi;
                        return $url;
                    }

                    if ($action === 'update') {
                        $url = 'index.php?r=akt-laba-rugi/update&id=' . $model->id_laba_rugi;
                        return $url;
                    }

                    if ($action === 'delete') {
                        $url = 'index.php?r=akt-laba-rugi/delete&id=' . $model->id_laba_rugi;
                        return $url;
                    }
                }
            ],
        ],
        'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
        'headerRowOptions' => ['class' => 'kartik-sheet-style'],
        'filterRowOptions' => ['class' => 'kartik-sheet-style'],
        //'pjax' => true, // pjax is set to always true for this demo
        // set your toolbar
        'toolbar' =>  [

            // '{export}',
            // '{toggleData}',
        ],
        'toggleDataContainer' => ['class' => 'btn-group mr-2'],
        // set export properties
        'export' => [
            'fontAwesome' => true
        ],
        // parameters from the demo form
        //'bordered' => $bordered,
        //'striped' => $striped,
        //'condensed' => $condensed,
        //'responsive' => $responsive,
        //'hover' => $hover,
        //'showPageSummary' => $pageSummary,
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<span class="fa fa-file-text"></span> ' . $this->title,
        ],
        'persistResize' => false,
        'toggleDataOptions' => ['minCount' => 100],
        'autoXlFormat' => true,
        'toggleDataContainer' => ['class' => 'btn-group mr-2'],
        'export' => [
            'showConfirmAlert' => false,
            'target' => GridView::TARGET_BLANK
        ],
        'exportConfig' => [
            GridView::EXCEL =>  [
                'filename' => $this->title,
                'showPageSummary' => true,
            ]

        ],
    ]); ?>
</div>