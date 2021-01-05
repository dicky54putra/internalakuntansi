<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktSatuan */

$this->title = 'Tambah Satuan';
?>
<div class="akt-satuan-create">

<h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb"><li><a href="/">Home</a></li>
        <li><?= Html::a('Daftar Satuan', ['akt-satuan/index']) ?></li>
        <li class="active">Tambah Satuan</li>
    </ul>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
