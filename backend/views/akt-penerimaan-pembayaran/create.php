<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPenerimaanPembayaran */

$this->title = 'Tambah Data Penerimaan Pembayaran';
// $this->params['breadcrumbs'][] = ['label' => 'Akt Penerimaan Pembayarans', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="akt-penerimaan-pembayaran-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Data Penerimaan Pembayaran', ['index']) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>