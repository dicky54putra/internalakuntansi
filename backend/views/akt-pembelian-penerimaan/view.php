<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPembelianPenerimaan */

$this->title = $model->id_pembelian_penerimaan;
$this->params['breadcrumbs'][] = ['label' => 'Akt Pembelian Penerimaans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="akt-pembelian-penerimaan-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_pembelian_penerimaan], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_pembelian_penerimaan], [
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
            'id_pembelian_penerimaan',
            'no_penerimaan',
            'tanggal_penerimaan',
            'penerima',
            'foto_resi',
            'id_pembelian',
            'pengantar',
            'keterangan_pengantar:ntext',
        ],
    ]) ?>

</div>
