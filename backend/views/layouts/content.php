<?php

use yii\widgets\Breadcrumbs;
use dmstr\widgets\Alert;
use pa3py6aka\yii2\ModalAlert;

?>
<div class="content-wrapper">
    <section class="content-header hidden">
        <?php if (isset($this->blocks['content-header'])) { ?>
            <h1><?= $this->blocks['content-header'] ?></h1>
        <?php } else { ?>
            <h1>
                <?php
                if ($this->title !== null) {
                    //echo \yii\helpers\Html::encode($this->title);
                } else {
                    echo \yii\helpers\Inflector::camel2words(
                        \yii\helpers\Inflector::id2camel($this->context->module->id)
                    );
                    echo ($this->context->module->id !== \Yii::$app->id) ? '<small>Module</small>' : '';
                } ?>
            </h1>
        <?php } ?>

        <?=
            Breadcrumbs::widget(
                [
                    'links' =>
                    isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : []

                ]
            ) ?>
    </section>

    <section class="content" style="padding: 0;padding-left: 15px;padding-right: 15px; padding-bottom: 15px;">
        <?php //"<br>".Alert::widget() 
        ?>

        <?= ModalAlert::widget([
            'popupCssClass' => 'my-custom-class',
            // 'popupView' => '@app/views/common/my-custom-alert',
        ]) ?>

        <?= $content ?>
    </section>
</div>