<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\AktMitraBisnisKontak */

$this->title = $model->id_mitra_bisnis_kontak;
$this->params['breadcrumbs'][] = ['label' => 'Akt Mitra Bisnis Kontaks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="akt-mitra-bisnis-kontak-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_mitra_bisnis_kontak], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_mitra_bisnis_kontak], [
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
            'id_mitra_bisnis_kontak',
            'id_mitra_bisnis',
            'nama_kontak',
            'jabatan',
            'handphone',
            'email:email',
        ],
    ]) ?>

</div>
