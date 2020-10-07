<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPenerimaanPembelian */

$this->title = $model->id_penerimaan_pembelian;
$this->params['breadcrumbs'][] = ['label' => 'Akt Penerimaan Pembelians', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="akt-penerimaan-pembelian-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_penerimaan_pembelian], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_penerimaan_pembelian], [
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
            'id_penerimaan_pembelian',
            'no_penerimaan',
            'no_ref',
            'tanggal',
            'id_supplier',
            'id_penerima',
            'status_invoiced',
            'keterangan:ntext',
            'id_cabang',
            'draft',
        ],
    ]) ?>

</div>
