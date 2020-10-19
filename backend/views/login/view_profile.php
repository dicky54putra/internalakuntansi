<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Login */
/* @var $form yii\widgets\ActiveForm */

$this->title = "Login Profile";
?>
<h1><?= Html::encode($this->title) ?></h1>
<div class="box">
    <div class="box-header">
        <div class="col-md-4" style="padding: 0;">
            <div class="box-body">

                <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

                <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

                <?php

                $model->password = "";
                echo

                    '
                    <div class="form-group field-login-password">
                    <label class="control-label cek" for="login-password">Password</label> 
                    <div class="form-group">
                        <div class="input-group">
                            <input type="password" id="login-password" class="form-control pass" name="Login[password]" value="" maxlength="32">
                            <div class="input-group-addon lihat"><span class="glyphicon glyphicon-eye-open"></span></div>
                        </div>
                    </div>
                    </div>
                '

                ?>
                <?= $form->field($model, 'nama')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'foto')->fileInput() ?>

                <?php
                if ($model->foto != "") {
                    echo "<img src='upload/$model->foto' width='150'>";
                }
                ?>

                <div class="form-group"><br>
                    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>
</div>

<?php

$script = <<< JS

$(document).ready(function(){		
	    $(".lihat").on('click',function() {
            if ($(".pass").attr('type') === 'password') {
                $(".pass").attr('type', 'text');
            } else {
                $(".pass").attr('type', 'password');
            }
        });
	});

JS;

$this->registerJs($script);

?>
