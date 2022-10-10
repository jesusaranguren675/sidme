<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AlmacengeneralSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="almacengeneral-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'idal_gral') ?>

    <?= $form->field($model, 'idmedi') ?>

    <?= $form->field($model, 'descripcion') ?>

    <?= $form->field($model, 'cantidad') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
