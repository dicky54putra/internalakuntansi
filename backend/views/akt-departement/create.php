<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktDepartement */

$this->title = 'Tambah Daftar Departemen';
// $this->params['breadcrumbs'][] = ['label' => 'Daftar Departement', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="akt-departement-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb"><li><a href="/">Home</a></li>
        <li><?= Html::a('Daftar Departemen', ['akt-departement/index']) ?></li>
        <li class="active">Tambah Daftar Departemen</li>
    </ul>
    <?= $this->render('_form', [
        'model' => $model,
        'nomor' => $nomor,
    ]) ?>

</div>
