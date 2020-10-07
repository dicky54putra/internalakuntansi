<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktCreditCard */

$this->title = 'Ubah Kartu Kredit: ' . $model->nama_cc;
// $this->params['breadcrumbs'][] = ['label' => 'Data Kartu Kredit', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->id_cc, 'url' => ['view', 'id' => $model->id_cc]];
// $this->params['breadcrumbs'][] = 'Update';
?>
<div class="akt-credit-card-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb"><li><a href="/">Home</a></li>
        <li><?= Html::a('Daftar Kartu Kredit', ['akt-credit-card/index']) ?></li>
        <li class="active">Ubah Kartu Kredit</li>
    </ul>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
