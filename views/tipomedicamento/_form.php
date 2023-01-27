<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Tipomedicamento */
/* @var $form yii\widgets\ActiveForm */
?>


<?php $form = ActiveForm::begin([
            'enableClientValidation' => false,
            'enableAjaxValidation' => false,]); ?>

    <div class="row">
        <div class="col-sm-12">
            <label for="tipomedicamento-descripcion">Nombre</label>
            <input id="tipomedicamento-descripcion" class="form-control" type="text" maxlength="30">
        </div>
    </div>

<?php ActiveForm::end(); ?>
