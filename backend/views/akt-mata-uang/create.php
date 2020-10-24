<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktMataUang */

$this->title = 'Tambah Daftar Mata Uang';
?>
<div class="akt-Mata-Uang-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb"><li><a href="/">Home</a></li>
        <li><?= Html::a('Daftar Mata Uang', ['akt-mata-uang/index']) ?></li>
        <li class="active">Tambah Mata Uang</li>
    </ul>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>