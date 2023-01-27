<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Roles */
/* @var $form yii\widgets\ActiveForm */
?>


    <?php $form = ActiveForm::begin(); ?>
    <input id="id_rol_update" type="hidden" value="">

    <input id="nombre_rol_update" class="form-control" maxlength="15" type="text">

    <?php ActiveForm::end(); ?>

