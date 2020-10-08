<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktDepartement */

$this->title = 'Ubah Daftar Departemen : ' . $model->kode_departement;
// $this->params['breadcrumbs'][] = ['label' => 'Daftar Departemens', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->id_departement, 'url' => ['view', 'id' => $model->id_departement]];
// $this->params['breadcrumbs'][] = 'Update';
?>
<div class="akt-departement-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb"><li><a href="/">Home</a></li>
        <li><?= Html::a('Daftar Departemen', ['akt-departement/index']) ?></li>
        <li class="active">Ubah Daftar Departemen</li>
    </ul>
    <?= $this->render('_form', [
        'model' => $model,
        'nomor' => $nomor,
    ]) ?>

</div>
