<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\AktItemHargaJual */

$this->title = $model->id_item_harga_jual;
$this->params['breadcrumbs'][] = ['label' => 'Akt Harga Jual', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="akt-item-harga-jual-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-edit"></span> Ubah', ['update', 'id' => $model->id_item_harga_jual], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-trash"></span> Hapus', ['delete', 'id' => $model->id_item_harga_jual], [
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
            'id_item_harga_jual',
            'id_item',
            'id_mata_uang',
            'id_level_harga',
            'harga_satuan',
            'diskon_satuan',
        ],
    ]) ?>

</div>