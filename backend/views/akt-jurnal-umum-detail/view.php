<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\AktJurnalUmumDetail */

$this->title = $model->id_jurnal_umum_detail;
$this->params['breadcrumbs'][] = ['label' => 'Akt Jurnal Umum Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="akt-jurnal-umum-detail-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_jurnal_umum_detail], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_jurnal_umum_detail], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id_jurnal_umum_detail',
            'id_jurnal_umum',
            'id_akun',
            'debit',
            'kredit',
            'keterangan:ntext',
        ],
    ]) ?>

</div>
