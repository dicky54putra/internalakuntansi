<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\AktMitraBisnisAlamat */

$this->title = $model->id_mitra_bisnis_alamat;
$this->params['breadcrumbs'][] = ['label' => 'Akt Mitra Bisnis Alamats', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="akt-mitra-bisnis-alamat-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_mitra_bisnis_alamat], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_mitra_bisnis_alamat], [
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
            'id_mitra_bisnis_alamat',
            'id_mitra_bisnis',
            'keterangan_alamat:ntext',
            'alamat_lengkap:ntext',
            'id_kota',
            'telephone',
            'fax',
            'kode_pos',
            'alamat_pengiriman_penagihan',
        ],
    ]) ?>

</div>
