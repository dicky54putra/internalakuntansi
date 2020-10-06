<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktCreditCard */

$this->title = 'Tambah Kartu Kredit';
// $this->params['breadcrumbs'][] = ['label' => 'Data Kartu Kredit', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="akt-credit-card-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb"><li><a href="/">Home</a></li>
        <li><?= Html::a('Daftar Kartu Kredit', ['akt-credit-card/index']) ?></li>
        <li class="active">Tambah Kartu Kredit</li>
    </ul>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
