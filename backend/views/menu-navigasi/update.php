<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\MenuNavigasi */

$this->title = 'Ubah Menu Navigasi: ' . $model->nama_menu;
// $this->params['breadcrumbs'][] = ['label' => 'Menu Navigasi', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->id_menu, 'url' => ['view', 'id' => $model->id_menu]];
// $this->params['breadcrumbs'][] = 'Ubah';
?>
<div class="menu-navigasi-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Daftar Menu Navigasi', ['index']) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <?= $this->render('_form', [
        'model' => $model,
        'menuParent' => $menuParent,
    ]) ?>

</div>