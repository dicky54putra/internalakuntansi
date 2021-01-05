<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\RequestFitur */

$this->title = 'Create Request Fitur';
$this->params['breadcrumbs'][] = ['label' => 'Request Fitur', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="request-fitur-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
