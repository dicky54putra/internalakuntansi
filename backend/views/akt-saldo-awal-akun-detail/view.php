<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\AktSaldoAwalAkunDetail */

$this->title = $model->id_saldo_awal_akun_detail;
$this->params['breadcrumbs'][] = ['label' => 'Akt Saldo Awal Akun Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="akt-saldo-awal-akun-detail-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_saldo_awal_akun_detail], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_saldo_awal_akun_detail], [
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
            'id_saldo_awal_akun_detail',
            'id_saldo_awal_akun',
            'id_akun',
            'debet',
            'kredit',
        ],
    ]) ?>

</div>
