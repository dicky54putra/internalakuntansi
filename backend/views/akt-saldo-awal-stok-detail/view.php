<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\AktSaldoAwalStokDetail */

$this->title = $model->id_saldo_awal_stok_detail;
$this->params['breadcrumbs'][] = ['label' => 'Akt Saldo Awal Stok Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="akt-saldo-awal-stok-detail-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_saldo_awal_stok_detail], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_saldo_awal_stok_detail], [
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
            'id_saldo_awal_stok_detail',
            'id_saldo_awal_stok',
            'id_item',
            'id_item_stok',
            'qty',
        ],
    ]) ?>

</div>
