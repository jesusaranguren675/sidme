<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Sede $model */
/** @var yii\widgets\ActiveForm $form */
?>


    <?php $form = ActiveForm::begin([
            'enableClientValidation' => false,
            'enableAjaxValidation' => false,]); ?>

    <div class="row">

        <input id="idsede-update" type="hidden">
        <div class="col-sm-6">
            <?= $form->field($model, 'nombre')->textInput(['maxlength' => true, 'id' => 'nombre-update']) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'ubicacion')->textInput(['maxlength' => true, 'id' => 'ubicacion-update']) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'telefono')->textInput(['maxlength' => true, 'id' => 'telefono-update']) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'correo')->textInput(['maxlength' => true, 'id' => 'correo-update']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
