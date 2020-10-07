<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktProduksiBomDetailBb */

$this->title = 'Create Akt Produksi Bom Detail Bb';
$this->params['breadcrumbs'][] = ['label' => 'Akt Produksi Bom Detail Bbs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="akt-produksi-bom-detail-bb-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
