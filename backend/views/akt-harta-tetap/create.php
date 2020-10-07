<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktHartaTetap */

$this->title = 'Tambah Harta Tetap';
// $this->params['breadcrumbs'][] = ['label' => 'Akt Harta Tetaps', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="akt-harta-tetap-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Daftar Harta Tetap', ['index']) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <?= $this->render('_form', [
        'model' => $model,
        'model_kelompok_harta_tetap' => $model_kelompok_harta_tetap
    ]) ?>

</div>