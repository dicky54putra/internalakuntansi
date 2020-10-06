<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\AktProduksiManualDetailHp */

$this->title = $model->id_produksi_manual_detail_hp;
$this->params['breadcrumbs'][] = ['label' => 'Akt Produksi Manual Detail Hps', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="akt-produksi-manual-detail-hp-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_produksi_manual_detail_hp], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_produksi_manual_detail_hp], [
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
            'id_produksi_manual_detail_hp',
            'id_produksi_manual',
            'id_item_stok',
            'qty',
            'keterangan:ntext',
        ],
    ]) ?>

</div>
