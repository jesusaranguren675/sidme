<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Asignacionroles */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="asignacionroles-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_rol')->textInput() ?>

    <?= $form->field($model, 'id_usu')->textInput() ?>

    <?= $form->field($model, 'fecha')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
