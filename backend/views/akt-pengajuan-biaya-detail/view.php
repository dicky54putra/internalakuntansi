<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPengajuanBiayaDetail */

$this->title = $model->id_pengajuan_biaya_detail;
$this->params['breadcrumbs'][] = ['label' => 'Akt Pengajuan Biaya Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="akt-pengajuan-biaya-detail-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_pengajuan_biaya_detail], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_pengajuan_biaya_detail], [
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
            'id_pengajuan_biaya_detail',
            'id_pengajuan',
            'id_akun',
            'kode_rekening',
            'nama_pengajuan',
            'debit',
            'kredit',
        ],
    ]) ?>

</div>
