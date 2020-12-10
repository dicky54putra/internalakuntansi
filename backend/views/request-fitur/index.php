<?php

use yii\helpers\Html;
// use yii\grid\GridView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\RequestFiturSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Data Request Fitur';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="request-fitur-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

    <p>
        <?= Html::a('Create Request Fitur', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Actions',
                'headerOptions' => ['style' => 'color:#337ab7'],
                'template' => "{view} {update}",
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                            'title' => Yii::t('app', 'lead-view'),
                        ]);
                    },

                    'update' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                            'title' => Yii::t('app', 'lead-update'),
                        ]);
                    },
                    'delete' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                            'title' => Yii::t('app', 'lead-delete'),
                            'data' => [
                                'confirm' => 'Anda yakin ingin menghapus data?',
                            ],
                        ]);
                    },

                ],
                'urlCreator' => function ($action, $model, $key, $index) {
                    if ($action === 'view') {
                        $url = 'index.php?r=request-fitur/view&id=' . $model->id_request_fitur;
                        return $url;
                    }

                    if ($action === 'update') {
                        $url = 'index.php?r=request-fitur/update&id=' . $model->id_request_fitur;
                        return $url;
                    }

                    if ($action === 'delete') {
                        $url = 'index.php?r=request-fitur/delete&id=' . $model->id_request_fitur;
                        return $url;
                    }
                }
            ],

            // 'id_request_fitur',
            'tanggal',
            [
                'attribute' => 'status',
                'format' => 'raw',
                'filter' => array(
                    1 => "Submission",
                    2 => "On Progress",
                    3 => "Completed"
                ),
                'value' => function ($model) {
                    if ($model->status == 1) {
                        return "<p class='label label-danger'> Submission </p>";
                    } elseif ($model->status == 2) {
                        return "<p class='label label-info'> On Progress </p>";;
                    } else {
                        return "<p class='label label-success'> Completed </p>";;
                    }
                }
            ],
            [
                'attribute'  => 'id_login',
                'value'      => 'login.nama',
            ],

            'keterangan:ntext',



        ],
        'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
        'headerRowOptions' => ['class' => 'kartik-sheet-style'],
        'filterRowOptions' => ['class' => 'kartik-sheet-style'],
        //'pjax' => true, // pjax is set to always true for this demo
        // set your toolbar
        'toolbar' =>  [

            '{export}',
            '{toggleData}',
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
            'heading' => '',
        ],
        'persistResize' => false,
        'toggleDataOptions' => ['minCount' => 100],
        'exportConfig' => [
            GridView::EXCEL =>  [
                'filename' => 'Data_RequestFitur',
                'showPageSummary' => true,
            ]

        ],
    ]); ?>
</div>