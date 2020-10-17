<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\PengaturanSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pengaturan';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pengaturan-index">

    <h1 style="margin-bottom:20px;"><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'nama_pengaturan',
            [
                'attribute' => 'status',
                'format' => 'raw',
                'filter' => array(
                    0 => 'Tidak Aktif',
                    1 => 'Aktif',
                ),
                'value' => function ($model) {
                    if ($model->status == 1) {
                        # code...
                        return "<span class='label label-success'>Aktif</span>";
                    } elseif ($model->status == 0) {
                        return "<span class='label label-default'>Tidak Aktif</span>";
                    }
                }
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Aksi',
                'headerOptions' => ['style' => 'color:#337ab7'],
                'template' => "{update}",
                'buttons' => [
                    'update' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-edit"></span> Ubah Status', ['#'], [
                            'data-value' => $model->status,
                            'data-id' => $model->id_pengaturan,
                            'class' => 'btn btn-info',
                            'id' => 'btn-ubah',
                            'data-toggle' => 'modal',
                            'data-target' => '#modal-ubah-status'
                        ]);
                    }

                ],
            ],
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
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<span class="fa fa-database"></span> Pengaturan',
        ],
        'persistResize' => false,
        'toggleDataOptions' => ['minCount' => 100],
        'autoXlFormat' => true,
        'toggleDataContainer' => ['class' => 'btn-group mr-2'],
    ]); ?>
</div>

<div class="modal fade" id="modal-ubah-status">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Ubah Status</h4>
            </div>
            <p id="isidetail"></p>
            <?php $form = ActiveForm::begin([
                'method' => 'post',
                'action' => ['update'],
            ]); ?>
            <div class="modal-body">
                <input type="hidden" name="id" id="id_pengaturan">
                <?= $form->field($model, 'status', ['options' => ['id' => 'field-status']])->dropDownList(array(
                    0 => 'Tidak Aktif',
                    1 => 'Aktif',
                ), ['prompt' => 'Pilih Status']) ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success"> Simpan</button>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

<?php
$script = <<< JS
    $(document).ready(function() {

    $("a#btn-ubah" ).each(function(index) {
        $(this).on("click", function(){
            var target = $(this).data("value"); 
            var id_pengaturan = $(this).data("id"); 
            var status = $('#pengaturan-status').val(target);
            var id = $('#id_pengaturan').val(id_pengaturan);
        });
    });
});
JS;
$this->registerJs($script);
?>