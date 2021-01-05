<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\AktBomDetailBb */

$this->title = $model->id_bom_detail_bb;
$this->params['breadcrumbs'][] = ['label' => 'Akt Bom Detail Bbs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="akt-bom-detail-bb-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_bom_detail_bb], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_bom_detail_bb], [
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
            'id_bom_detail_bb',
            'id_bom',
            'id_item',
            'qty',
            'harga',
            'keterangan:ntext',
        ],
    ]) ?>

</div>
