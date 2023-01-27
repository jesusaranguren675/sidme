<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model app\models\Pedidos */
/* @var $form yii\widgets\ActiveForm */

?>

<?php $form = ActiveForm::begin([
            'enableClientValidation' => false,
            'enableAjaxValidation' => false,]); ?>

    <input id="idtipo-update" type="hidden" value="">

    <div class="row">
        <div class="col-sm-12">
            <label for="tipomedicamento-descripcion-update">Nombre</label>
            <input id="tipomedicamento-descripcion-update" class="form-control" type="text" maxlength="30">
        </div>
    </div>

<?php ActiveForm::end(); ?>