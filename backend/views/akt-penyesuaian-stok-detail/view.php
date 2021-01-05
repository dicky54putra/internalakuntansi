<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPenyesuaianStokDetail */

$this->title = $model->id_penyesuaian_stok_detail;
$this->params['breadcrumbs'][] = ['label' => 'Akt Penyesuaian Stok Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="akt-penyesuaian-stok-detail-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_penyesuaian_stok_detail], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_penyesuaian_stok_detail], [
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
            'id_penyesuaian_stok_detail',
            'id_penyesuaian_stok',
            'id_item',
            'qty',
            'hpp',
            'id_gudang',
        ],
    ]) ?>

</div>
