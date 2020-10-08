<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktProduksiBomDetailHp */

$this->title = 'Create Akt Produksi Bom Detail Hp';
$this->params['breadcrumbs'][] = ['label' => 'Akt Produksi Bom Detail Hps', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="akt-produksi-bom-detail-hp-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
