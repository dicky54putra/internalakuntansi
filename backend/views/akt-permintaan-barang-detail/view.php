<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPermintaanBarangDetail */

$this->title = $model->id_permintaan_barang_detail;
$this->params['breadcrumbs'][] = ['label' => 'Akt Permintaan Barang Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="akt-permintaan-barang-detail-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_permintaan_barang_detail], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_permintaan_barang_detail], [
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
            'id_permintaan_barang_detail',
            'id_permintaan_barang',
            'id_item',
            'qty',
            'qty_ordered',
            'qty_rejected',
            'keterangan:ntext',
            'request_date',
        ],
    ]) ?>

</div>
