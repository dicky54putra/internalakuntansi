<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\ItemPermintaanPembelian */

$this->title = $model->id_item_permintaan_pembelian;
$this->params['breadcrumbs'][] = ['label' => 'Item Permintaan Pembelians', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="item-permintaan-pembelian-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_item_permintaan_pembelian], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_item_permintaan_pembelian], [
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
            'id_item_permintaan_pembelian',
            'id_permintaan_pembelian',
            'id_item',
            'quantity',
            'satuan',
            'id_departement',
            'id_proyek',
            'keterangan',
            'req_date',
        ],
    ]) ?>

</div>
