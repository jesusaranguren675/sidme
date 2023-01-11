<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Almacengeneral */
/* @var $form yii\widgets\ActiveForm */
?>

    <?php $form = ActiveForm::begin([
            'enableClientValidation' => false,
            'enableAjaxValidation' => false,]); ?>

    <input id="idal_gral_update" type="hidden" value="">

    <?= $form->field($model, 'cantidad')->textInput(['id' => 'cantidad-update']) ?>

    <?php ActiveForm::end(); ?>

